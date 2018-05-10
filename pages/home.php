<?php
require '../functions.php';
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
<link type="text/css" rel="stylesheet" href="../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
const load = url => {
	let loadingDiv = document.createElement('div');
	let loadingImage = document.createElement('img');
	loadingImage.id = 'loading-image';
	loadingImage.src = '../images/misc/loading.gif';
	loadingDiv.appendChild(loadingImage);
	loadingDiv.style.textAlign = 'center';
	$(loadingDiv).insertBefore('.game');
	$('.game').hide();
	$('body').load(url);
}

$(document).ready(function() {
	$('#show_equip').click(() => {
		let equips = document.getElementById('player_equips_menu').style.display;
		
		if(equips == 'none') {
			$('#player_equips_menu').show();
		} else {
			$('#player_equips_menu').hide();
		}		
	});

	//Verifica se há mensagem para o player. No ínicio da página.
	$.ajax({
		url: 'message_notification.php',
		success: function(data) {
			obj = JSON.parse(data);
			if(obj.haveMessage == 1) {
				document.getElementById('message-notification').style.display = 'block';
				document.getElementById('amount-message').innerHTML = obj.amount;
				$('#amount-message').show();
			}
		}
	})

	//Verifica se há mensagem para o player. A cada 5 segundos.
	setInterval(function() {
		$.ajax({
			url: 'message_notification.php',
			success: function(data) {
				obj = JSON.parse(data);
				if(obj.haveMessage == 1) {
					document.getElementById('message-notification').style.display = 'block';
					document.getElementById('amount-message').innerHTML = obj.amount;
					$('#amount-message').show();
				}
			}
		})
	}, 5000)
})	
			
</script>
</head>
<body>
<div class='header col-12'>
	<div id='header-table'> 
		<img src='../images/misc/message.png' class='header-table-image' title='Mensagem' style='float: left' onClick='location.href="email/messages.php"'>
		<img src='../images/misc/exit.png' class='header-table-image' title='Sair' onClick='location.href="../logout.php"'> 
	</div>	
</div>

<div class='body col-12'>
	<div class='stats col-2'>
		<?php
		echo"
			<img id='class-image' src='../images/class/".$game->classImage[$player->getClass()]."'>
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
				<div class='button btn btn-primary' onClick='location.href=\"home.php\"'> Home </div>  
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"char/menu.php\"'> Personagem </div> 
			</div>
			<br>	
			<div style='display: flex;'>
				<div class='button btn btn-primary' id='show_equip'> Equips </div> 
				<div class='button btn btn-primary' style='margin-left: 10px' onClick='location.href=\"inventory/bag.php\"'> Mochila </div>
			</div>	
			<br>
			<div> <img id='message-notification' src='../images/misc/message-notification.png' onClick='location.href=\"email/messages.php\"'> <span id='amount-message'> </span> </div>
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
		Pra&ccedil;a da cidade <br>
		<hr style='border: 1px solid black'> <br><br>
		
		<a href='arena/pre_lobby.php'><div class='button btn btn-danger' style='float: left; width: 40%'> Arena </div></a>
		<a href='hall/hall.php'><div class='button btn btn-primary' style='float: right; width: 40%'> Hall </div></a> <br><br><br><br>
		<a href='quest/quests.php'><div class='button btn btn-primary' style='float: left; width: 40%'> Mural de Quests </div></a> 
		<a href='zone/pre_lobby.php'><div class='button btn btn-warning' style='float: right; width: 40%'> Zona desprotegida </div></a> <br><br><br><br>
		<a href='bank/account.php'><div class='button btn btn-primary' style='float: left; width: 40%'> Banco </div></a> 
		<a href='store/market_menu.php'><div class='button btn btn-primary' style='float: right; width: 40%'> Mercado </div></a> <br><br><br><br> 
		<a href='temple/menu.php'><div class='button btn btn-primary' style='float: left; width: 40%'> Templo </div></a>
		<a href='guild/guild.php'><div class='button btn btn-primary' style='float: right; width: 40%;'> Guilda </div></a> <br><br><br><br> 
		<div onClick='load("teste.php")' class='button btn btn-primary' style='float: left; width: 40%'> Teste </div></a>
		<br>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>