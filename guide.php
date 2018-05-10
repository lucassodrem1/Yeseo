<html>
<head>
<link type="text/css" rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
$(document).ready(() => {
	$('#login-button').click(() => {
		$('body').load('index.php');
	})

	$('#sign-button').click(() => {
		$('body').load('register.php');
	})

	$('#patch-button').click(() => {
		$('body').load('patch.php');
	})
})
</script>
</head>
<body style='background: #44424a;'>
<div class='header col-12' style='background: #44424a; border-bottom: 0'>

</div>

<div class='body col-12' style='background: #44424a; border-bottom: 0px; height: 75%;'>
	<div id='primeiros-passos' style='margin:0 auto;'>
		<ul>	
			<li> 
				Objetivo: Matar o boss de cada andar para chegar ao próximo e assim alcançar o 100º andar. Caso você morra, sua conta será deletada. 
			</li>
			<br>
			<li>
				Stats:
				<ul>  
					<li> STR(strength) Dano físico causado pelo player. </li>
					<li> INT(intelligence) Dano mágico causado e aumento do MP do player. </li> 
					<li> STR(strength) Dano físico causado pelo player. </li>
					<li> AGI(agility) Evita errar ataques durante a batalha. </li>
					<li> DEX(dexterity) Chance de causar acerto crítico. </li>
					<li> LUK(lucky) Aumenta a chance de forja. </li>
				</ul>
			</li>
			<br>
			<li>
				Fórmulas:
				<ul>
					<li> Dano físico causado: STR - defesa física do inimigo. </li>
					<li> Dano mágico: INT - defesa mágica do inimigo. </li>
					<li> Chance do inimigo desviar: AGI do inimigo - AGI do player. </li> 
					<li> Chance de critar: DEX / 3 arendondando para cima ou para baixo. </li>
 				</ul>
			</li>
			<br>
			<li>
				Qual a diferença entre a arena e a zona desprotegida?
				<ul>
					<li>
						Ao ganhar a arena você ganha bônus de stats e pontos para distribui-los, além de subir para o próximo andar. <br>
						Zona desprotegida é uma área para farmar gold, itens e equips.
					</li>	
				</ul> 
			</li>
			<br>
			<li> 
				Como subir de classe? <br>
				<ul>
					<li>
						As informações para subir de classe você encontra dentro do templo.
					</li>
				</ul>						
			</li>
		</ul>	
	</div>
</div>

<div class='footer col-12' style='background: #44424a; border-top: 0; height: 20%'>
	<div id='index-band'>
		Todos os direitos reservados
	</div>
	<div id='index-option1'>
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td>
					<img class='index-images1' src='images/misc/login.png' title='Login' id='login-button'>
				</td>
				<td>
					<img class='index-images1' src='images/misc/sign.png' title='Criar conta' id='sign-button'>
				</td>
				<td>
					<img class='index-images1' src='images/misc/patchNotes.png' title='Patch Notes' style='cursor: pointer' id='patch-button'>
				</td>
			</tr>
		</table>	
	</div>
</div>
</body>
</html>


