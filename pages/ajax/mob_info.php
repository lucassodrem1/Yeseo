<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$enemy = new Enemy($_POST['mobID']);
$enemyStats = $enemy->getStats();
$enemyRewards = $enemy->getRewards();

$sql = "SELECT * FROM `player_enemies_knowledge` WHERE `player_id`='".$player->getID()."' AND `enemy_id`='".$enemy->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
echo"
<table id='mob-info-table' border='1' style='margin: 0 auto; opacity: 1'>
	<tr>
		<td>
";
		if($enemy->getBoss() == 1) {
			echo"<span style='color: red'> BOSS! </span> <br><br> ";
		}
echo"
	 		<img id='info-image' src='../../images/mobs/".$enemy->getImage()."'> <br><br> ".$enemy->getName()."<br>
";
if($enemy->getBoss() == 0) {
	$sql = "SELECT * FROM `floor_enemies` WHERE `enemy_id`='".$enemy->getID()."'";
	$query = query($sql);
	$floorEnemies = mysql_fetch_assoc($query);
	$floorEnemy = new Floor();
	echo" Andar: ".$floorEnemies['floor_id']."(".$floorEnemy->getFloorName($floorEnemies['floor_id']).") ";
} else {
	$floorEnemy = new Floor();
	echo" Andar: ".$enemy->getID()."(".$floorEnemy->getFloorName($enemy->getID()).")";
}
echo"
			<br><br>
	 		Stats <hr><br>
	 		HP: ".$enemyStats->HP." | AGI: ".$enemyStats->agility." <br>
	 		pDEF: ".$enemyStats->pDEF." | mDEF: ".$enemyStats->mDEF."
	 		<br><br>
	 		Drops <hr><br>
";
		if($enemyRewards->equip != 0) {
			$equip = new Equip();
			$equip->load($enemyRewards->equip);
			echo "Equip: <span class='info-link' onClick='equipInfo(".$equip->getID().")'>".$equip->getName()."</span><br>";
		}
		if($enemyRewards->item != 0) {
			$item = new Item();
			$item->load($enemyRewards->item);
			echo "Item: <span class='info-link' onClick='itemInfo(".$item->getID().")'> ".$item->getName()."</span> <br>";
		}
		if($enemyRewards->skill != 0) {
			$skill = new Skill();
			$skill->load($enemyRewards->skill);
			echo "Skill: " . $skill->getName() . "<br>";
		}
echo"	
		<br>
		<input type='button' value='Fechar' class='btn btn-danger' onClick='closeInfos()'>
		</td>
	</tr>	
</table>
";
} else {
	echo"
	<table id='mob-info-table' border='1' style='margin: 0 auto; opacity: 1'>
		<tr>
			<td> 
				<img style='height: 100px' src='../../images/misc/interrogacao.png'> <br> Voc&ecirc; n&atilde;o tem conhecimento sobre esse inimigo. 
				<br><br>
				<input type='button' value='Fechar' class='btn btn-danger' onClick='closeInfos()'>
			</td>
		</tr>
	</table>
	";
}
?>
