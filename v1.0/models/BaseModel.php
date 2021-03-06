<?php
namespace Core\Models;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;

/**
 * 基础Model类
 * @author hongker
 * @version 1.0
 */
class BaseModel extends Model {
	const DELETED = 1;


	const NOT_DELETED = 0;

	public $created_at;
	public $updated_at;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		$this->skipAttributes(array('created_at'));

		$this->skipAttributesOnCreate(array('updated_at','is_delete'));

		$this->setup(
				array('notNullValidations'=>false)
		);

		$this->addBehavior(
			new SoftDelete(
				array(
					'field' => 'is_delete',
					'value' => self::DELETED
				)
			)
		);
	}


	/**
	 * 插入前的操作
	 */
	public function beforeCreate() {
		$this->created_at = time();
	}

	/**
	 * 更新前的操作
	 */
	public function beforeUpdate() {
		$this->updated_at = time();
	}


	/**
	 * 验证字段是否合法
	 * @param array $array
	 * @return boolean
	 */
	protected function validateAll(Array $array) {
		foreach ($array as $validator) {
			if($this->validate($validator)==false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * 重写validate方法
	 * @param unknown $validator
	 * @return boolean
	 */
	public  function validate(\Phalcon\ValidationInterface  $validator=null) {
		parent::validate($validator);

		if ($this->validationHasFailed() == true) {
			return false;
		}
		return true;
	}

	/**
	 * 设置验证字段不能为空
	 * @param string $field 字段名称
	 * @param int $errNo 错误代码
	 * @return \Phalcon\Mvc\Model\Validator\PresenceOf
	 */
	protected function setPresenceOf($field,$errNo) {
		return new PresenceOf(array(
				"field" => $field,
				"message" => $errNo,
		));
	}

	/**
	 * 设置验证字段类型为邮箱
	 * @param string $field 字段名称
	 * @param int $errNo 错误代码
	 * @return \Phalcon\Mvc\Model\Validator\Email
	 */
	protected function setEmailValidator($field,$errNo) {
		return new EmailValidator(array(
				"field" => $field,
				"message" => $errNo,
		));
	}

	/**
	 * 设置验证字段不能重复
	 * @param string $field 字段名称
	 * @param int $errNo 错误代码
	 * @return \Phalcon\Mvc\Model\Validator\Uniqueness;
	 */
	protected function setUniqueness($field,$errNo) {
		return new Uniqueness(array(
				"field" => $field,
				"message" => $errNo,
		));
	}

}
