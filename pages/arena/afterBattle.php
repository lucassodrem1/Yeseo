<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$arena = new Arena($player->getID());
$stats = $player->getStats();
$equips = $player->getEquipsName();
$equipsID = $player->getEquips();

$enemy = new Enemy($arena->getEnemyID());
$playerDied = $arena->getPlayerDied();
$enemyDied = $arena->getEnemyDied();

//Caso só tenha um player e esse player não morreu, ele pula essa página.
$sql = "SELECT `battle_id` FROM `player_enemies` WHERE `player_id`='".$player->getID()."'";
$query = query($sql);
$row = mysql_fetch_assoc($query);
$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$row['battle_id']."'";
$query2 = query($sql2);
if(mysql_num_rows($query2) == 1 && $playerDied == 0 && $enemyDied == 1) {
	die(header("Location: closeArena.php?i=".$enemy->getID()."&p=".$playerDied."&e=".$enemyDied.""));
}

//Update em player enemies para dizer que o player já matou o enemy e se está vivo.
$sql = "UPDATE `player_enemies` SET `enemy_died`='".$enemyDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);
$sql = "UPDATE `player_enemies` SET `player_died`='".$playerDied."' WHERE `player_id`='".$player->getID()."'";
query($sql);
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
let enemyID = <?php echo $enemy->getID(); ?>;
let playerDied = <?php echo $playerDied; ?>;
let enemyDied = <?php echo $enemyDied; ?>

function closeArena() {
	//Ajax para atualizar o player Died e enemyDied.
	$.ajax({
		type: 'POST',
		url: 'att_player_died.php',
		success: function(data) {
			obj = JSON.parse(data);
			playerDied = obj.playerDied;
			enemyDied = obj.enemyDied;
			location.href='closeArena.php?i='+enemyID+'&p='+playerDied+'&e='+enemyDied+'';
		}
	})
}

$(document).ready(function() {
	$('#show_equip').click(function() {
		let equips = document.getElementById('player_equips_menu').style.display;
		
		if(equips == 'none') {
			$('#player_equips_menu').show();
		} else {
			$('#player_equips_menu').hide();
		}		
	});

	//Ajax para atualizar as 3 tables.
	setInterval(function() {
		$.ajax({
			type: 'POST',
			url: 'afterBattle_action.php',
			success: function(data) {
				document.getElementById('after-battle-tables').innerHTML = data;
			}
		})
	}, 1000);
})				
</script>
</head>
<body>
<div class='header col-12'>
	SAHDUASHDUASHFUSADFHUH
</div>

<div class='body col-12'>
	<div class='stats col-2'>
		<?php
		echo"
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
		Pós Batalha <br>
		<hr style='border: 1px solid black'> <br><br>
		<?php
		echo"
		<div style='text-align: center'> <input onClick='closeArena()' type='button' value='Sair da arena' class='btn btn-primary'> </div> <br>
		";
		?>
		<div id='after-battle-tables'>
		<table border='0' style='margin: 0 auto' id='teste'>
			<tr>
				<td colspan='1' style='border-bottom: 1px solid black'> Jogadores em batalha </td>
			</tr>
		<?php
		$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `enemy_died`='0' AND `player_died`='0'";
		$query2 = query($sql2);
		while($row2 = mysql_fetch_assoc($query2)) {
			$sql3 = "SELECT `id`, `username`, `class` FROM `users` WHERE `id`='".$row2['player_id']."'";
			$query3 = query($sql3);
			$users = mysql_fetch_assoc($query3);
			echo"
			<tr>
				<td style='border-bottom: 1px solid black'> ".$users['username']." (".$users['class'].") </td>
			</tr>
			";	
		}	
		?>
		</table>
		<br><br>
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td colspan='2' style='border-bottom: 1px solid black'> Jogadores mortos </td>
			</tr>
		<?php
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
		?>
		</table>
		<br><br>
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td colspan='1' style='border-bottom: 1px solid black'> Jogadores Vivos </td>
			</tr>
		<?php
		$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$arena->getBattleID()."' AND `enemy_died`='1' AND `player_died`='0' ORDER BY `enemy_current_time` DESC";
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
			</tr>
			";	
		}	
		?>
		</table>
		</div>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>