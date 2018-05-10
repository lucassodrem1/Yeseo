<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
if(!isset($_GET['i'])) {
	die('Erro.');
}
$quest = new Quest();
$quest->load($_GET['i']);
$haveItems = 1;
$killMobs = 1;

//Verificar se o player possui os itens necessários.
$sql = "SELECT * FROM `quest_items` WHERE `quest_id`='".$quest->getID()."'";
$query = query($sql);
$item = new Item();
while($row = mysql_fetch_assoc($query)) {
	$item->load($row['item_id']);
	$sql2 = "SELECT * FROM `player_items` WHERE `item_id`='".$item->getID()."' AND `player_id`='".$player->getID()."'";
	$query2 = query($sql2);
	$playerItems = mysql_fetch_assoc($query2);
	if(mysql_num_rows($query2) == 0 || $playerItems['amount'] < $row['amount']) {
		$haveItems = 0;
	} 
}	

if($haveItems == 0) {
	die("
		<script>
			alert('Você não possui todos os itens necessários.');
			location.href='../char/quests.php';
		</script>	
	");
}

//Verificar se o player matou todos os mobs necessários.
$sql = "SELECT * FROM `quest_enemies` WHERE `quest_id`='".$quest->getID()."'";
$query = query($sql);
while($row = mysql_fetch_assoc($query)) {
	$enemy = new Enemy($row['enemy_id']);
	$sql2 = "SELECT * FROM `player_enemies_quests` WHERE `quest_id`='".$quest->getID()."' AND `enemy_id`='".$enemy->getID()."' AND `player_id`='".$player->getID()."'";
	$query2 = query($sql2);
	$playerMobs = mysql_fetch_assoc($query2);
	if(mysql_num_rows($query2) == 0 || $playerMobs['amount'] < $row['amount']) {
		$killMobs = 0;
	}
}

if($killMobs == 0) {
	die("
		<script>
			alert('Você não matou todos os inimigos necessários.');
			location.href='../char/quests.php';
		</script>	
	");
}


//Pegando os itens do player.
$sql = "SELECT * FROM `quest_items` WHERE `quest_id`='".$quest->getID()."'";
$query = query($sql);
$item = new Item();
while($row = mysql_fetch_assoc($query)) {
	$item->load($row['item_id']);
	$player->loseItem($item, $row['amount']);
}

//Recebendo recompensas.
$questRewards = $quest->getRewards();

if($questRewards->item != 0) {
	$item->load($questRewards->item);
	$player->earnItem($item, $questRewards->itemAmount);
	$player->gainItemKnowledge($item);
}


if($questRewards->equip != 0) {
	$equip->load($questRewards->equip);
	$player->earnEquip($equip, 1);
	$player->gainEquipKnowledge($equip);
}

$player->earnGold($questRewards->gold);

//Apagando registros e completando a quest.
$sql = "DELETE FROM `player_enemies_quests` WHERE `player_id`='".$player->getID()."' AND `quest_id`='".$quest->getID()."'";
query($sql);

$sql = "DELETE FROM `player_quests` WHERE `player_id`='".$player->getID()."' AND `quest_id`='".$quest->getID()."'";
query($sql);

$sql = "INSERT INTO `completed_quests` (`quest_id`, `player_id`) VALUES ('".$quest->getID()."', '".$player->getID()."')";
query($sql);

echo"
	<script>
			alert('Quest concluída com sucesso!');
			location.href='../char/quests.php';
		</script>
";
?>