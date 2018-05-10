<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
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
	$('body').css('height',$('body').height());
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
<body style='overflow: scroll'>
<div class='header col-12'>
	SAHDUASHDUASHFUSADFHUH
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
			AGI: ".$stats->agility." / DEX: ".$stats->dexterity." (".$stats->criticalChance."%) <br> 
			LUK: ".$stats->lucky." <br><br>
			<div style='display: flex;'>
				<div class='button btn btn-primary' onClick='location.href=\"../home.php\"'>Home </div> 
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"menu.php\"'> Personagem </div> 
			</div>
			<br>	
			<div style='display: flex;'>
				<div class='button btn btn-primary' id='show_equip'> Equips </div> 
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"../inventory/bag.php\"'> Mochila </div>
			</div>	
			<div id='player_equips_menu' style='display: none'>
		";
		if($equipsID->capacete != 0) {
			echo "Capacete: ".$equips->capacete." <a href='unequip.php?i=".$equipsID->capacete."&slot=capacete'>(X)</a> <br>";
		} else {
			echo "Capacete: Nenhum <br>";
		}
		if($equipsID->armadura != 0) {
			echo "Armadura: ".$equips->armadura." <a href='unequip.php?i=".$equipsID->armadura."&slot=armadura'>(X)</a> <br>";
		} else {
			echo "Armadura: Nenhum <br>";
		}
		if($equipsID->luvas != 0) {
			echo "Luvas: ".$equips->luvas." <a href='unequip.php?i=".$equipsID->luvas."&slot=luvas'>(X)</a> <br>";
		} else {
			echo "Luvas: Nenhum <br>";
		}
		if($equipsID->botas != 0) {
			echo "Botas: ".$equips->botas." <a href='unequip.php?i=".$equipsID->botas."&slot=botas'>(X)</a> <br>";
		} else {
			echo "Botas: Nenhum <br>";
		}
		if($equipsID->arma1 != 0) {
			echo "Arma Esq: ".$equips->arma1." <a href='unequip.php?i=".$equipsID->arma1."&slot=arma1'>(X)</a> <br>";
		} else {
			echo "Arma Esq: Nenhum <br>";
		}
		if($equipsID->arma2 != 0) {
			echo "Arma Dir: ".$equips->arma2." <a href='unequip.php?i=".$equipsID->arma2."&slot=arma2'>(X)</a> <br>";
		} else {
			echo "Arma Dir: Nenhum <br>";
		}
		if($equipsID->capa != 0) {
			echo "Capa: ".$equips->capa." <a href='unequip.php?i=".$equipsID->capa."&slot=capa'>(X)</a> <br>";
		} else {
			echo "Capa: Nenhum <br>";
		}
		if($equipsID->colar != 0) {
			echo "Colar: ".$equips->colar." <a href='unequip.php?i=".$equipsID->colar."&slot=colar'>(X)</a> <br>";
		} else {
			echo "Colar: Nenhum <br>";
		}
		echo"
			</div>		
		";
		?>
	</div>

	<div class='game col-10' style='background-color: #fbfbfb'>
		Perfil <br>
		<hr style='border: 1px solid black'> <br><br>
		<div class='scroll-div'>
			<?php
			$myEquips = new Equip(); 
			echo"
			<table border='0' id='perfil-table'>
				<tr>
					<td style='border-bottom: 1px solid black' colspan='5'> ".$player->getUsername()." </td>
				</tr>
				<tr>
					".$myEquips->load($equipsID->capacete)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>	
					<td rowspan='4' style='border-bottom: 1px solid #d7d7d7'> <img id='toy-image' src='../../images/misc/perfil.png'> </td>
					".$myEquips->load($equipsID->luvas)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
				</tr>	
				<tr>
					".$myEquips->load($equipsID->armadura)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
					".$myEquips->load($equipsID->botas)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
				</tr>	 	
				<tr>
					".$myEquips->load($equipsID->capa)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
					".$myEquips->load($equipsID->colar)."
					<td> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
				</tr>
				<tr>
					".$myEquips->load($equipsID->arma1)."
					<td style='border-bottom: 1px solid #d7d7d7'> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
					".$myEquips->load($equipsID->arma2)."
					<td style='border-bottom: 1px solid #d7d7d7'> <img class='equips-items-image' src='../../images/equips/".$myEquips->getImage()."'> </td>
				</tr>	
				<tr style='background-color: #d7d7d7'>
					<td colspan='3'> Pontos de Atributos: ".$player->getStatsPoints()." </td>
				</tr>
				<form method='post' action='increase_stats.php'>
				<tr style='background-color: #d7d7d7'>	
					
					<td> STR: ".$stats->strength." + <input name='str' min='0' value='0' style='width: 20%' type='number'> </td>
					<td> INT: ".$stats->intelligence." + <input name='int' min='0' value='0' style='width: 20%' type='number'> </td>
					<td> AGI: ".$stats->agility." + <input name='agi' min='0' value='0' style='width: 20%' type='number'> </td>
				</tr>
				<tr style='background-color: #d7d7d7'>	
					<td> DEX: ".$stats->dexterity." + <input name='dex' min='0' value='0' style='width: 20%' type='number'> </td>
					<td> LUK: ".$stats->lucky." + <input name='luk' min='0' value='0' style='width: 20%' type='number'> </td>
					<td> <input type='submit' value='Distribuir pontos' class='btn btn-success'> </td>
				</tr>
				</form>	
			</table>
			</div>
			";
			?>
		</div>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>