
drop table if exists temp;
create table temp (
  id int not null primary key auto_increment,

  is_delelte tinyint not null default 0,
  created_at int not null default 0,
  updated_at int not null default 0
)charset=utf8;
/**
 * 项目表
 * id 主键
 * app_id APPID
 * app_key APPKEY
 * app_secret APPSECRET
 * name 名称
 * address 地址
 * contacts 联系方式
 * type 项目类型(1:白蚁,2:其他)
 * state 状态(1:启用,2:停用)
 */
drop table if exists projects;
create table projects (
  id int not null primary key auto_increment,
  app_id char(16) not null,
  app_key char(32) not null,
  app_secret char(32) not null,
  name varchar(50) not null,
  address varchar(100) not null,
  contacts varchar(255) not null,
  type tinyint not null default 1,
  state tinyint not null default 1,
  is_delelte tinyint not null default 0,
  created_at int not null default 0,
  updated_at int not null default 0
)charset=utf8;

/**
 * 用户信息表（登录系统，登录小程序）
 * id 主键
 * username 用户名
 * password 密码
 * phone 手机号
 * department 部门
 * role_id 角色ID
 * 其他信息
 */

 drop table if exists users;
 create table users (
   id int not null primary key auto_increment,
   username varchar(30) not null,
   password char(64) not null,
   phone char(11) not null default '',
   department varchar(50) not null default '',
   role_id tinyint not null default 0,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;


 drop table if exists roles;
 create table roles (
   id int not null primary key auto_increment,
   name varchar(20) not null,
   remark varchar(255) not null,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;
 insert into roles(name,remark) values('Admin','超级管理员'),
   ('Manager','项目管理员'),
   ('User','施工人员');

 drop table if exists tokens;
 create table tokens (
   id int not null primary key auto_increment,
   token varchar(64) not null,
   user_id int not null,
   expire int not null,
   auth varchar(30) not null default '',
   logout_at int not null default 0,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;

/**
 * 项目用户关联表
 * id 主键
 * project_id 项目ID
 * user_id 用户名
 * state 状态
 */
drop table if exists project_managers;
create table project_managers(
  id int not null primary key auto_increment,
  project_id char(16) not null,
  user_id int not null,
  state tinyint not null default 1,
  is_delelte tinyint not null default 0,
  created_at int not null default 0,
  updated_at int not null default 0
)charset=utf8;

/**
 * 项目设备关联表 project_devices
 * id 主键
 * project_id 项目ID
 * type 设备类型(1:网关设备,2:终端设备)
 * code 设备编号
 * location 设备位置(精度，维度)
 * address 具体位置
 * state 状态
 */
 drop table if exists project_devices;
 create table project_devices (
   id int not null primary key auto_increment,
   project_id int not null,
   type tinyint not null,
   code char(10) not null,
   location varchar(50) not null,
   address varchar(100) not null,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;


/**
 * 网关设备表 gateways
 * id 主键
 * code 编号
 * state 状态(1,未出厂,2:已出厂)
 */
 drop table if exists gateways;
 create table gateways (
   id int not null primary key auto_increment,
   code char(10) not null,
   state tinyint not null default 1,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;

/**
 * 终端设备表 sensors
 * id 主键
 * code 编号
 * state 状态(1,未出厂,2:已出厂)
 */
 drop table if exists sensors;
 create table sensors (
   id int not null primary key auto_increment,
   code char(10) not null,
   state tinyint not null default 0,
   is_delelte tinyint not null default 1,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;

/**
 * 传感数据表 dataframes
 * id 主键
 * g_code 网关编号
 * s_code 终端编号
 * cmd 功能码
 * content 内容
 */
 drop table if exists dataframes;
 create table dataframes (
   id int not null primary key auto_increment,
   g_code char(10) not null,
   s_code char(10) not null,
   cmd char(2) not null,
   content varchar(255) not null,
   is_delelte tinyint not null default 0,
   created_at int not null default 0,
   updated_at int not null default 0
 )charset=utf8;
