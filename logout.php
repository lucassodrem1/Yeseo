<?php
require 'functions.php';

if(isset($_COOKIE['info'])){
	setcookie('info', null, time() -1);
	header('Location: index.php');
}
?>