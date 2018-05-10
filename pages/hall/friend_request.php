<?php
date_default_timezone_set('America/Sao_Paulo');
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

if($player->getID() == $_GET['i']) {
	die("
		<script>
			alert('Você não pode se adicionar.');
			location.href='players.php';
		</script>
	");
}

$sql = "SELECT * FROM `player_friends` WHERE `player_id`='".$player->getID()."' AND `friend_id`='".$_GET['i']."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Você já é amigo desse jogador.');
			location.href='players.php';
		</script>
	");
}

$sql = "SELECT * FROM `messages` WHERE `sender_id`='".$player->getID()."' AND `receiver_id`='".$_GET['i']."' AND `type`='2'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Você já mandou um convite para este jogador.');
			location.href='players.php';
		</script>
	");
}

$sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `topic`, `message`, `type`, `time`) VALUES ('".$player->getID()."', '".$_GET['i']."', 'Pedido de Amizade', 'O jogador gostaria de ser seu amigo.', '2', '".date('Y-m-d H:i:s')."')";
query($sql);

header('Location: players.php');

?>