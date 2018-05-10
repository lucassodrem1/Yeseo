<?php
class Quest {
	public function load($questID) {
		$sql = "SELECT * FROM `quests` WHERE `id`='".$questID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->floor = $row['min_floor'];
		$this->price = $row['price'];
		$this->rewards = (object) array (
			"gold" => $row['gold'],
			"equip" => $row['equip'],
			"item" => $row['item'],
			"itemAmount" => $row['itemAmount'],
			"skill" => $row['skill'],
			"pet" => $row['pet']
		);
		$this->desc = $row['desc'];
	}

	public function getID() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getFloor() {
		return $this->floor;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getRewards() {
		return $this->rewards;
	}

	public function getDesc() {
		return $this->desc;
	}

	public function getRewardsName() {
		$equip = new Equip();
		$equip->load($this->rewards->equip);
		
		$item = new Item();
		$item->load($this->rewards->item);

		$skill = new Skill();
		$skill->load($this->rewards->skill);

		$pet = new Pet($this->rewards->pet);

		$rewardsName = (object) array (
			"equip" => $equip->getName(),
			"item" => $item->getName(),
			"skill" => $skill->getName(),
			"pet" => $pet->getName(),
		);

		return $rewardsName;
	}

	private $id;
	private $name;
	private $floor;
	private $price;
	private $rewards;
	private $desc;
}
?>