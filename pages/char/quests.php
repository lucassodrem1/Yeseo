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

	<div class='game col-10'>
		Quests <br>
		<hr style='border: 1px solid black'> <br><br>
		<div class='scroll-div'>
		<table border='1'>
			<tr>
				<td> Nome </td>
				<td> Tarefas </td>
				<td> Recompensas </td>
				<td> </td>
			</tr>
			<?php
			$sql = "SELECT * FROM `quests` WHERE `min_floor`='".$player->getActualFloor()."'";
			$query = query($sql);
			$quest = new Quest();
			while($row = mysql_fetch_assoc($query)) {
				$quest->load($row['id']);
				$questRewards = $quest->getRewards();
				$questRewardsName = $quest->getRewardsName();
				$sql5 = "SELECT * FROM `player_quests` WHERE `quest_id`='".$quest->getID()."' AND `player_id`='".$player->getID()."'";
				$query5 = query($sql5);
				if(mysql_num_rows($query5) == 0) {
					echo"
					<tr>
						<td> ".$quest->getName()." </td>
						<td>
					";
					$sql2 = "SELECT * FROM `quest_items` WHERE `quest_id`='".$quest->getID()."'";
					$query2 = query($sql2);
					$item = new Item();
					while($taskItem = mysql_fetch_assoc($query2)) {
						$item->load($taskItem['item_id']);

						echo"
							Item: <span class='info-link' onClick='itemInfo(".$item->getID().")'>".$item->getName()."</span>(".$taskItem['amount'].") <br>
						";
					}
					$sql3 = "SELECT * FROM `quest_enemies` WHERE `quest_id`='".$quest->getID()."'";
					$query3 = query($sql3);
					while($taskEnemy = mysql_fetch_assoc($query3)) {
						$enemy = new Enemy($taskEnemy['enemy_id']);

						echo"
							Inimigo: <span class='info-link' onClick='mobInfo(".$enemy->getID().")'>".$enemy->getName()."</span>(".$taskEnemy['amount'].")<br>
						";
					}
					echo"
						</td>
						<td>
					";
					if($questRewards->gold != 0) {
						echo" Ryo: ".$questRewards->gold." <br>";
					}
					if($questRewards->equip != 0) {
						$equip = new Equip();
						$equip->load($questRewards->equip);
						echo" Equip: <span class='info-link' onClick='equipInfo(".$equip->getID().")'> ".$questRewardsName->equip."</span> <br>";
					}
					if($questRewards->item != 0) {
						$item = new Item();
						$item->load($questRewards->item);
						echo" Item: <span class='info-link' onClick='itemInfo(".$item->getID().")'>".$questRewardsName->item."</span>(".$questRewards->itemAmount.") <br>";
					}
					if($questRewards->skill != 0) {
						echo" Skill: ".$questRewardsName->skill." <br>";
					}
					if($questRewards->pet != 0) {
						echo" Pet: ".$questRewardsName->pet." <br>";
					}
					echo"
						</td>
						<td> <input type='button' value='Aceitar' class='btn btn-success' onClick='location.href=\"accept_quest.php?i=".$quest->getID()."\"'> </td>
					</tr>
					";
				}	
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