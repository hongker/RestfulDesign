<?php
/**
 * 系统错误信息提示
 *
 * 0 没有错误
 * 1 ~ 99 系统级别错误
 * 100 ～ 999 内部调试错误
 * 1000 ~ 9999 业务层错误
 *
 * PHP version 7
 *
 * @category Config
 * @package  Configs
 * @author   hongker <xiaok2013@live.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://kaimen.cdxunhe.com/
 */
return array(
    0 => '服务正常',
    1 => '系统维护中',

    100 => '请求方式错误',
    101 => '数据不存在',
    102 => '添加数据失败',
    103 => '删除数据失败',
    104 => '修改数据失败',
    105 => '验证码错误,请重试',
    106 => '请求参数错误',
    107 => '权限问题',
    108 => '接口已停止使用，请更新至新版本',
    109 => '发送信息失败',
    110 => 'token失效',

    1001 => '用户名不能为空',
    1002 => '密码不能为空',
    1003 => '该用户名已被使用',
    1004 => '该用户不存在',
    1005 => '手机号格式不正确',
    1006 => '用户添加失败，请稍后再试',
    1007 => '该用户不存在',
    1008 => '密码错误',
    1009 => '密码更改失败',



    -1 => '没有找到对应的错误信息',
);