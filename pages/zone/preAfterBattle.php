<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
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
$equipAlert = 0;
$itemAlert = 0;

//Update em player enemies para dizer que o player já matou o enemy e se está vivo.
$sql = "UPDATE `player_enemies` SET `enemy_died`='".$enemyDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);
$sql = "UPDATE `player_enemies` SET `player_died`='".$playerDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);

//Se o player ficar vivo e ter matado o mob, sortear pra ver se ele vai pegar o item dropado pelo mob. Se algum player já pegar tiver pego o item, o sorteio não irá mais ocorrer.
if($playerDied == 0 && $enemyDied == 1) {
	//Ganhando conhecimento do mob.
	$player->gainEnemyKnowledge($enemy);

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

				//Ganhando conhecimento sobre o item ganho.
				$player->gainItemKnowledge($item);
				
				$sql = "UPDATE `player_enemies` SET `item_caught`='1' WHERE `player_id`='".$player->getID()."'";
				query($sql);
			}
		}
	}
}

//Alertas 
if($itemAlert == 1 && $equipAlert == 1) {
	$equip = new Equip();
	$equip->load($enemyRewards->equip);
	$item = new Item();
	$item->load($enemyRewards->item);
	echo'
		<script>
			alert("Você dropou o equip: '.$equip->getName().'");
			alert("Você dropou o item: '.$item->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else if($itemAlert == 1) {
	$item = new Item();
	$item->load($enemyRewards->item);
	echo'
		<script>
			alert("Você dropou o item: '.$item->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else if($equipAlert == 1) {
	$equip = new Equip();
	$equip->load($enemyRewards->equip);
	echo'
		<script>
			alert("Você dropou o equip: '.$equip->getName().'");
			location.href="afterBattle.php";
		</script>
	';
} else {
	echo'
		<script>
			location.href="afterBattle.php";
		</script>
	';
}
?>