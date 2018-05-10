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
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
	var $scrollable  = $(".scrollable"),
    $scrollbar   = $(".scrollbar"),
    height       = $scrollable.outerHeight(true),    // visible height
    scrollHeight = $scrollable.prop("scrollHeight"), // total height
    barHeight    = height * height / scrollHeight;   // Scrollbar height!

	// Scrollbar drag:
	$scrollbar.height( barHeight ).draggable({
	  axis : "y",
	  containment : "parent", 
	  drag: function(e, ui) {
	    $scrollable.scrollTop( scrollHeight / height * ui.position.top  );
	  }
	}); 

	// Element scroll:
	$scrollable.on("scroll", function() {
	  $scrollbar.css({top: $scrollable.scrollTop() / height * barHeight });
	});

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
		Loja de equipamentos <br>
		<hr style='border: 1px solid black'> <br><br>
		<div class='text-balloon alert alert-info'>
			Bem-vindo a loja de equipamentos. Espero que tenha ryo para gastar...
		</div>
		<br>
		<img class='npc-image' src='../../images/npcs/equip_store.gif'>
		<div class="parent">
 		<div class="scrollbar"></div>
 		<div class="scrollable">
		<table border='0' style='width: 100%'>
			<tr>
				<td colspan='6' style='border-bottom: 1px solid black'> Equips </td>
			</tr>	
			<tr>
				<td style='border-bottom: 1px solid black'> </td>
				<td style='border-bottom: 1px solid black'> Nome </td>
				<td style='border-bottom: 1px solid black'> Preço </td>
				<td style='border-bottom: 1px solid black'> Slot </td>
				<td style='border-bottom: 1px solid black'> Stats </td>
				<td style='border-bottom: 1px solid black'> </td>
			</tr>
			<?php
			$sql = "SELECT * FROM `equips` WHERE `in_store`='1' AND `floor_level`<='".$player->getActualFloor()."'";
			$query = query($sql);
			while($row = mysql_fetch_assoc($query)) {
				$equip = new Equip();
				$equip->load($row['id']);
				$equipStats = $equip->getStats();
				echo"
				<tr>
					<td style='border-bottom: 1px solid black'> <img class='equips-items-image' src='../../images/equips/".$equip->getImage()."'> </td>
					<td style='border-bottom: 1px solid black'> 
				";
					if($equip->getSlot() == "arma") {
						echo "(" . $equip->getSwordType() . ")<span style='color: ".$equip->getRarityColor()."'> ".$equip->getName()." </span>";
					} else {
						echo "<span style='color: ".$equip->getRarityColor()."'> ".$equip->getName()." </span>";
					}
				echo"		
					</td>
					<td style='border-bottom: 1px solid black'> ".$equip->getPrice()." ryos </td>
					<td style='border-bottom: 1px solid black'>
				";
					if($equip->getSlot() == "arma") {
						echo $equip->getSlot() . ' (' . $equip->getHanded() . 'H)';
					} else {
						echo $equip->getSlot();
					}	 
				echo"	 
					</td>
					<td style='border-bottom: 1px solid black'> 
				";
					if($equipStats->strength > 0) {
						echo 'STR: +' . $equipStats->strength . '<br>';
					} 	
					if($equipStats->intelligence > 0) {
						echo 'INT: +' . $equipStats->intelligence . '<br>';
					}	
					if($equipStats->agility > 0) {
						echo 'AGI: +' . $equipStats->agility . '<br>';
					}
					if($equipStats->dexterity > 0) {
						echo 'DEX: +' . $equipStats->dexterity . '<br>';
					}
					if($equipStats->lucky > 0) {
						echo 'LUK: +' . $equipStats->lucky . '<br>';
					}
				echo"	
					</td>
					<td style='border-bottom: 1px solid black; background-color: #00cc00; color: white; cursor: pointer' onClick='location.href=\"buy_equip.php?i=".$equip->getID()."\"'> Comprar </td>
				</tr>
				";	
			}
			?>	
			</table>
			</div>
			</div>
			<br>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>