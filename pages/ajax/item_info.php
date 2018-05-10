<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$item = new Item();
$item->load($_POST['itemID']);

$sql = "SELECT * FROM `player_items_knowledge` WHERE `player_id`='".$player->getID()."' AND `item_id`='".$item->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) != 0) {
echo"
<table id='item-info-table' border='1' style='margin: 0 auto; opacity: 1'>
	<tr>
		<td>
	 		<img id='info-image' src='../../images/items/".$item->getImage()."'> <br><br> ".$item->getName()."<br><br>
	 		Raridade: <span style='color: ".$item->getRarityColor()."'> ".$item->getRarityName()." </span> <br><br>
	 		Onde encontrar <hr><br>
";
		$sql = "SELECT * FROM `enemies` WHERE `item`='".$item->getID()."'";
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
	<table id='item-info-table' border='1' style='margin: 0 auto; opacity: 1'>
		<tr>
			<td> 
				<img style='height: 100px' src='../../images/misc/interrogacao.png'> <br> Voc&ecirc; n&atilde;o tem conhecimento sobre esse item. 
				<br><br>
				<input type='button' value='Fechar' class='btn btn-danger' onClick='closeInfos()'>
			</td>
		</tr>
	</table>
	";
}
?>
