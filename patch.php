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

	$('#primeiros-passos-button').click(() => {
		$('body').load('guide.php');
	})
})
</script>
</head>
<body style='background: #44424a;'>
<div class='header col-12' style='background: #44424a; border-bottom: 0'>

</div>

<div class='body col-12' style='background: #44424a; border-bottom: 0px; height: 75%;'>
	<div id='primeiros-passos' style='margin:0 auto;'>
		//Corpo
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
					<img class='index-images1' src='images/misc/guide.png' title='Primeiros Passos' style='cursor: pointer' id='primeiros-passos-button'>
				</td>
			</tr>
		</table>	
	</div>
</div>
</body>
</html>


