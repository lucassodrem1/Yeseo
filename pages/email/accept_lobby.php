<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

//Identificando mensagem.
$sql = "SELECT * FROM `messages` WHERE `id`='".$_GET['i']."'";
$query = query($sql);
$message = mysql_fetch_assoc($query);

//Pegando o lobby id do remetente.
$sql = "SELECT `lobby_id`, `leader_id` FROM `lobby` WHERE `player_id`='".$message['sender_id']."'";
$query = query($sql);
$lobby = mysql_fetch_assoc($query);

//Verificando se o lobby ainda existe.
$sql = "SELECT * FROM `lobby` WHERE `lobby_id`='".$lobby['lobby_id']."'"; 
$query = query($sql);
if(mysql_num_rows($query) == 0) {
	die('
		<script>
			alert("Este lobby não existe mais.");
			location.href="recuse_lobby.php?i='.$_GET['i'].'";
		</script>	
	');
}

//Verificando se jogador já está em outro lobby.
$sql = "SELECT * FROM `lobby` WHERE `player_id`='".$message['receiver_id']."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die('
		<script>
			alert("Você já está em um lobby.");
			history.back();
		</script>	
	');
}


//Jogador invitado entrando no lobby.
$sql = "INSERT INTO `lobby` (`lobby_id`, `leader_id`, `player_id`) VALUES ('".$lobby['lobby_id']."', '".$lobby['leader_id']."', '".$message['receiver_id']."')";
query($sql);

//Apagando mensagem.
$sql = "DELETE FROM `messages` WHERE `id`='".$message['id']."'";
query($sql);

if($message['type'] == 3) {
	header('Location: ../zone/lobby.php');
} else if($message['type'] == 4) {
	header('Location: ../arena/lobby.php');
}
?>