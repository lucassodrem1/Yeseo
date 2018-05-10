<?php
class Skill {
	public function __construct() {
		$this->skillRarityName = array (
			1 => "Comum",
			2 => "Incomum",
			3 => "Raro",
			4 => "Her&oacute;ico",
			5 => "Celestial",
			6 => "&Eacute;pico",
			7 => "M&iacute;tico"
		);

		$this->skillRarityColor = array (
			1 => "black",
			2 => "#71bd5a",
			3 => "#3c8ff7",
			4 => "#eeba59",
			5 => "#ee3147",
			6 => "#9faca8",
			7 => "#c63930"
		);
	}

	public function load($skillID) {
		$sql = "SELECT * FROM `skills` WHERE `id`='".$skillID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->class = $row['class'];
		$this->type = $row['type'];
		$this->outArena = $row['out_arena'];
		$this->rarity = $row['rarity'];
		if($row['rarity'] != 0){
			$this->rarityName = $this->skillRarityName[$row['rarity']];
			$this->rarityColor = $this->skillRarityColor[$row['rarity']];
		}
		$this->MPcost = $row['MP_cost'];
		$this->damage = $row['damage'];
		$this->buffer = $row['buffer'];
		$this->groupBuff = $row['groupBuff'];
		$this->stats = (object) array (
			"strength" => $row['strength'],
			"intelligence" => $row['intelligence'],
			"agility" => $row['agility'],
			"dexterity" => $row['dexterity'],
			"lucky" => $row['lucky']
		);
		$this->needBoss = $row['need_boss'];
		$this->desc = $row['desc'];
	}

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getClass() {
		return $this->class;
	}

	public function getType() {
		return $this->type;
	}

	public function getOutArena() {
		return $this->outArena;
	}	

	public function getRarityColor() {
		return $this->rarityColor;
	}

	public function getColorSkillName() {
		return '<span style=" color: '.$this->getRarityColor().'">' .  $this->name . '</span>';
	} 

	public function getMPcost() {
		return $this->MPcost;
	}

	public function getDamage() {
		return $this->damage;
	}

	public function getBuffer() {
		return $this->buffer;
	}

	public function getgroupBuff() {
		return $this->groupBuff;
	}

	public function getStats() {
		return $this->stats;
	}

	public function getNeedBoss() {
		return $this->needBoss;
	}

	public function getDesc() {
		return $this->desc;
	}

	private $id;
	private $name;
	private $class;
	private $type;
	private $outArena;
	private $rarity;
	private $rarityName;
	private $rarityColor;
	private $MPcost;
	private $damage;
	private $buffer;
	private $groupBuff;
	private $stats;
	private $needBoss;
	private $desc;
}
?>