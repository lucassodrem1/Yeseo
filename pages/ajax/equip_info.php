<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$equip = new Equip();
$equip->load($_POST['equipID']);

$sql = "SELECT * FROM `player_equips_knowledge` WHERE `player_id`='".$player->getID()."' AND `equip_id`='".$equip->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
echo"
<table id='equip-info-table' border='1' style='margin: 0 auto; opacity: 1'>
	<tr>
		<td>
	 		<img id='info-image' src='../../images/equips/".$equip->getImage()."'> <br><br> ".$equip->getName()."<br><br>
	 		Raridade: <span style='color: ".$equip->getRarityColor()."'> ".$equip->getRarityName()." </span> <br><br>
	 		Onde encontrar <hr><br>
";
		$sql = "SELECT * FROM `enemies` WHERE `equip`='".$equip->getID()."'";
		$query = query($sql);
		while($row = mysql_fetch_assoc($query)) {
			$enemy = new Enemy($row['id']);
			echo"
				<span class='info-link' onClick='mobInfo(".$enemy->getID().")'>".$enemy->getName()."</span> <br>
			";
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
	<table id='equip-info-table' border='1' style='margin: 0 auto; opacity: 1'>
		<tr>
			<td> 
				<img style='height: 100px' src='../../images/misc/interrogacao.png'> <br> Voc&ecirc; n&atilde;o tem conhecimento sobre esse equipamento. 
				<br><br>
				<input type='button' value='Fechar' class='btn btn-danger' onClick='closeInfos()'>
			</td>
		</tr>
	</table>
	";
}
?>
