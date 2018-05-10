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
header('Content-type: text/html; charset=ISO-8859-1');
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
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
				<div class='button btn btn-primary' onClick='location.href=\"../home.php\"'> Home </div>  
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
		Templo <br>
		<hr style='border: 1px solid black'> <br><br>
		<div class='div-scroll' style='text-align: center'>
		<?php
		if($player->getMaxFloor() < 5) {
			echo"
				Você precisa chegar ao andar 5 para liberar as classes de rank 1.
			";		
		} else if($player->getMaxFloor() >= 5 && $player->getRankClass() == 0) {
			echo"
				<table border='1' style='width: 100%'> 
					<tr>
						<td colspan='3'> Classes Rank 1 Disponíveis! </td>
					</tr>
			";
			$sql = "SELECT * FROM `class` WHERE `class_level`='1'";
			$query = query($sql);
			while($row = mysql_fetch_assoc($query)) {
				echo"
					<tr>
						<td class='choose_class'> 
							".$row['name']." <br><br>
							<img style='float: left' id='class-image-temple' src='../../images/class/".$row['name'].".jpg'>
							Stats por level: <br>
							STR: +".$row['str_bonus']." <br>
							INT: +".$row['int_bonus']." <br>
							AGI: +".$row['agi_bonus']." <br>
							DEX: +".$row['dex_bonus']." <br>
							LUK: +".$row['luk_bonus']." <br><br>

							<input type='button' class='btn btn-success' value='Escolher classe!' onClick='location.href=\"change_class.php?i=".$row['id']."\"'>
						</td>
					</tr>
				";
			}
			echo"
				</table>
			";
		} else if($player->getRankClass() == 1) {
			echo"
				Você já escolheu uma classe de rank 1. As classes de rank 2 estarão habilitadas a partir do andar 20.  
			";
		}
		?>
		</div>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>