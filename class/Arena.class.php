<?php
class Arena {
	public function __construct($playerID) {
		$sql = "SELECT * FROM `player_enemies` WHERE `player_id`='".$playerID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->battleID = $row['battle_id'];
		$this->playerID = $row['player_id'];
		$this->enemyID = $row['enemy_id'];
		$this->playerCurrentStats = (object) array (
			"MP" => $row['player_current_mp'],
			"strength" => $row['player_current_strength'],
			"intelligence" => $row['player_current_intelligence'],
			"agility" => $row['player_current_agility'],
			"dexterity" => $row['player_current_dexterity'],
			"criticalChance" => round(($row['player_current_dexterity'] / 3), 0)
		);
		$this->enemyCurrentTime = $row['enemy_current_time'];
		$this->enemyCurrentStats = (object) array (
			"HP" => $row['enemy_current_hp'],
			"pDEF" => $row['enemy_current_physical_defense'],
			"mDEF" => $row['enemy_current_magic_defense'],
			"agility" => $row['enemy_current_agility']
		);
		$this->playerDied = $row['player_died'];
		$this->enemyDied = $row['enemy_died'];
		$this->equipCaught = $row['equip_caught'];
		$this->itemCaught = $row['item_caught'];
	}

	public function getID() {
		return $this->id;
	}

	public function getBattleID() {
		return $this->battleID;
	}

	public function getPlayerID() {
		return $this->playerID;
	}

	public function getEnemyID() {
		return $this->enemyID;
	}
	
	public function getPlayerCurrentStats() {
		return $this->playerCurrentStats;
	}
	
	public function getEnemyCurrentTime() {
		return $this->enemyCurrentTime;
	}
	
	public function getEnemyCurrentStats() {
		return $this->enemyCurrentStats;
	}
	
	public function getPlayerDied() {
		return $this->playerDied;
	}

	public function getEnemyDied() {
		return $this->enemyDied;
	}

	public function getEquipCaught() {
		return $this->equipCaught;
	}

	public function getItemCaught() {
		return $this->itemCaught;
	}

	private $id;
	private $playerID;
	private $enemyID;
	private $playerCurrentStats;
	private $enemyCurrentTime;
	private $enemyCurrentStats;
	private $playerDied;
	private $enemyDied;
	private $equipCaught;
	private $itemCaught;
}
?>