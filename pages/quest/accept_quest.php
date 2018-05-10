<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$quest = new Quest();
$quest->load($_GET['i']);

$sql = "SELECT * FROM `player_enemies_quests` WHERE `quest_id`='".$quest->getID()."' AND `player_id`='".$player->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
	die("
		<script>
			alert('Você já possui essa quest.');
			location.href='quests.php';
		</script>
	");
}
	
//Inserindo em player quests
$sql = "INSERT INTO `player_quests` (`player_id`, `quest_id`) VALUES ('".$player->getID()."', '".$quest->getID()."')";
query($sql);
	
if($player->getActualFloor() == $quest->getFloor()) {	
	//Pegando enemies que deve matar na quest.
	$sql = "SELECT `enemy_id` FROM `quest_enemies` WHERE `quest_id`='".$quest->getID()."'";
	$query = query($sql);
	while($row = mysql_fetch_assoc($query)) {
		//Inserindo enemies em player enemies quests.
		$sql2 = "INSERT INTO `player_enemies_quests` (`quest_id`, `player_id`, `enemy_id`) VALUES ('".$quest->getID()."', '".$player->getID()."', '".$row['enemy_id']."')";
		query($sql2);
	}
	
	echo"
		<script>
			alert('Quest aceita!');
			location.href='quests.php';
		</script>
	";
}	
?>