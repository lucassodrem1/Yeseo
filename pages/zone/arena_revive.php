<?php
require '../../functions.php';
$id = getID($_COOKIE['info']);
$player = new Player($id);
$arena = new Arena($player->getID());

if(!isset($_GET['i'])) {
	die('Erro.');
}

$otherPlayerID = $_GET['i'];

//Verifica se o player que está revivendo possui o item para reviver.
$sql = "SELECT `item_id` FROM `player_items` WHERE `player_id`='".$player->getID()."' AND `item_id`='100'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	$row = mysql_fetch_assoc($query);
	$item = new Item();
	$item->load($row['item_id']);
	$player->useItem($item, 1);

	//Reviver player.
	$sql = "UPDATE `player_enemies` SET `player_died`='0', `enemy_died`='1' WHERE `player_id`='".$otherPlayerID."' AND `battle_id`='".$arena->getBattleID()."'";
	query($sql);
	
	echo"
	<script>
		alert('O jogador voltou a vida!');
		location.href='afterBattle.php';
	</script>
	";
} else {
	//Verifica se o player que está revivendo possui uma skill pra reviver.
	$skillRevive = 0;
	$sql = "SELECT `skill_id` FROM `player_skills` WHERE `player_id`='".$player->getID()."'";
	$query = query($sql);
	while($row = mysql_fetch_assoc($query)) {
		$sql2 = "SELECT `revive` FROM `skills` WHERE `id`='".$row['skill_id']."'";
		$query2 = query($sql2);
		$row2 = mysql_fetch_assoc($query2);
		if($row2['revive'] == 1) {
			$skillRevive = 1;
		}
	}

	if($skillRevive == 1) {
		//Reviver player.
		$sql = "UPDATE `player_enemies` SET `player_died`='0', `enemy_died`='1' WHERE `player_id`='".$otherPlayerID."' AND `battle_id`='".$arena->getBattleID()."'";
		query($sql);
	
		echo"
		<script>
			alert('O jogador voltou a vida!');
			location.href='afterBattle.php';
		</script>
		";
	} else {
		die("
		<script>
			alert('Você não tem nenhum item ou skill que possa salva-lo.');
			location.href='afterBattle.php';
		</script>
		");
}
	}
?>