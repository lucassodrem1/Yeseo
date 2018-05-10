<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$stats = $player->getStats();
$equips = $player->getEquipsName();
$equipsID = $player->getEquips();
$floor = new Floor();
$floor->load($player->getActualFloor());
$game = new Game();
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
$(document).ready(function() {
	$('#show_equip').click(function() {
		let equips = document.getElementById('player_equips_menu').style.display;
		
		if(equips == 'none') {
			$('#player_equips_menu').show();
		} else {
			$('#player_equips_menu').hide();
		}		
	});

	//1 - Verifica a batalha já foi startada pelo líder. 
	//2 - Verifca se o lobby ainda existe.
	setInterval(function() {
		$.ajax({
			url: 'lobby_action.php',
			success: function(data) {
				obj = JSON.parse(data);
				if(obj.inBattle == 1) {
					location.href="arena.php";
				}
				if(obj.lobbyExists == 0) {
					location.href="../home.php";
				}
			}
		})
	}, 500)

	//Atualiza a tabela de players.
	setInterval(function() {
		$.ajax({
			url: 'players_table_att.php',
			success: function(data) {
				document.getElementById('players-arena-lobby').innerHTML = data;
			}
		})
	}, 500)
})				
</script>
</head>
<body>
<div class='header col-12'>
	SOLLA
</div>

<div class='body col-12'>
	<div class='stats col-2'>
		<?php
		echo"
			<img id='class-image' src='../../images/class/".$game->classImage[$player->getClass()]."'>
			".$player->getUsername()." <br>
			Ryo: ".$player->getGold()." <br>
			Classe: ".$player->getClass()." <br>
			Andar: ".$player->getActualFloor()."(".$player->actualFloorName.") <br>
			<hr>
			MP: ".$stats->MP." / ".$stats->MP." <br> 
			STR: ".$stats->strength." /  INT: ".$stats->intelligence." <br> 
			AGI: ".$stats->agility." / DEX: ".$stats->dexterity." (".$stats->criticalChance."%)<br> 
			LUK: ".$stats->lucky." <br><br>
			<div style='display: flex;'>
				<div class='button btn btn-primary' onClick='location.href=\"../home.php\"'>Home </div>  
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"../char/menu.php\"'> Personagem </div> 
			</div>
			<br>	
			<div style='display: flex;'>
				<div class='button btn btn-primary' id='show_equip'> Equips </div> 
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"../inventory/bag.php\"'> Mochila </div>
			</div>	
			<div id='player_equips_menu' style='display: none'>
		";
		if($equipsID->capacete != 0) {
			echo "Capacete: ".$equips->capacete." <a href='inventory/unequip.php?i=".$equipsID->capacete."&slot=capacete'>(X)</a> <br>";
		} else {
			echo "Capacete: Nenhum <br>";
		}
		if($equipsID->armadura != 0) {
			echo "Armadura: ".$equips->armadura." <a href='inventory/unequip.php?i=".$equipsID->armadura."&slot=armadura'>(X)</a> <br>";
		} else {
			echo "Armadura: Nenhum <br>";
		}
		if($equipsID->luvas != 0) {
			echo "Luvas: ".$equips->luvas." <a href='inventory/unequip.php?i=".$equipsID->luvas."&slot=luvas'>(X)</a> <br>";
		} else {
			echo "Luvas: Nenhum <br>";
		}
		if($equipsID->botas != 0) {
			echo "Botas: ".$equips->botas." <a href='inventory/unequip.php?i=".$equipsID->botas."&slot=botas'>(X)</a> <br>";
		} else {
			echo "Botas: Nenhum <br>";
		}
		if($equipsID->arma1 != 0) {
			echo "Arma Esq: ".$equips->arma1." <a href='inventory/unequip.php?i=".$equipsID->arma1."&slot=arma1'>(X)</a> <br>";
		} else {
			echo "Arma Esq: Nenhum <br>";
		}
		if($equipsID->arma2 != 0) {
			echo "Arma Dir: ".$equips->arma2." <a href='inventory/unequip.php?i=".$equipsID->arma2."&slot=arma2'>(X)</a> <br>";
		} else {
			echo "Arma Dir: Nenhum <br>";
		}
		if($equipsID->capa != 0) {
			echo "Capa: ".$equips->capa." <a href='inventory/unequip.php?i=".$equipsID->capa."&slot=capa'>(X)</a> <br>";
		} else {
			echo "Capa: Nenhum <br>";
		}
		if($equipsID->colar != 0) {
			echo "Colar: ".$equips->colar." <a href='inventory/unequip.php?i=".$equipsID->colar."&slot=colar'>(X)</a> <br>";
		} else {
			echo "Colar: Nenhum <br>";
		}
		echo"
			</div>		
		";
		?>
	</div>

	<div class='game col-10'>
		Lobby <br>
		<hr style='border: 1px solid black'> <br><br>
		<!-- Tabela de amigos do player. -->
		<div class="smaller-parent" style='float: left'>
 			<div class="scrollbar"></div>
 			<div class="smaller-scrollable">
				<table border='0' style='width: 100%'>
					<tr>
						<td colspan='3' style='border-bottom: 1px solid black'> Lista de Amigos </td>
					</tr>
				<?php
				$sql = "SELECT `friend_id` FROM `player_friends` WHERE `player_id`='".$player->getID()."'";
				$query = query($sql);
				while($row = mysql_fetch_assoc($query)) {
					$friend = new Player($row['friend_id']);
					echo"
					<tr>
						<td style='border-bottom: 1px solid black'> ".$friend->getUsername()." </td>
						<td style='border-bottom: 1px solid black'> Andar: ".$friend->getActualFloor()." </td>
						<td style='border-bottom: 1px solid black'> <input type='button' class='btn btn-success' value='Convidar' onClick='location.href=\"invite_player.php?i=".$friend->getID()."\"'> </td>
					</tr>
					";
				}
				?>
				</table>
			</div>
		</div>

		<!-- Tabela de players no loby. -->
		<table border='0' style='margin: 0 auto' id='players-arena-lobby'>
			<tr>
				<td colspan='2' style='border-bottom: 1px solid black'> Jogadores </td>
			</tr>
		<?php
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
		</table>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>