<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/javascript" src="jquery.js"></script>
<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
<script>
let array = [];
$(document).keyup(function(e) {
	let key = String.fromCharCode(e.keyCode);
	array.push(key);
	let newArray = array.join(' ');
	document.getElementById('txt').innerHTML = newArray;

	let combo = document.getElementById('combo').innerHTML;
	if(newArray == combo) {
		alert('Deu!!!');
	}
})
</script>
</head>
<body>
Aperte: <div style='display: inline' id='combo'>E R T F</div> <br>
<div id='txt'></div>
</body>
</html>