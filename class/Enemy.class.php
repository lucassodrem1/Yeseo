<?php
class Enemy {
	public function __construct($enemyID) {
		$sql = "SELECT * FROM `enemies` WHERE `id`='".$enemyID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->boss = $row['boss'];
		$this->image = $row['img'];
		$this->level = $row['level'];
		$this->time = $row['time'];
		$this->stats = (object) array (
			"HP" => $row['HP'],
			"pDEF" => $row['physical_defense'],
			"mDEF" => $row['magic_defense'],
			"agility" => $row['agility']
		);
		$this->rewards = (object) array (
			"gold" => $row['gold'],
			"item" => $row['item'],
			"equip" => $row['equip'],
			"skill" => $row['skill']
		);
		$this->dropChance = (object) array (
			"item" => $row['itemDropChance'],
			"equip" => $row['equipDropChance']
		);
		$this->desc;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getBoss() {
		return $this->boss;
	}
	
	public function getLevel() {
		return $this->level;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function getImage() {
		return $this->image;
	}
	
	public function getStats() {
		return $this->stats;
	}
	
	public function getRewards() {
		return $this->rewards;
	}

	public function getDropChance() {
		return $this->dropChance;
	}
	
	private $id;
	private $name;
	private $boss;
	private $img;
	private $level;
	private $time;
	private $stats;
	private $rewards;
	private $dropChance;
	private $desc;
}
?>
