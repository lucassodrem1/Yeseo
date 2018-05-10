<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();

$sql = "SELECT * FROM `class` WHERE `id`='".$_GET['i']."'";
$query = query($sql);
$row = mysql_fetch_assoc($query);

if(($row['name'] == "Espadachim" || $row['name'] == "Mago" || $row['name'] == "Arqueiro" || $row['name'] == "Gatuno" || $row['name'] == "Noviço" ||  $row['name'] == "Mercador") && $player->getMaxFloor() < 5) {
	die('
		<script>
			alert("Você ainda não pode escolher classes do rank 1.");
			location.href="menu.php";
		</script>
	');	
}

if(($row['name'] == "Espadachim" || $row['name'] == "Mago" || $row['name'] == "Arqueiro" || $row['name'] == "Gatuno" || $row['name'] == "Noviço" ||  $row['name'] == "Mercador") && $player->getRankClass() == 1) {
	die('
		<script>
			alert("Você já escolheu uma classe do rank 1.");
			location.href="menu.php";
		</script>
	');		
}

$sql = "UPDATE `users` SET `class`='".$row['name']."' WHERE `id`='".$player->getID()."'";
query($sql);

$classLevel = $player->getRankClass() + 1;
$sql = "UPDATE `users` SET `class_level`='".$classLevel."' WHERE `id`='".$player->getID()."'";
query($sql);

echo"
	<script>
		alert('Parabéns! Você evolui para o rank 1!');
	</script>
";

header('Location: menu.php');
?>