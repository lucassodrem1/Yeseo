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
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script>
let saveContent;

function mobInfo(mobID) {
	if(document.body.style.backgroundColor != 'black') {
		saveContent = document.getElementsByClassName('game')[0].innerHTML;
	}
	

	$.ajax({
		type: 'POST',
		url: '../ajax/mob_info.php',
		data: {mobID: mobID},
		success: function(data) {
			document.getElementsByClassName('game')[0].innerHTML = data;
			document.body.style.backgroundColor = 'black';
			document.getElementsByClassName('stats')[0].style.opacity = "0.1"
			document.getElementById('mob-info-table').style.backgroundColor = "white";
		}
	})
}

function itemInfo(itemID) {
	if(document.body.style.backgroundColor != 'black') {
		saveContent = document.getElementsByClassName('game')[0].innerHTML;
	}

	$.ajax({
		type: 'POST',
		url: '../ajax/item_info.php',
		data: {itemID: itemID},
		success: function(data) {
			document.getElementsByClassName('game')[0].innerHTML = data;
			document.body.style.backgroundColor = 'black';
			document.getElementsByClassName('stats')[0].style.opacity = "0.1"
			document.getElementById('item-info-table').style.backgroundColor = "white";
		}
	})
}

function equipInfo(equipID) {
	if(document.body.style.backgroundColor != 'black') {
		saveContent = document.getElementsByClassName('game')[0].innerHTML;
	}

	$.ajax({
		type: 'POST',
		url: '../ajax/equip_info.php',
		data: {equipID: equipID},
		success: function(data) {
			document.getElementsByClassName('game')[0].innerHTML = data;
			document.body.style.backgroundColor = 'black';
			document.getElementsByClassName('stats')[0].style.opacity = "0.1"
			document.getElementById('equip-info-table').style.backgroundColor = "white";
		}
	})
}

function closeInfos() {
	document.getElementsByClassName('game')[0].innerHTML = saveContent;
	document.body.style.backgroundColor = 'white';
	document.getElementsByClassName('stats')[0].style.opacity = "1";
}

$(document).ready(function() {
	var $scrollable  = $(".higher-scrollable"),
    $scrollbar   = $(".scrollbar"),
    height       = $scrollable.outerHeight(true),    // visible height
    scrollHeight = $scrollable.prop("scrollHeight"), // total height
    barHeight    = height * height / scrollHeight;   // Scrollbar height!

	// Scrollbar drag:
	$scrollbar.height( barHeight ).draggable({
	  axis : "y",
	  containment : "higher-parent", 
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
			AGI: ".$stats->agility." / DEX: ".$stats->dexterity." (".$stats->criticalChance."%)<br> 
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
		Conhecimento <br>
		<hr style='border: 1px solid black'> <br><br>
		<div class="higher-parent" style='margin: 0 auto;'>
 			<div class="scrollbar"></div>
 			<div class="higher-scrollable" style='margin: 0 auto;'>
				<table style='width: 100%'>
					<tr>
						<td colspan='3' style='border-bottom: 1px solid black'> Monstros conhecidos </td>
					</tr>
					<tr>
				<?php
				$sql = "SELECT `enemy_id` FROM `player_enemies_knowledge` WHERE `player_id`='".$player->getID()."' ORDER BY `enemy_id`";
				$query = query($sql);
				$count = 1;
				while($row = mysql_fetch_assoc($query)) {
					$enemy = new Enemy($row['enemy_id']);
					if($enemy->getID() < 1000) {
						echo"
							<td> 
								<span class='btn btn-danger' style='cursor: pointer' onClick='mobInfo(".$enemy->getID().")'> 
									<img class='know-enemy-image' src='../../images/mobs/".$enemy->getImage()."'> 
								</span> 
							</td>
						";
					} else {
						echo"
							<td> 
								<span class='btn btn-primary' style='cursor: pointer' onClick='mobInfo(".$enemy->getID().")'> 
									<img class='know-enemy-image' src='../../images/mobs/".$enemy->getImage()."'> 
								</span> 
							</td>
						";
					}
					if($count % 3 == 0) {
						echo"
						</tr>
						<tr>
						";
					}
					$count++;
				}
				?>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>