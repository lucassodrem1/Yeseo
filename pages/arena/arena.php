<?php
require_once '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$arena = new Arena($player->getID());
$enemy = new Enemy($arena->getEnemyID());
$playerStats = $player->getStats();
$playerCurrentStats = $arena->getPlayerCurrentStats();
$enemyStats = $enemy->getStats();
$enemyCurrentStats = $arena->getEnemyCurrentStats();
$enemyRewards = $enemy->getRewards();
$arena->getPlayerID();

//Caso o player tenha pet.
$petDamage = 0;
if($player->getPet() != 0) {
	$pet = new Pet($player->getPet());
	$petDamage = $pet->getDamage();
}


if($arena->getPlayerDied() == 1 || $arena->getEnemyDied() == 1) {
	header('Location: afterBattle.php');
}

$playerEquips = $player->getEquips();
$equip = new Equip();

//Pegar o swordType do player. Verificar se usa arma1 e arma2 antes. Caso não use arma1, pega o swordType da arma2 e vice-versa.
//Caso arma1 e arma2 estiverem vazios, o type é physical.
$swordType;

if($playerEquips->arma1 == 0 && $playerEquips->arma2 == 0) {
	$swordType = 'P';
} else {
	if($playerEquips->arma1 != 0) {
		$equip->load($playerEquips->arma1);
		$swordType = $equip->getSwordType();
	} else if($playerEquips->arma2 != 0) {
		$equip->load($playerEquips->arma2);
		$swordType = $equip->getSwordType();
	}
}	
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
</head>
<script>
let enemyID = <?php echo $enemy->getID(); ?>;
let enemyHP = <?php echo $enemyCurrentStats->HP; ?>;
let enemyTotalHP = <?php echo $enemyStats->HP; ?>;
let enemyDodgeChance = <?php echo $enemyCurrentStats->agility - $playerCurrentStats->agility; ?>;
let enemyGold = <?php echo $enemyRewards->gold; ?>;

let playerDmg;
let playerMP = <?php echo $playerStats->MP; ?>;
let playerCurrentMP = <?php echo $playerCurrentStats->MP; ?>;
let playerCurrentStrength = <?php echo $playerCurrentStats->strength; ?>;
let playerCurrentIntelligence = <?php echo $playerCurrentStats->intelligence; ?>;
let playerCurrentAgility = <?php echo $playerCurrentStats->agility; ?>;
let playerCurrentDexterity = <?php echo $playerCurrentStats->dexterity; ?>;
let playerCriticalChance  = <?php echo round(($playerCurrentStats->dexterity / 3), 0); ?>;
let playerDied = <?php echo $arena->getPlayerDied(); ?>;
let enemyDied = <?php echo $arena->getEnemyDied(); ?>;

let playerPet = <?php echo $player->getPet(); ?>;

//Caso o player tenha um pet.
let petDamage = 0;
if(playerPet != 0) {
	petDamage = <?php echo $petDamage ?>;
}

let skillSTR = 0;
let skillINT = 0;
let skillAGI = 0;
let skillDEX = 0;

//Variável para identificar o player usou alguma skill AOE.
let skillAOE = 0;


let countDown = <?php echo $arena->getEnemyCurrentTime(); ?>;

//Player Skill Attack
function playerSkill(skillName, skillDamage, skillBuffer, skillGroupBuff, skillType, skillMPcost, skillStrength, skillIntelligence, skillAgility, skillDexterity) {
	if(playerCurrentMP > 0) {
		skillSTR = skillStrength;
		skillINT = skillIntelligence;
		skillAGI = skillAgility;
		skillDEX = skillDexterity;

		let randomDodge = Math.floor((Math.random() * 100) + 1);
		//Se skillType é P, dano físico, se M, dano mágico.
		if(skillType == 'P') {
			playerDmg = skillDamage - <?php echo $enemyCurrentStats->pDEF; ?>;
		} else {
			playerDmg = skillDamage - <?php echo $enemyCurrentStats->mDEF; ?>;
		}

		//Gasto de MP
		playerCurrentMP -= skillMPcost; 
		document.getElementById('playerCurrentMP').innerHTML = playerCurrentMP;
		document.getElementById('playerMPBar').style.width = ((playerCurrentMP / playerMP) * 100) + "%";
		
		//Verifica se o enemy desviou. Se a skill for BUFFER o player nunca irá errar.
		if(skillBuffer != 1) {
			if(enemyDodgeChance >= randomDodge) {
				let dodgeDiv = document.createElement("div");
				dodgeDiv.innerHTML = 'Dodge!';
				document.getElementById('dodge-effect').appendChild(dodgeDiv);
				setTimeout(function() {
					document.getElementById('dodge-effect').innerHTML = '';
				}, 1000);
				return;
			} 
		}	
		
		//Verifica se a skill é AOE.
		if(skillGroupBuff == 1) {
			skillAOE = 1;
		}

		//Skill damage
		enemyHP -= playerDmg;
		document.getElementById('actualEnemyHP').innerHTML = "HP: " + enemyHP;	
		document.getElementById('enemyHPBar').style.width = ((enemyHP / enemyTotalHP) * 100) + "%";
		let damageDiv = document.createElement("span");
		damageDiv.innerHTML = skillName + " -" + playerDmg + "<br>";
		document.getElementById('damage-effect').appendChild(damageDiv);
		setTimeout(function() {
			document.getElementById('damage-effect').innerHTML = '';
		}, 1000);

		//Mudanças de stats.
		playerCurrentStrength += skillSTR;
		playerCurrentIntelligence += skillINT;
		playerCurrentAgility += skillAGI;
		playerCurrentDexterity += skillDEX;
		playerCriticalChance = Math.round(playerCurrentDexterity / 3);
		document.getElementById('playerCurrentStrength').innerHTML = playerCurrentStrength;
		document.getElementById('playerCurrentIntelligence').innerHTML = playerCurrentIntelligence;
		document.getElementById('playerCurrentAgility').innerHTML = playerCurrentAgility;
		document.getElementById('playerCurrentDexterity').innerHTML = playerCurrentDexterity + " (" + playerCriticalChance + "%)";

		//Verifica se o enemy morreu.
		if(enemyHP <= 0) {
			enemyDied = 1;
			alert("Voc\u00ea matou o boss e subiu de andar! \n Recompensas: \n Ryo: " + enemyGold);
			location.href='preAfterBattle.php?p='+playerDied+'&e='+enemyDied+'';
		}
	} else {
		let damageDiv = document.createElement("span");
		damageDiv.innerHTML = "Mana insuficiente! <br>";
		document.getElementById('damage-effect').appendChild(damageDiv);
		setTimeout(function() {
			document.getElementById('damage-effect').innerHTML = '';
		}, 1000);
	}

	//Ajax a cada skill usada.
	$.ajax({
		type: 'POST',
		url: 'arena_action.php',
		data: {enemyID: <?php echo $enemy->getID(); ?>, enemyCurrentHP: enemyHP, enemyCountDown: countDown, playerCurrentMP: playerCurrentMP, skillAOE: skillAOE, skillSTR: skillSTR, 
			   skillINT: skillINT, skillAGI: skillAGI, skillDEX: skillDEX},
		success: function(data) {
			skillSTR = 0;
			skillINT = 0;
			skillAGI = 0;
			skillDEX = 0;
		}
	})
}	


//Se o player estiver com um pet.
if(playerPet != 0) {
	setInterval(function() {
		enemyHP -= petDamage;

		//Mostrar ataque do pet.
		document.getElementById('actualEnemyHP').innerHTML = "HP: " + enemyHP;	
		document.getElementById('enemyHPBar').style.width = ((enemyHP / enemyTotalHP) * 100) + "%";
		let damageDiv = document.createElement("span");
		damageDiv.innerHTML = "Pet: -" + petDamage + "<br>";
		document.getElementById('damage-effect').appendChild(damageDiv);
		setTimeout(function() {
			document.getElementById('damage-effect').innerHTML = '';
		}, 1500);

		//Verifica se o enemy morreu.
		if(enemyHP <= 0) {
			enemyDied = 1;
			alert("Voc\u00ea matou o boss e subiu de andar! \n Recompensas: \n Ryo: " + enemyGold + " / nº players no lobby.");
			location.href='preAfterBattle.php?p='+playerDied+'&e='+enemyDied+'';
		}
	}, 1000);
}

$(document).ready(function() {
	//Player Attack
	$('#enemy').click(function() {
		let swordType = '<?php echo $swordType; ?>';
		//Se swordType é P, dano físico, se M, dano mágico.
		if(swordType == 'P') {
			playerDmg = playerCurrentStrength - <?php echo $enemyCurrentStats->pDEF; ?>;
		} else {
			playerDmg = playerCurrentIntelligence - <?php echo $enemyCurrentStats->mDEF; ?>;
		}

		let randomDodge = Math.floor((Math.random() * 100) + 1);
		let randomCritical = Math.floor((Math.random() * 100) + 1);

		//Verifica se o enemy desviou.
		if(enemyDodgeChance >= randomDodge) {
			let dodgeDiv = document.createElement("div");
			dodgeDiv.innerHTML = 'Dodge!';
			document.getElementById('dodge-effect').appendChild(dodgeDiv);
			setTimeout(function() {
				document.getElementById('dodge-effect').innerHTML = '';
			}, 1000);
			return;
		} 

		//Verifica se o player critou.
		if(playerCriticalChance >= randomCritical) {
			playerDmg *= 3;
			let critDiv= document.createElement("span");
			critDiv.innerHTML = 'Critou! '
			critDiv.style.color = '#660000';
			document.getElementById('damage-effect').appendChild(critDiv);
		}

		//Ataque do player
		enemyHP -= playerDmg;
		document.getElementById('actualEnemyHP').innerHTML = "HP: " + enemyHP;	
		document.getElementById('enemyHPBar').style.width = ((enemyHP / enemyTotalHP) * 100) + "%";
		let damageDiv = document.createElement("span");
		damageDiv.innerHTML = "-" + playerDmg + "<br>";
		document.getElementById('damage-effect').appendChild(damageDiv);
		setTimeout(function() {
			document.getElementById('damage-effect').innerHTML = '';
		}, 1000);
	
		//Verifica se o enemy morreu.
		if(enemyHP <= 0) {
			enemyDied = 1;
			alert("Voc\u00ea matou o boss e subiu de andar! \n Recompensas: \n Ryo: " + enemyGold + " / nº players no lobby.");
			location.href='preAfterBattle.php?p='+playerDied+'&e='+enemyDied+'';
		}
	});

	//Contador
	let count = document.getElementById('count').innerHTML = countDown + 's';
	
	setInterval(function() {
		countDown -= 1;
		document.getElementById('count').innerHTML = countDown + 's';
		
		if(countDown <= 5) {
			document.getElementById('count').style.color = 'red';
		}
		
		//Se Player não matar o mob.
		if(countDown <= 0) {
			playerDied = 1;
			alert('Voc\u00ea morreu!');
			location.href='preAfterBattle.php?p='+playerDied+'&e='+enemyDied+'';
		}
	}, 1000);
	
	//Ajax a cada 0.5 segundos.
	setInterval(function() {
		$.ajax({
			type: 'POST',
			url: 'arena_action.php',
			data: {enemyID: <?php echo $enemy->getID(); ?>, enemyCurrentHP: enemyHP, enemyCountDown: countDown, playerCurrentMP: playerCurrentMP, skillAOE: skillAOE, skillSTR: skillSTR, 
				   skillINT: skillINT, skillAGI: skillAGI, skillDEX: skillDEX},
			success: function(data) {
				obj = JSON.parse(data);
				skillSTR = 0;
				skillINT = 0;
				skillAGI = 0;
				skillDEX = 0;

				playerCurrentMP = obj.playerMP;
				playerCurrentStrength = obj.playerStrength;
				playerCurrentIntelligence = obj.playerIntelligence;
				playerCurrentAgility = obj.playerAgility;
				playerCurrentDexterity = obj.playerDexterity;
				playerCriticalChance = Math.round(playerCurrentDexterity / 3);
				document.getElementById('playerCurrentMP').innerHTML = playerCurrentMP;
				document.getElementById('playerMPBar').style.width = ((playerCurrentMP / playerMP) * 100) + "%";
				document.getElementById('playerCurrentStrength').innerHTML = playerCurrentStrength;
				document.getElementById('playerCurrentIntelligence').innerHTML = playerCurrentIntelligence;
				document.getElementById('playerCurrentAgility').innerHTML = playerCurrentAgility;
				document.getElementById('playerCurrentDexterity').innerHTML = playerCurrentDexterity + " (" + playerCriticalChance + "%)";
			}
		})
	}, 2000);	
});
</script>
<body>
<div class='body col-12' style='height: 100%'>
	<div class='battle col-9'>
		<?php
		echo"
		<table border='1' class='arena-enemy-stats'>
			<tr>
				<td colspan='2'> ".$enemy->getName()." (LVL. ".$enemy->getLevel().") </td>
			</tr>
			<tr>
				<td> pDEF: ".$enemyCurrentStats->pDEF." </td>
				<td> mDEF: ".$enemyCurrentStats->mDEF." </td>
			</tr>
			<tr>
				<td colspan='2'> Agilidade: ".$enemyCurrentStats->agility." </td>
			</tr>	
		</table>
		
		<table border='0' class='arena-enemy-image'>
			<tr>
				<td colspan='2'> <span id='count'></span> </td>
			</tr>	
			<tr>
				<td colspan='2'> <span id='actualEnemyHP'> HP: ".$enemyCurrentStats->HP."</span> / ".$enemyStats->HP." </td>
			</tr>
			<tr>
				<td colspan='2'> 
					<div id='enemy-hp'><div id='enemyHPBar'style='border: 0; background-color: red; height: 100%; width: ".(($enemyCurrentStats->HP / $enemyStats->HP) * 100)."%'> </div></div><br>
				</td>
			</tr>		
			<tr>
				<td colspan='2' style='cursor: pointer' id='enemy'> <img id='enemy-image' src='../../images/mobs/".$enemy->getImage()."'> </td>
			</tr>
			<tr>
				<td id='dodge-effect'></td>
				<td id='damage-effect'></td> 
			</tr>		
		</table>
		
		<table border='1' class='arena-player-stats'>
			<tr>
				<td colspan='2'> 
					".$player->getUsername()." <br>
					MP: <span id='playerCurrentMP'> ".$playerCurrentStats->MP." </span> /  ".$playerStats->MP."
					<div id='player-mp'><div id='playerMPBar'style='border: 0; background-color: blue; height: 100%; width: ".(($playerCurrentStats->MP / $playerStats->MP) * 100)."%'> </div></div>
				</td>
			</tr>
			<tr>	
				<td> STR: <span id='playerCurrentStrength'>".$playerCurrentStats->strength."</span> </td>
				<td> INT: <span id='playerCurrentIntelligence'>".$playerCurrentStats->intelligence."</span> </td>
			</tr>
			<tr>
				<td> Agilidade: <span id='playerCurrentAgility'>".$playerCurrentStats->agility."</span> </td> 	
				<td> Destreza: <span id='playerCurrentDexterity'>".$playerCurrentStats->dexterity." (".$playerCurrentStats->criticalChance."%)</span> </td> 	
			</tr>		
		</table>
		";
		//Tabela do pet.
		if($player->getPet() != 0) {
			echo"
			<table border='0' class='arena-pet' style='float: right'>
				<tr>
					<td> Nome: ".$pet->getName()."</td>
				</tr>
				<tr>
					<td> Damage: ".$pet->getDamage()."/s </td>
				</tr>	
				<tr>
					<td> <img class='pet-arena-image' src='../../images/mobs/".$pet->getImage()."'> </td>
				</tr>	
			</table>
			";
		}

		echo"
		<table border='1' id='arena-players-list'>
			<tr>
				<td colspan='5'> Jogadores nesta batalha. </td>
			</tr>
			<tr>
		";
		$sql = "SELECT `battle_id` FROM `player_enemies` WHERE `player_id`='".$player->getID()."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$sql2 = "SELECT `player_id` FROM `player_enemies` WHERE `battle_id`='".$row['battle_id']."'";
		$query2 = query($sql2);
		while($row2 = mysql_fetch_assoc($query2)) {
			$sql3 = "SELECT * FROM `users` WHERE `id`='".$row2['player_id']."'";
			$query3 = query($sql3);
			$users = mysql_fetch_assoc($query3);
			echo"
				<td> ".$users['username']." (".$users['class'].")</td>
			";		
		}
		echo"
			</tr>
		</table>
	</div>
	<div class='battle col-3' id='player-skills-arena'>
		<table border='1' style='margin: 0px auto'>
				<tr>
					<td colspan='5'> Suas skills </td>
				</tr>	
				<tr>
					<td> Nome </td>
					<td> Dano </td>
					<td> AOE </td>
					<td> Buff </td>
					<td> Custo de MP </td>
				</tr>
		";
			$sql = "SELECT `skill_id` FROM `player_skills` WHERE `player_id`='".$player->getID()."'";
			$query = query($sql);
			while($row = mysql_fetch_assoc($query)) {
				$skill = new Skill();
				$skill->load($row['skill_id']);
				$skillStats = $skill->getStats();
				echo"
				<tr onClick='playerSkill(\"".$skill->getName()."\", ".$skill->getDamage().", ".$skill->getBuffer().", ".$skill->getGroupBuff().", \"".$skill->getType()."\", ".$skill->getMPcost().", ".$skillStats->strength.", 
										".$skillStats->intelligence.", ".$skillStats->agility.", ".$skillStats->dexterity.")'>
					<td> (".$skill->getType().") ".$skill->getColorSkillName()." </td>
					<td> ".$skill->getDamage()." </td>
				";
				if($skill->getGroupBuff() == 1) {
					echo "<td> Sim </td>";
				} else {
					echo "<td> Não </td>";
				}
				echo"
					<td>
				";	
				if($skillStats->strength != 0) {
					echo "STR: +" . $skillStats->strength . "<br>"; 
				}
				if($skillStats->intelligence != 0) {
					echo "INT: +" . $skillStats->intelligence . "<br>"; 
				}
				if($skillStats->agility != 0) {
					echo "AGI: +" . $skillStats->agility . "<br>"; 
				}
				if($skillStats->dexterity != 0) {
					echo "DEX: +" . $skillStats->dexterity . "<br>"; 
				}
				if($skillStats->lucky != 0) {
					echo "LUK: +" . $skillStats->lucky . "<br>"; 
				}
				echo"
					<td> ".$skill->getMPcost()." </td>
				</tr>
				";
			}		
		echo"	
			</table>
		";
		?>
	</div>
</div>
</body>
</html>