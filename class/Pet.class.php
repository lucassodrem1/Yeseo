<?php
class Pet {
	public function __construct($petID) {
		$sql = "SELECT * FROM `pets` WHERE `id`='".$petID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->image = $row['image'];
		$this->damage = $row['damage'];
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

	public function getDamage() {
		return $this->damage;
	}

	private $id;
	private $name;
	private $image;
	private $damage;
}
?>