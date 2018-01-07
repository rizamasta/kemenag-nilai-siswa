<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

if(file_exists(FCPATH.'local.txt')) {
	// Local Server
	$dsn 		= '';
	/*$hostname	= '31.220.20.207';
	$username	= 'u466703121_kind';
	$password 	= 'pw4kind';
	$database 	= 'u466703121_kind';*/
	$hostname	= 'kindis.co';
	$username	= 'root';
	$password 	= 'bismillah009';
	$database 	= 'kinbase';

}elseif(file_exists(FCPATH.'dev.txt')) {
	// Development Server
	$dsn 		= '';
	$hostname	= 'localhost';
	$username	= 'root';
	$password 	= 'root';
	$database 	= '';
}elseif(file_exists(FCPATH.'stg.txt')) {
	// Staging Server
	$dsn 		= '';
	$hostname	= 'localhost';
	$username	= 'root';
	$password 	= 'root';
	$database 	= '';
}else{
	// Production Server
	$dsn 		= '';
	$hostname	= 'localhost';
	$username	= 'root';
	$password 	= 'root';
	$database 	= '';
}

$db['default'] = array(
	'dsn'	=> $dsn,
	'hostname' => $hostname,
	'username' => $username,
	'password' => $password,
	'database' => $database,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
