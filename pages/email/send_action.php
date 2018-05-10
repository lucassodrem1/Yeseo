<?php
date_default_timezone_set('America/Sao_Paulo');

require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

if(!empty($_POST['receiver']) && !empty($_POST['topic']) && !empty($_POST['message'])) {
	extract($_POST);

	//Verificando se destinatário existe.
	$sql = "SELECT `id` FROM `users` WHERE `username`='".$receiver."'";
	$query = query($sql);
	if(mysql_num_rows($query) != 0) {
		$row = mysql_fetch_assoc($query);
		//Enviando mensagem.
		$sql = "INSERT INTO `messages` (`sender_id`, `receiver_id`, `topic`, `message`, `type`, `time`) VALUES ('".$player->getID()."', '".$row['id']."', '".$topic."', '".$message."', '1', '".date('Y-m-d H:i:s')."')";
		query($sql);
		echo"
			<script>
				alert('Mensagem enviada com sucesso!');
				location.href='send.php';
			</script>
		";
	} else {
		echo"
			<script>
				alert('Este player não existe.');
				location.href='send.php';
			</script>
		";
	}
} else {
	echo"
		<script>
			alert('Preencha todos os campos.');
			location.href='send.php';
		</script>
	";
}
?>