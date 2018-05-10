<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);

echo"
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td colspan='2' style='border-bottom: 1px solid black'> Jogadores </td>
			</tr>
	";
		$sql = "SELECT `leader_id`, `lobby_id` FROM `lobby` WHERE `player_id`='".$player->getID()."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$sql2 = "SELECT * FROM `lobby` WHERE `lobby_id`='".$row['lobby_id']."'";
		$query2 = query($sql2);
		while($row2 = mysql_fetch_assoc($query2)) {
			$sql3 = "SELECT `id`, `username`, `class` FROM `users` WHERE `id`='".$row2['player_id']."'";
			$query3 = query($sql3);
			$users = mysql_fetch_assoc($query3);
			if($row['leader_id'] == $users['id']) {
				echo"
				<tr>
					<td style='border-bottom: 1px solid black'><span class='btn btn-success'> ".$users['username']." (".$users['class'].") </span></td>
				";
				if($users['id'] == $player->getID()) {
					echo "<td style='border-bottom: 1px solid black'><span class='btn btn-warning' style='cursor: pointer' onClick='location.href=\"destroy_lobby.php?i=".$row['lobby_id']."\"'> Desfazer lobby </span></td>";
				}
				echo"
				</tr>
				";
			} else {	
				echo"
				<tr>
					<td style='border-bottom: 1px solid black'><span class='btn btn-primary'> ".$users['username']." (".$users['class'].") </span></td>
				";
				if($users['id'] == $player->getID()) {
					echo "<td style='border-bottom: 1px solid black'><span class='btn btn-warning' style='cursor: pointer' onClick='location.href=\"exit_lobby.php?i=".$row['lobby_id']."\"'> Sair </span></td>";
				}
				echo"
				</tr>
				";
			}		
		}
		if($row['leader_id'] == $player->getID()) {
			$sql = "SELECT `actual_floor` FROM `users` WHERE `id`='".$row['leader_id']."'";
			$query = query($sql);
			$row = mysql_fetch_assoc($query);
			echo"
			<tr>
				<td colspan='2'> <span class='btn btn-danger' style='cursor: pointer;' onClick='location.href=\"pre_arena.php\"'> Batalhar! </span> </td>
			</tr>	
			"; 
		}	
?>