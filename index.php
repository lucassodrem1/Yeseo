<html>
<head>
<link type="text/css" rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
$(document).ready(() => {
	$('.footer').animate({height: '20%'}, 1800, () => {
		$('#index-band').fadeIn(800, () => {
			$('#index-option1').fadeIn(800);
		});
	});

	$('#sign-button').click(() => {
		$('#index-option1').fadeOut(500, () => {
			$('#index-band').fadeOut(500, () => {
				$('.footer').animate({height: '100%'}, 1200, () => {
					$('body').load('register.php');
				});
			});
		});
	})

	$('#primeiros-passos-button').click(() => {
		$('body').load('guide.php');
	})

	$('#patch-button').click(() => {
		$('body').load('patch.php');
	})
})
</script>
</head>
<body style='background: #44424a;'>
<div class='header col-12' style='border-bottom: 0;'>
</div>

<div class='body col-12' style='background: #44424a; border-bottom: 0px; height: 75%'>
	<br><br><br><br><br><br><br><br><br><br>
	<form method='post' action='login.php'>
	<table id='login-form' style='margin: 0 auto; color: white;'>
		<tr>
			<td> <img src='images/misc/logo.png' id='logo-image'> <br><br> </td>
		</tr>	
		<tr>	
			<td> <input type='text' name='user' maxlength='12' placeholder="Usuário"> </td>
		</tr>
		<tr>
			<td> <input type='password' name='pass' maxlength='12' placeholder="Senha"> </td>
		</tr>	
		<tr>
			<td> 
				<br>
				<input type='image' src='images/misc/login.png' class='index-images'>
			</td>
		</tr>	
	</table>
	</form>

	<form method='post' action='sign.php'>
	<table id='sign-form' style='margin: 0 auto; display: none; color: white;'>
		<tr>
			<td> <input type='text' name='username' maxlength='12' placeholder="Usuário"> </td>
		</tr>
		<tr>
			<td> <input type='password' name='password' maxlength='12' placeholder="Senha"> </td>
		</tr>
		<tr>
			<td> <input type='password' name='re_password' maxlength='12' placeholder="Repetir Senha"> </td>
		</tr>
		<tr>
			<td> 
				<input type='image' src='images/misc/login.png' class='index-images'> 
			</td>
		</tr>	
	</table>	
	</form>
</div>

<div class='footer col-12' style='border-top: 0; height: 100%'>
	<div id='index-band' style='display: none'>
		Todos os direitos reservados
	</div>
	<div id='index-option1' style='display: none'>
		<table border='0' style='margin: 0 auto'>
			<tr>
				<td>
					<img class='index-images1' src='images/misc/sign.png' title='Criar conta' id='sign-button'>
				</td>
				<td>
					<img class='index-images1' src='images/misc/guide.png' title='Primeiros Passos' style='cursor: pointer' id='primeiros-passos-button'>
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


