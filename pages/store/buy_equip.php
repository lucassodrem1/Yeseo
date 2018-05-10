<?php
require '../../functions.php';
isLogged();
$id = getID($_COOKIE['info']);
$player = new Player($id);
$player->inBattle();
$equip = new Equip();
$equip->load($_GET['i']);

if($player->getGold() < $equip->getPrice()) {
	die('
		<script>
			alert("Ryo insuficiente!");
			location.href="equip_store.php";
		</script>	
	');
}

if($player->getActualFloor() < $equip->getFloorLevel()) {
	die('
		<script>
			alert("O level desse equipamento é muito alto para você.");
			location.href="equip_store.php";
		</script>	
	');
}

$player->decreasingGold($equip->getPrice());
$player->earnEquip($equip, 1);
echo '
	<script>
		alert("Equipamento comprado com sucesso!");
		location.href="equip_store.php";
	</script>
';
?>