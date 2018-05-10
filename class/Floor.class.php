<?php
class Floor {
	public function load($floorID) {
		$sql = "SELECT * FROM `floors` WHERE `id`='".$floorID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$this->id = $row['id'];
		$this->name = $row['name'];
		$this->boss = $row['bossID'];
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

	public function getFloorName($floorID) {
		$sql = "SELECT * FROM `floors` WHERE `id`='".$floorID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		return $row['name'];
	}

	private $id;
	private $name;
	private $bossID;
}
?>