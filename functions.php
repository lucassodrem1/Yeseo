<?php
require_once 'connect.php';
require_once 'class/Player.class.php';
require_once 'class/Arena.class.php';
require_once 'class/Enemy.class.php';
require_once 'class/Floor.class.php';
require_once 'class/Equip.class.php';
require_once 'class/Skill.class.php';
require_once 'class/Item.class.php';
require_once 'class/Pet.class.php';
require_once 'class/Game.class.php';
require_once 'class/Quest.class.php';

function isLogged(){
	if(!isset($_COOKIE['info'])){
		die('Error: Você não está logado.');
	}
}

function query($sql){
	$query = mysql_query($sql);
	if(!$query){
		die(mysql_error() . " " . $sql);
	}
	return $query;
}

function getID($cookie) {
	$id = explode(' - ', $cookie);
	return $id[0];
}
?>