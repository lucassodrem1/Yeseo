<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$sql = "SELECT * FROM `users` WHERE `id`='".$player->getID()."'";
$query = query($sql);
$playerBaseStats = mysql_fetch_assoc($query);
$playerStats = $player->getStats();
$arena = new Arena($player->getID());
$enemy = new Enemy($arena->getEnemyID());
$enemyRewards = $enemy->getRewards();
$enemyDropChance = $enemy->getDropChance();
if(!isset($_GET['p'], $_GET['e'])) {
	die('Erro.');
}

$playerDied = $_GET['p'];
$enemyDied = $_GET['e'];
$statsAlert = 0;
$equipAlert = 0;
$itemAlert = 0;

//Update em player enemies para dizer que o player já matou o enemy e se está vivo.
$sql = "UPDATE `player_enemies` SET `enemy_died`='".$enemyDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);
$sql = "UPDATE `player_enemies` SET `player_died`='".$playerDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);

//Se o player ficar vivo e ter matado o mob, sortear pra ver se ele vai pegar o item dropado pelo mob. Se algum player já pegar tiver pego o item, o sorteio não irá mais ocorrer.
if($playerDied == 0 && $enemyDied == 1) {
	//Se o player ficar vivo e matar o mob, ganha os pontos de stats ao passar de andar.
	//Ganhando conhecimento do mob.
	$player->gainEnemyKnowledge($enemy);
	$statsAlert = 1;
	$sql = "SELECT * FROM `class` WHERE `name`='".$player->getClass()."'";
	$query = query($sql);
	$row = mysql_fetch_assoc($query);
	//Adicionando stats.
	$playerSTR = $playerBaseStats['strength'] + $row['str_bonus'];
	$playerINT = $playerBaseStats['intelligence'] + $row['int_bonus'];
	$playerAGI = $playerBaseStats['agility'] + $row['agi_bonus'];
	$playerDEX = $playerBaseStats['dexterity'] + $row['dex_bonus'];
	$playerLUK = $playerBaseStats['lucky'] + $row['luk_bonus'];
	
	$sql = "UPDATE `users` SET `strength`='".$playerSTR."', `intelligence`='".$playerINT."', `agility`='".$playerAGI."', `dexterity`='".$playerDEX."', `lucky`='".$playerLUK."' 
			WHERE `id`='".$player->getID()."'";
	query($sql);

	//SE O EQUIP EXISTIR. Verifica se algum player já dropou o equip. Se dropou não tem mais chance de dropar para os outros players. 
	if($enemyRewards->equip != 0) {
		$sql = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `equip_caught`='1'";
		$query = query($sql);
		if(mysql_num_rows($query) == 0) {
			$randEquipDrop = rand(1, 100);
			if($randEquipDrop <= $enemyDropChance->equip) {
				$equipAlert = 1;
				$equip = new Equip();
				$equip->load($enemyRewards->equip);
				$player->earnEquip($equip, 1);
				
				//Ganhando conhecimento sobre o equip ganho.
				$player->gainEquipKnowledge($equip);

				$sql = "UPDATE `player_enemies` SET `equip_caught`='1' WHERE `player_id`='".$player->getID()."'";
				query($sql);
			}
		}
	}

	//Mesma coisa para item.
	if($enemyRewards->item != 0) {
		$sql = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `item_caught`='1'";
		$query = query($sql);
		if(mysql_num_rows($query) == 0) {
			$randItemDrop = rand(1, 100);
			if($randItemDrop <= $enemyDropChance->item) {
				$itemAlert = 1;
				$item = new Item();
				$item->load($enemyRewards->item);
				$player->earnItem($item, 1);

				//Ganhando conhecimento sobre o equip ganho.
				$player->gainItemKnowledge($item);
				
				$sql = "UPDATE `player_enemies` SET `item_caught`='1' WHERE `player_id`='".$player->getID()."'";
				query($sql);
			}
		}
	}
}

//Alertas
if($statsAlert == 1 && $equipAlert == 1 && $itemAlert == 1) {
	$equip = new Equip();
	$equip->load($enemyRewards->equip);
	$item = new Item();
	$item->load($enemyRewards->item);
	echo'
		<script>
			alert("Você matou o boss!\n Bônus de classe:\n STR: +'.$row['str_bonus'].' \n INT: +'.$row['int_bonus'].' \n AGI: +'.$row['agi_bonus'].' \n DEX: +'.$row['dex_bonus'].' \n LUK: +'.$row['luk_bonus'].' \n +3 pontos para distribuir.");
			alert("Você dropou o equip: '.$equip->getName().'");
			alert("Você dropou o item: '.$item->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else if($statsAlert == 1 && $equipAlert == 1) {
	$equip = new Equip();
	$equip->load($enemyRewards->equip);
	echo'
		<script>
			alert("Você matou o boss!\n Bonus de classe:\n STR: +'.$row['str_bonus'].' \n INT: +'.$row['int_bonus'].' \n AGI: +'.$row['agi_bonus'].' \n DEX: +'.$row['dex_bonus'].' \n LUK: +'.$row['luk_bonus'].' \n +3 pontos para distribuir.");
			alert("Você dropou o equip: '.$equip->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else if($statsAlert == 1 && $itemAlert == 1) {
	$item = new Item();
	$item->load($enemyRewards->item);
	echo'
		<script>
			alert("Você matou o boss!\n Bonus de classe:\n STR: +'.$row['str_bonus'].' \n INT: +'.$row['int_bonus'].' \n AGI: +'.$row['agi_bonus'].' \n DEX: +'.$row['dex_bonus'].' \n LUK: +'.$row['luk_bonus'].' \n +3 pontos para distribuir.");
			alert("Você dropou o item: '.$item->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else if($statsAlert == 1) {
	echo'
		<script>
			alert("Você matou o boss!\n Bonus de classe:\n STR: +'.$row['str_bonus'].' \n INT: +'.$row['int_bonus'].' \n AGI: +'.$row['agi_bonus'].' \n DEX: +'.$row['dex_bonus'].' \n LUK: +'.$row['luk_bonus'].' \n +3 pontos para distribuir.");
			location.href="afterBattle.php";
		</script>
	';
}
?>