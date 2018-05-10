<?php
require '../../functions.php';
$id = getID($_COOKIE['info']);
$player = new Player($id);
$arena = new Arena($player->getID());

echo"
<table border='0' style='margin: 0 auto' id='teste'>
	<tr>
		<td colspan='2' style='border-bottom: 1px solid black'> Jogadores em batalha </td>
	</tr>
";
$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `enemy_died`='0' AND `player_died`='0'";
$query2 = query($sql2);
while($row2 = mysql_fetch_assoc($query2)) {
	$sql3 = "SELECT `id`, `username`, `class` FROM `users` WHERE `id`='".$row2['player_id']."'";
	$query3 = query($sql3);
	$users = mysql_fetch_assoc($query3);
	echo"
	<tr>
		<td style='border-bottom: 1px solid black'> ".$users['username']." (".$users['class'].") </td>
		<td style='border-bottom: 1px solid black'> Enemy HP: ".$row2['enemy_current_hp']."(".$row2['enemy_current_time']."s) </td>
	</tr>
	";	
}	
echo"		
</table>
<br><br>
<table border='0' style='margin: 0 auto'>
	<tr>
		<td colspan='2' style='border-bottom: 1px solid black'> Jogadores mortos </td>
	</tr>
";
$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `player_died`='1'";
$query2 = query($sql2);
while($row2 = mysql_fetch_assoc($query2)) {
	$sql3 = "SELECT `id`, `username`, `class` FROM `users` WHERE `id`='".$row2['player_id']."'";
	$query3 = query($sql3);
	$users = mysql_fetch_assoc($query3);

	if($row2['player_id'] == $player->getID()) {
		echo"<tr style='background-color: #28a745; color: white'>";
	} else {
		echo"<tr>";
	}
	echo"
		<td style='border-bottom: 1px solid black'> ".$users['username']." (".$users['class'].") </td>
	";
	if($player->getID() != $row2['player_id'] && $arena->getPlayerDied() == 0) {
		echo"
		<td style='border-bottom: 1px solid black'> <input type='button' value='Reviver Player' class='btn btn-warning' onClick='location.href=\"arena_revive.php?i=".$users['id']."\"'> </td>
		";
	}
	echo"
	</tr>
	";	
}
echo"	
</table>
<br><br>
<table border='0' style='margin: 0 auto'>
	<tr>
		<td colspan='4' style='border-bottom: 1px solid black'> Jogadores Vivos </td>
	</tr>
";
$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `enemy_died`='1' AND `player_died`='0' ORDER BY `enemy_current_time` DESC";
$query2 = query($sql2);
while($row2 = mysql_fetch_assoc($query2)) {
	$sql3 = "SELECT `id`, `username`, `class` FROM `users` WHERE `id`='".$row2['player_id']."'";
	$query3 = query($sql3);
	$users = mysql_fetch_assoc($query3);
	$enemy = new Enemy($row2['enemy_id']);
	$totalTime = $enemy->getTime() - $row2['enemy_current_time']; 
	
	if($row2['player_id'] == $player->getID()) {
		echo"<tr style='background-color: #28a745; color: white'>";
	} else {
		echo"<tr>";
	}
	echo"
		<td style='border-bottom: 1px solid black'> ".$users['username']." (".$users['class'].") </td>
		<td style='border-bottom: 1px solid black'> Tempo: ".$totalTime."s </td>
	";
	if($row2['equip_caught'] == 1) {
		echo"<td style='border-bottom: 1px solid black'> +Equip </td>";
	}
	if($row2['item_caught'] == 1) {
		echo"<td style='border-bottom: 1px solid black'> +Item </td>";
	}
	echo"
	</tr>
	";	
}	
echo"
</table>
";
?>