<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$stats = $player->getStats();
$equips = $player->getEquipsName();
$equipsID = $player->getEquips();
$game = new Game();

$sql = "SELECT * FROM `bank` WHERE `owner`='".$player->getID()."'";
$query = query($sql);
if(mysql_num_rows($query) == 0) {
	die(header('Location: create_account.php'));
}
$bank = mysql_fetch_assoc($query);
?>
<html>
<head>
<link type="text/css" rel="stylesheet" href="../../style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="../../jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
		
function depositTable() {
	document.getElementById("space").innerHTML = '';
	let table = document.createElement("div");
	table.innerHTML = "Quant. <input type='number' id='amount-deposit'> <br><br> Senha: <input type='password' id='password-deposit'> <br><br> <input class='btn' type='button' value='Depositar' onClick='deposit()'>";
	document.getElementById("space").appendChild(table);
}

function deposit() {
	let amount = document.getElementById('amount-deposit').value;
	let accountPassword = <?php echo $bank['password']; ?>;
	let password = document.getElementById('password-deposit').value;
	let playerGold = document.getElementById('playerGold').innerHTML;

	//Verifica se o amount é > 0.
	if(amount < 0) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> O valor não pode ser negativo.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
		return;
	}

	//Verifica se o player possui gold.
	if(playerGold < amount) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> Ryo insuficiente.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
	} else {
		//Verifica se a senha está correta.
		if(accountPassword != password) {
			let message = document.createElement("div");
			message.className = 'alert alert-danger';
			message.innerHTML = '<strong>Aviso!</strong> Senha incorreta.';
			document.getElementById('alert-space').appendChild(message);

			setTimeout(function() {
				document.getElementById('alert-space').removeChild(message);
			}, 1200)
		} else {
			$.ajax({
				type: 'POST',
				url: 'deposit.php',
				data: {amount: amount, accountID: <?php echo $bank['account_id']; ?>},
				success: function(data) {
					obj = JSON.parse(data);
					document.getElementById('amount-account').innerHTML = obj.newAmount;
					document.getElementById('playerGold').innerHTML = obj.playerGold;
				}
			})

			let message = document.createElement("div");
			message.className = 'alert alert-success';
			message.innerHTML = 'Ryo depositado!';
			document.getElementById('alert-space').appendChild(message);

			setTimeout(function() {
				document.getElementById('alert-space').removeChild(message);
			}, 1200)
		}	
	}	
}

function withdrawTable() {
	document.getElementById("space").innerHTML = '';
	let table = document.createElement("div");
	table.innerHTML = "Quant. <input type='number' id='amount-withdraw'> <br><br> Senha: <input type='password' id='password-withdraw'> <br><br> <input class='btn' type='button' value='Sacar' onClick='withdraw()'>";
	document.getElementById("space").appendChild(table);
}

function withdraw() {
	let amount = document.getElementById('amount-withdraw').value;
	let accountAmount = document.getElementById('amount-account').innerHTML;
	let password = document.getElementById('password-withdraw').value;
	let accountPassword = <?php echo $bank['password']; ?>;

	//Verifica se o amount é > 0.
	if(amount < 0) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> O valor não pode ser negativo.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
		return;
	}

	//Verifica se a conta possui gold.
	if(accountAmount < amount) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> Ryo insuficiente.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
	} else {
		//Verifica se a senha está correta.
		if(accountPassword != password) {
			let message = document.createElement("div");
			message.className = 'alert alert-danger';
			message.innerHTML = '<strong>Aviso!</strong> Senha incorreta.';
			document.getElementById('alert-space').appendChild(message);

			setTimeout(function() {
				document.getElementById('alert-space').removeChild(message);
			}, 1200)
		} else {
			$.ajax({
				type: 'POST',
				url: 'withdraw.php',
				data: {amount: amount, accountID: <?php echo $bank['account_id']; ?>},
				success: function(data) {
					obj = JSON.parse(data);
					document.getElementById('amount-account').innerHTML = obj.newAmount;
					document.getElementById('playerGold').innerHTML = obj.playerGold;
				}
			})

			let message = document.createElement("div");
			message.className = 'alert alert-success';
			message.innerHTML = 'Ryo sacado!';
			document.getElementById('alert-space').appendChild(message);

			setTimeout(function() {
				document.getElementById('alert-space').removeChild(message);
			}, 1200)
		}	
	}	
}

function transferTable() {
	document.getElementById("space").innerHTML = '';
	let table = document.createElement("div");
	table.innerHTML = "Conta ID: <input type='number' id='account-id'> <br><br> Quant. <input type='number' id='amount-transfer'> <br><br> Senha: <input type='password' id='password-transfer'> <br><br> <input class='btn' type='button' value='Transferir' onClick='transfer()'>";
	document.getElementById("space").appendChild(table);
}

function transfer() {
	let accountID = document.getElementById('account-id').value;
	let amount = document.getElementById('amount-transfer').value;
	let accountAmount = document.getElementById('amount-account').innerHTML;
	let password = document.getElementById('password-transfer').value;
	let accountPassword = <?php echo $bank['password']; ?>;

	//Verifica se o amount é < 0.
	if(amount < 0) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> O valor não pode ser negativo.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
		return;
	}

	//Verifica se a conta possui gold.
	if(accountAmount < amount) {
		let message = document.createElement("div");
		message.className = 'alert alert-danger';
		message.innerHTML = '<strong>Aviso!</strong> Ryo insuficiente.';
		document.getElementById('alert-space').appendChild(message);

		setTimeout(function() {
			document.getElementById('alert-space').removeChild(message);
		}, 1200)
	} else {
		//Verifica se a senha está correta.
		if(accountPassword != password) {
			let message = document.createElement("div");
			message.className = 'alert alert-danger';
			message.innerHTML = '<strong>Aviso!</strong> Senha incorreta.';
			document.getElementById('alert-space').appendChild(message);

			setTimeout(function() {
				document.getElementById('alert-space').removeChild(message);
			}, 1200)
		} else {
			$.ajax({
				type: 'POST',
				url: 'transfer.php',
				data: {amount: amount, accountID: accountID},
				success: function(data) {
					obj = JSON.parse(data);
					if(obj.invalidID == 1) {
						let message = document.createElement("div");
						message.className = 'alert alert-danger';
						message.innerHTML = '<strong>Aviso!</strong> Não existe nenhuma conta com esse ID.';
						document.getElementById('alert-space').appendChild(message);

						setTimeout(function() {
							document.getElementById('alert-space').removeChild(message);
						}, 1200)
					} else {
						document.getElementById('amount-account').innerHTML = obj.newAmount;

						let message = document.createElement("div");
						message.className = 'alert alert-success';
						message.innerHTML = 'Ryo transferido!';
						document.getElementById('alert-space').appendChild(message);

						setTimeout(function() {
							document.getElementById('alert-space').removeChild(message);
						}, 1200)
					} 
				}
			})
		}	
	}	
}
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
			Ryo: <span id='playerGold'>".$player->getGold()."</span> <br>
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
		Banco <br>
		<hr style='border: 1px solid black'> <br><br>
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td colspan='3' style='border: 1px solid black'> ID da conta: <?php echo $bank['account_id']; ?></td>
			</tr>	
			<tr>
				<td colspan='3' style='border: 1px solid black'> Ryo em conta: <span id='amount-account'><?php echo $bank['amount']; ?></span> </td>
			</tr>
			<tr>
				<td> <input onClick='depositTable()' type='button' value='Depositar' class='btn btn-success'> </td>
				<td> <input onClick='withdrawTable()' type='button' value='Sacar' class='btn btn-warning'> </td>
				<td> <input onClick='transferTable()' type='button' value='Transferir ryo' class='btn btn-primary'> </td>
			</tr>			
		</table>
		<br>
		<div style='text-align: center' id='space'></div>
		<br>
		<div style='text-align: center' id='alert-space'></div>
	</div>
</div>

<div class='footer col-12'>
	Todos os direitos reservados.
</div>
</body>
</html>