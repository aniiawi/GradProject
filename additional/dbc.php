<?php
function pdoconnect() {
	$host = '127.0.0.1';
	$db = 'an314muc_n';
	$user = 'an314muc_n';
	$pass = 'annyAn212';
	$charset = 'utf8';
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
		PDO::ATTR_CASE => PDO::CASE_LOWER,
		PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	return new PDO($dsn, $user, $pass, $opt);
}
