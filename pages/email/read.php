<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$stats = $player->getStats();
$equips = $player->getEquipsName();
$equipsID = $player->getEquips();
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
})	
			
</script>
</head>
<body>
<div class='header col-12'>
	Nome do jogo
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
				<div class='button' onClick='location.href=\"../home.php\"'> Home </div>  
				<div class='button' style='margin-left: 10px' onClick='location.href=\"../char/menu.php\"'> Personagem </div> 
			</div>
			<br>	
			<div style='display: flex;'>
				<div class='button' id='show_equip'> Equips </div> 
				<div class='button' style='margin-left: 10px' onClick='location.href=\"../inventory/bag.php\"'> Mochila </div>
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
		Caixa de mensagem <br>
		<hr style='border: 1px solid black'> <br><br>
		
		<?php
		$sql = "SELECT * FROM `messages` WHERE `id`='".$_GET['i']."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$receiver = new Player($row['receiver_id']);
		$sender = new Player($row['sender_id']);
		switch($row['type']) {
			case 1:
			echo"
			<table border='0' class='messages-table' style='border: 1px solid black'>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<div style='text-align: right; cursor: pointer' onClick='location.href=\"messages.php\"'> X </div>
						&nbsp;&nbsp;".$row['topic']."
						<hr color='black'>
					</td> 
				</tr>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<br>
						&nbsp;&nbsp;".$receiver->getUsername().", <br>
						&nbsp;&nbsp;".chunk_split($row['message'], 50, "<br>")." 
						<br>
						<div style='text-align: right'> ".$sender->getUsername()." </div>
					</td>
				</tr>		
			</table>
			";
			break;
			case 2:
			echo"
			<table border='0' class='messages-table' style='border: 1px solid black'>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<div style='text-align: right; cursor: pointer' onClick='location.href=\"messages.php\"'> X </div>
						&nbsp;&nbsp;".$row['topic']." 
					</td> 
				</tr>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<br><br>
						&nbsp;&nbsp;".$receiver->getUsername().", <br>
						&nbsp;&nbsp;Gostaria de ser seu amigo. 
						<br><br>
						<input onClick='location.href=\"recuse_friend.php?i=".$_GET['i']."\"' style='padding: 3px; float: left' type='button' value='Recusar' class='btn btn-danger'> 
						<input onClick='location.href=\"accept_friend.php?i=".$_GET['i']."\"' style='padding: 3px; float: right' type='button' value='Aceitar' class='btn btn-success'>
						<br><br><br>
						<div style='text-align: right'> ".$sender->getUsername()." </div>
					</td>
				</tr>		
			</table>
			";
			break;
			case 3:
			echo"
			<table border='0' class='messages-table' style='border: 1px solid black'>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<div style='text-align: right; cursor: pointer' onClick='location.href=\"messages.php\"'> X </div>
						&nbsp;&nbsp;".$row['topic']." 
					</td> 
				</tr>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<br><br>
						&nbsp;&nbsp;".$receiver->getUsername().", <br>
						&nbsp;&nbsp;".$row['message']." 
						<br><br>
						<input onClick='location.href=\"recuse_lobby.php?i=".$_GET['i']."\"' style='padding: 3px; float: left' type='button' value='Recusar' class='btn btn-danger'> 
						<input onClick='location.href=\"accept_lobby.php?i=".$_GET['i']."\"' style='padding: 3px; float: right' type='button' value='Aceitar' class='btn btn-success'>
						<br><br><br>
						<div style='text-align: right'> ".$sender->getUsername()." </div>
					</td>
				</tr>		
			</table>
			";
			break;
			case 4:
			echo"
			<table border='0' class='messages-table' style='border: 1px solid black'>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<div style='text-align: right; cursor: pointer' onClick='location.href=\"messages.php\"'> X </div>
						&nbsp;&nbsp;".$row['topic']." 
					</td> 
				</tr>
				<tr>
					<td style='text-align: left; background-color: #dec494; font-style: italic'> 
						<br><br>
						&nbsp;&nbsp;".$receiver->getUsername().", <br>
						&nbsp;&nbsp;".$row['message']." 
						<br><br>
						<input onClick='location.href=\"recuse_lobby.php?i=".$_GET['i']."\"' style='padding: 3px; float: left' type='button' value='Recusar' class='btn btn-danger'> 
						<input onClick='location.href=\"accept_lobby.php?i=".$_GET['i']."\"' style='padding: 3px; float: right' type='button' value='Aceitar' class='btn btn-success'>
						<br><br><br>
						<div style='text-align: right'> ".$sender->getUsername()." </div>
					</td>
				</tr>		
			</table>
			";
			break;
		}
		
		?>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>