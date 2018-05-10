<?php
class Item {
	public function __construct() {
		$this->itemRarityName = array (
			1 => "Comum",
			2 => "Incomum",
			3 => "Raro",
			4 => "Her&oacute;ico",
			5 => "Celestial",
			6 => "&Eacute;pico",
			7 => "M&iacute;tico"
		);

		$this->itemRarityColor = array (
			1 => "black",
			2 => "#71bd5a",
			3 => "#3c8ff7",
			4 => "#eeba59",
			5 => "#ee3147",
			6 => "#9faca8",
			7 => "#c63930"
		);

		$this->itemType = array (
			1 => "Não usável",
			2 => "Usável"
		);
	}

	public function load($itemID) {
		$sql = "SELECT * FROM `items` WHERE `id`='".$itemID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->image = $row['image'];
		$this->price = $row['price'];
		$this->type = $row['type'];
		if($row['type'] != 0) {
			$this->itemType = $this->itemType[$row['type']];
		}
		$this->rarity = $row['rarity'];
		if($row['rarity'] != 0){
			$this->rarityName = $this->itemRarityName[$row['rarity']];
			$this->rarityColor = $this->itemRarityColor[$row['rarity']];
		}	
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

	public function getPlayerItemName($itemID) {
		$sql = "SELECT `id`, `name` FROM `items` WHERE `id`='".$itemID."'";
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

	public function getPrice() {
		return $this->price;
	}

	public function getType() {
		return $this->itemType;
	}

	public function getDesc() {
		return $this->desc;
	}

	private $id;
	private $name;
	private $image;
	private $price;
	private $rarity;
	private $itemType;
	private $itemRarityName;
	private $itemRarityColor;
	private $rarityName;
	private	$rarityColor;
	private $type;
	private $desc;
}
?>