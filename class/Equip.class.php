<?php
class Equip {
	public function __construct() {
		$this->equipRarityName = array (
			1 => "Comum",
			2 => "Incomum",
			3 => "Raro",
			4 => "Her&oacute;ico",
			5 => "Celestial",
			6 => "&Eacute;pico",
			7 => "M&iacute;tico"
		);

		$this->equipRarityColor = array (
			1 => "black",
			2 => "#71bd5a",
			3 => "#3c8ff7",
			4 => "#eeba59",
			5 => "#ee3147",
			6 => "#9faca8",
			7 => "#c63930"
		);
	}

	public function load($equipID) {
		$sql = "SELECT * FROM `equips` WHERE `id`='".$equipID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->image = $row['image'];
		$this->floorLevel = $row['floor_level'];
		$this->price = $row['price'];
		$this->rarity = $row['rarity'];
		if($row['rarity'] != 0){
			$this->rarityName = $this->equipRarityName[$row['rarity']];
			$this->rarityColor = $this->equipRarityColor[$row['rarity']];
		}	
		$this->slot = $row['slot'];
		$this->swordType = $row['sword_type'];
		$this->handed = $row['handed'];
		$this->stats = (object) array (
			"strength" => $row['strength'],
			"intelligence" => $row['intelligence'],
			"agility" => $row['agility'],
			"dexterity" => $row['dexterity'],
			"lucky" => $row['lucky']
		);
		$this->desc = $row['desc'];
	}

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}
	
	public function getImage() {
		return $this->image;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getFloorLevel() {
		return $this->floorLevel;
	}

	public function getPlayerEquipName($equipID) {
		$sql = "SELECT `id`, `name` FROM `equips` WHERE `id`='".$equipID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->load($row['id']);
		return '<span style=" color: '.$this->getRarityColor().'">' .  $row['name'] . '</span>';
	} 

	public function getRarityName() {
		return $this->rarityName;
	}
	public function getRarityColor() {
		return $this->rarityColor;
	}

	public function getSlot() {
		return $this->slot;
	}

	public function getSwordType() {
		return $this->swordType;
	}

	public function getHanded() {
		return $this->handed;
	}

	public function getStats() {
		return $this->stats;
	}

	public function getPlayerEquipStats($equipID) {
		$sql = "SELECT * FROM `equips` WHERE `id`='".$equipID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$stats = (object) array (
			"strength" => $row['strength'],
			"intelligence" => $row['intelligence'],
			"agility" => $row['agility'],
			"dexterity" => $row['dexterity'],
			"lucky" => $row['lucky']
		);

		return $stats;
	}

	private $id;
	private $name;
	private $image;
	private $floorLevel;
	private $price;
	private $slot;
	private $rarity;
	private $equipRarityName;
	private $equipRarityColor;
	private $rarityName;
	private	$rarityColor;
	private $type;
	private $swordType;
	private $handed;
	private $stats;
	private $desc;
}
?>