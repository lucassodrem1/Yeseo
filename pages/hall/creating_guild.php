<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

if(empty($_POST['name']) || empty($_POST['tag'])) {
	die("
		<script>
			alert('Preencha todos os campos.');
			location.href='create_guild.php';
		</script>
	");
}

extract($_POST);

if($player->getMaxFloor() < 10) {
	die("
		<script>
			alert('Você ainda não chegou ao 10º andar.');
			location.href='guild_officer.php';
		</script>
	");
}

if($player->getGold() < 20000) {
	die("
		<script>
			alert('Você não possui ryo suficiente.');
			location.href='guild_officer.php';
		</script>
	");
}

$sql = "SELECT * FROM `guild_players` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Você já está em uma guilda.');
			location.href='guild_officer.php';
		</script>
	");
}

$sql = "SELECT `name` FROM `guilds` WHERE `name`='".$name."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Este nome já está em uso.');
			location.href='create_guild.php';
		</script>
	");
}


$sql = "SELECT `tag` FROM `guilds` WHERE `tag`='".$tag."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Esta tag já está em uso.');
			location.href='create_guild.php';
		</script>
	");
}

//Tirando gold do player.
$player->decreasingGold(20000);

//Criando guilda.
$sql = "INSERT INTO `guilds` (`name`, `tag`, `creator`) VALUES ('".ucfirst($name)."', '".strtoupper($tag)."', '".$player->getID()."')";
query($sql);
$guildID = mysql_insert_id();


//Inserindo player na guilda.
$sql = "INSERT INTO `guild_players` (`guild_id`, `player_id`) VALUES ('".$guildID."', '".$player->getID()."')";
query($sql);

echo"
	<script>
		alert('Guilda fundada com sucesso.');
		location.href='../guild/guild.php';
	</script>
";
?>