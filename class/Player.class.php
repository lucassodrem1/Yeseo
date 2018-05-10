<?php
class Player {
	public function __construct($playerID) {
		$sql = "SELECT * FROM `users` WHERE `id`='".$playerID."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$floor = new Floor();
		$equip = new Equip();
		$this->id = $row['id'];
		$this->username = $row['username'];
		$this->password = $row['password'];
		$this->gold = $row['gold'];
		$this->class = $row['class'];
		$this->classLVL = $row['class_level'];
		$this->actualFloor = $row['actual_floor'];
		$this->actualFloorName = $floor->getFloorName($row['actual_floor']);
		$this->maxFloor = $row['max_floor'];
		$this->maxFloorName = $floor->getFloorName($row['max_floor']);
		$this->equips = (object) array (
			"capacete" => $row['capacete'],
			"armadura" => $row['armadura'],
			"luvas" => $row['luvas'],
			"botas" => $row['botas'],
			"arma1" => $row['arma1'],
			"arma2" => $row['arma2'],
			"capa" => $row['capa'],
			"colar" => $row['colar']
		);
		$this->equipsName = (object) array (
			"capacete" => $equip->getPlayerEquipName($row['capacete']),
			"armadura" => $equip->getPlayerEquipName($row['armadura']),
			"luvas" => $equip->getPlayerEquipName($row['luvas']),
			"botas" => $equip->getPlayerEquipName($row['botas']),
			"arma1" => $equip->getPlayerEquipName($row['arma1']),
			"arma2" => $equip->getPlayerEquipName($row['arma2']),
			"capa" => $equip->getPlayerEquipName($row['capa']),
			"colar" => $equip->getPlayerEquipName($row['colar'])
		);
		$capaceteStats = $equip->getPlayerEquipStats($row['capacete']);
		$armaduraStats = $equip->getPlayerEquipStats($row['armadura']);
		$luvasStats = $equip->getPlayerEquipStats($row['luvas']);
		$botasStats = $equip->getPlayerEquipStats($row['botas']);
		$arma1Stats = $equip->getPlayerEquipStats($row['arma1']);
		$arma2Stats = $equip->getPlayerEquipStats($row['arma2']);
		$capaStats = $equip->getPlayerEquipStats($row['capa']);
		$colarStats = $equip->getPlayerEquipStats($row['colar']);
		$this->stats = (object) array (
			"HP" => $row['hp'],
			"MP" => $row['mp'] + floor(($row['intelligence'] + $capaceteStats->intelligence + $armaduraStats->intelligence + $luvasStats->intelligence + $botasStats->intelligence + $arma1Stats->intelligence + $arma2Stats->intelligence + 
					$capaStats->intelligence + $colarStats->intelligence) / 2),
			"strength" => $row['strength'] + $capaceteStats->strength + $armaduraStats->strength + $luvasStats->strength + $botasStats->strength + $arma1Stats->strength + $arma2Stats->strength + $capaStats->strength + $colarStats->strength,
			"intelligence" => $row['intelligence'] + $capaceteStats->intelligence + $armaduraStats->intelligence + $luvasStats->intelligence + $botasStats->intelligence + $arma1Stats->intelligence + $arma2Stats->intelligence + 
							  $capaStats->intelligence + $colarStats->intelligence,
			"agility" => $row['agility'] + $capaceteStats->agility + $armaduraStats->agility + $luvasStats->agility + $botasStats->agility + $arma1Stats->agility + $arma2Stats->agility + $capaStats->agility + $colarStats->agility,
			"dexterity" => $row['dexterity'] + $capaceteStats->dexterity + $armaduraStats->dexterity + $luvasStats->dexterity + $botasStats->dexterity + $arma1Stats->dexterity + $arma2Stats->dexterity + 
						   $capaStats->dexterity + $colarStats->dexterity,
			"criticalChance" => round((($row['dexterity'] + $capaceteStats->dexterity + $armaduraStats->dexterity + $luvasStats->dexterity + $botasStats->dexterity + $arma1Stats->dexterity + $arma2Stats->dexterity + 
						   $capaStats->dexterity + $colarStats->dexterity) / 3), 0),
			"lucky" => $row['lucky'] + $capaceteStats->lucky + $armaduraStats->lucky + $luvasStats->lucky + $botasStats->lucky + $arma1Stats->lucky + $arma2Stats->lucky + $capaStats->lucky + $colarStats->lucky,
		);
		$this->pet = $row['pet'];
		$this->statsPoints = $row['stats_points'];
	}

	public function getID() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->getPassword;
	}

	public function getGold() {
		return $this->gold;
	}

	public function getClass() {
		return $this->class;
	}

	public function getRankClass() {
		return $this->classLVL;
	}

	public function getActualFloor() {
		return $this->actualFloor;
	}

	public function getMaxFloor() {
		return $this->maxFloor;
	}

	public function getStats() {
		return $this->stats;
	}

	public function getPet() {
		return $this->pet;
	}

	public function getStatsPoints() {
		return $this->statsPoints;
	}

	public function getEquips() {
		return $this->equips;
	}
	public function getEquipsName() {
		return $this->equipsName;
	}

	public function enterLobby() {
		//Criando lobby id.
		$lobbyID = rand();
		$sql = "SELECT * FROM `lobby` WHERE `lobby_id`='".$lobbyID."'";
		$query = query($sql);
		while(mysql_num_rows($query) != 0) {
			$lobbyID = rand();
			$sql = "SELECT * FROM `lobby` WHERE `lobby_id`='".$lobbyID."'";
			$query = query($sql);
		}

		$sql = "INSERT INTO `lobby` (`lobby_id`, `leader_id`, `player_id`) VALUES ('".$lobbyID."', '".$this->id."', '".$this->id."')";
		query($sql);
	}
	
	public function inLobby() {
		$sql = "SELECT * FROM `lobby` WHERE `player_id`='".$this->id."'";
		$query = query($sql);
		if(mysql_num_rows($query)) {
			die('
				<script>
					location.href="lobby.php";
				</script>	
			');
		}
	}
	
	public function enterArena(Enemy $enemy) {
		//Identificando se o Inimigo é BOSS ou NORMAL.
		$mob_type;
		if($enemy->getID() <= 100) {
			$mob_type = 'Boss';
		} else {
			$mob_type='Normal';
		}

		$sql = "SELECT `lobby_id` FROM `lobby` WHERE `player_id`='".$this->id."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$sql2 = "SELECT * FROM `lobby` WHERE `lobby_id`='".$row['lobby_id']."'";
		$query2 = query($sql2);
		while($row2 = mysql_fetch_assoc($query2)) {
			$sql3 = "SELECT * FROM `users` WHERE `id`='".$row2['player_id']."'";
			$query3 = query($sql3);
			$users = mysql_fetch_assoc($query3);
			$player = new Player($users['id']);
			$enemyStats = $enemy->getStats();
			$sql = "INSERT INTO `player_enemies` (`battle_id`, `player_id`, `enemy_id`, `player_current_mp`, `player_current_strength`, `player_current_intelligence`, `player_current_agility`,
					`player_current_dexterity`, `enemy_current_time`, `enemy_current_hp`, `enemy_current_physical_defense`, `enemy_current_magic_defense`, `enemy_current_agility`, `mob_type`)
					VALUES ('".$row2['lobby_id']."', '".$row2['player_id']."', '".$enemy->getID()."', '".$users['mp']."', '".$player->stats->strength."', '".$users['intelligence']."', '".$users['agility']."',
					'".$users['dexterity']."',	'".$enemy->getTime()."', '".$enemyStats->HP."', '".$enemyStats->pDEF."', '".$enemyStats->mDEF."', '".$enemyStats->agility."', '".$mob_type."')";
			query($sql);
		}
	}
	
	public function inBattle() {
		$sql = "SELECT `player_id`, `enemy_id` FROM `player_enemies` WHERE `player_id`='".$this->id."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		if(mysql_num_rows($query) != 0) {
			die('Você está em batalha. Volte para a arena.');
		}
	}
	
	public function playerDie() {
		$sql = "DELETE FROM `users` WHERE `id`='".$this->id."'";
		query($sql);
		
		//graveyard users.
		$sql = "INSERT INTO `graveyard` (`username`, `actual_floor`, `max_floor`) VALUES ('".$this->getUsername()."', '".$this->getActualFloor()."', '".$this->getMaxFloor()."')";
		query($sql);

		setcookie ("info", "", time() - 3600);
		session_destroy();
	}
	
	public function enemyDie(Enemy $enemy) {
		//Pegando número de players na batalha.
		$sql = "SELECT `battle_id` FROM `player_enemies` WHERE `player_id`='".$this->id."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$row['battle_id']."'";
		$query2 = query($sql2);
		$amountPlayers = 0;
		while($row2 = mysql_fetch_assoc($query2)) {
			$amountPlayers++;
		}

		//Dividindo a recompensa pelo número de jogadores.
		$enemyRewards = $enemy->getRewards();
		$goldPerPlayer = $enemyRewards->gold / $amountPlayers;
		
		//Dando gold pro player
		$this->gold += $goldPerPlayer;

		$sql = "UPDATE `users` SET `gold`='".$this->gold."' WHERE `id`='".$this->id."'";
		query($sql);

		//Subindo de andar.
		$this->actualFloor += 1;
		$this->maxFloor += 1;

		$sql = "UPDATE `users` SET `actual_floor`='".$this->actualFloor."' WHERE `id`='".$this->id."'";
		query($sql);

		$sql = "UPDATE `users` SET `max_floor`='".$this->maxFloor."' WHERE `id`='".$this->id."'";
		query($sql);
		
		//Dando pontos para distribuir.
		$this->statsPoints += 3;
		$sql = "UPDATE `users` SET `stats_points`='".$this->statsPoints."' WHERE `id`='".$this->id."'";
		query($sql);
	}

	public function enemyZoneDie(Enemy $enemy) {
		//Pegando número de players na batalha.
		$sql = "SELECT `battle_id` FROM `player_enemies` WHERE `player_id`='".$this->id."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		$sql2 = "SELECT * FROM `player_enemies` WHERE `battle_id`='".$row['battle_id']."'";
		$query2 = query($sql2);
		$amountPlayers = 0;
		while($row2 = mysql_fetch_assoc($query2)) {
			$amountPlayers++;
		}

		//Dividindo a recompensa pelo número de jogadores.
		$enemyRewards = $enemy->getRewards();
		$goldPerPlayer = $enemyRewards->gold / $amountPlayers;
		
		//Dando gold pro player
		$this->gold += $goldPerPlayer;

		$sql = "UPDATE `users` SET `gold`='".$this->gold."' WHERE `id`='".$this->id."'";
		query($sql);
	}
	
	public function exitBattle() {
		$sql = "DELETE FROM `player_enemies` WHERE `player_id`='".$this->id."'";
		query($sql);
	}

	public function exitLobby() {
		$sql = "DELETE FROM `lobby` WHERE `player_id`='".$this->id."'";
		query($sql);
	}
	
	public function equipping(Equip $equip) {
		$importantEquipID = $equip->getID();
		$sql = "SELECT `amount` FROM `player_equips` WHERE `player_id`='".$this->id."' AND `equip_id`='".$equip->getID()."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);

		//Verificar slot do equip.
		switch($equip->getSlot()) {
			case 'capacete':
				$slot = 'capacete';
				break;
			case 'armadura':
				$slot = 'armadura';
				break;
			case 'luvas':
				$slot = 'luvas';
				break;
			case 'botas':
				$slot = 'botas';
				break;
			case 'arma':
				$slot = 'arma';
				break;
			case 'capa':
				$slot = 'capa';
				break;
			case 'colar':
				$slot = 'colar';
				break;
		}
		
		//Verifica se você está num andar igual ou maior ao do equip.
		if($this->getMaxFloor() >= $equip->getFloorLevel()) {
			if($slot != 'arma') {
				//Verifica se há um equip nesse slot.
				if($this->equips->$slot == 0) {
					//Se o player não tiver equip nesse slot...
					//Equipa
					$sql = "UPDATE `users` SET `".$slot."`='".$equip->getID()."' WHERE `id`='".$this->id."'";
					query($sql);
				} else {
					//Se o player estiver com um equip nesse slot...
					//Tirar o equip atual e colocar no inventário.
					$sql = "SELECT `amount` FROM `player_equips` WHERE `player_id`='".$this->id."' AND `equip_id`='".$this->equips->$slot."'";
					$query = query($sql);
					$playerEquips = mysql_fetch_assoc($query);
					if(mysql_num_rows($query) == 0) {
						//Se o player não tiver esse equip no inventário.
						$sql = "INSERT INTO `player_equips` (`player_id`, `equip_id`, `amount`) VALUES ('".$this->id."', '".$this->equips->$slot."', '1')";
						query($sql);
					} else {
						//Se o player tiver esse equip no inventário.
						if($equip->getID() == $this->equips->$slot) {
							$row['amount'] += 1;
						} else {
							$playerEquips['amount'] += 1;
							$sql = "UPDATE `player_equips` SET `amount`='".$playerEquips['amount']."' WHERE `player_id`='".$this->id."' AND `equip_id`='".$this->equips->$slot."'";
							query($sql);
						}
					}

					//Equipar novo equip.
					$sql = "UPDATE `users` SET `".$slot."`='".$equip->getID()."' WHERE `id`='".$this->id."'";
					query($sql);
				}	
			} else {
				//Equipar slot arma.
				$sql = "SELECT `type_sword` FROM `class WHERE `name`='".$this->getClass()."'";
				if($equip->getHanded() == 2) {
					//Caso a arma seja 2 handed.
					if($this->equips->arma1 == 0 && $this->equips->arma2 == 0) {
						//Se o player tiver espaço;
						$sql = "UPDATE `users` SET `arma1`='".$equip->getID()."' WHERE `id`='".$this->id."'";
						query($sql);
					} else {
						die('
							<script>
								alert("Você não possui espaço suficiente.");
								location.href="bag.php";
							</script>	
						');
					}
				} else {
					//Se a arma for 1 handed. Verificar primeiro se o usuário não está usando 2 handed, depois verificar se há espaço em alguma mão.
					$equip->load($this->equips->arma1);
					if($equip->getHanded() != 2) {
 						$equip->load($this->equips->arma2);
 						if($equip->getHanded() != 2) {
 							if($this->equips->arma1 == 0 || $this->equips->arma2 == 0) {
								if($this->equips->arma1 == 0) {
									$sql = "UPDATE `users` SET `arma1`='".$importantEquipID."' WHERE `id`='".$this->id."'";
									query($sql);
								} else if($this->equips->arma2 == 0) {
									$sql = "UPDATE `users` SET `arma2`='".$importantEquipID."' WHERE `id`='".$this->id."'";
									query($sql);
								}	
							} else {
								die('
									<script>
										alert("Você não possui espaço suficiente.");
										location.href="bag.php";
									</script>	
								');
							}
 						} else {
 							die('
								<script>
									alert("Você não possui espaço suficiente.");
									location.href="bag.php";
								</script>	
							');
 						}
					} else {
						die('
							<script>
								alert("Você não possui espaço suficiente.");
								location.href="bag.php";
							</script>	
						');
					}
				} 
			}
			//Retirar item do inventário do player.
			if($row['amount'] == 1) {
				//Caso só tenha uma quantidade desse equip.
				$sql = "DELETE FROM `player_equips` WHERE `player_id`='".$this->id."' AND `equip_id`='".$importantEquipID."'";
				query($sql);
			} else {
				//Caso tenha mais que uma quantidade do equip.
				$amount = $row['amount'] - 1;
				$sql = "UPDATE `player_equips` SET `amount`='".$amount."' WHERE `player_id`='".$this->id."' AND `equip_id`='".$importantEquipID."'";
				query($sql);
			}
		} else {
			die('
				<script>
					alert("Você precisa subir de andar para usar este equipamento.");
					location.href="bag.php";
				</script>	
			');
		}
	}

	public function unequip(Equip $equip, $slot) {
		$sql = "UPDATE `users` SET `".$slot."`='0' WHERE `id`='".$this->id."'";
		query($sql);

		$sql = "SELECT `amount` FROM `player_equips` WHERE `player_id`='".$this->id."' AND `equip_id`='".$equip->getID()."'";
		$query = query($sql);
		if(mysql_num_rows($query) != 0) {
			//Player tem o equip na bag.
			$row = mysql_fetch_assoc($query);
			$row['amount'] += 1;

			$sql = "UPDATE `player_equips` SET `amount`='".$row['amount']."' WHERE `player_id`='".$this->id."' AND `equip_id`='".$equip->getID()."'";
			query($sql);
		} else {
			//Player não tem o equip na bag.
			$sql = "INSERT INTO `player_equips` (`player_id`, `equip_id`, `amount`) VALUES ('".$this->id."', '".$equip->getID()."', '1')";
			query($sql);
		}
	}

	public function useItem(Item $item, $amount) {
		$sql = "SELECT `item_id`, `amount` FROM `player_items` WHERE `player_id`='".$this->id."' AND `item_id`='".$item->getID()."'";
		$query = query($sql);
		$row = mysql_fetch_assoc($query);
		//Verifica se o player tem mais de 1 quant. desse item.
		if($row['amount'] > 1) {
			$row['amount'] -= $amount;

			$sql = "UPDATE `player_items` SET `amount`='".$row['amount']."' WHERE `player_id`='".$this->id."' AND `item_id`='".$item->getID()."'";
			query($sql);
		} else {
			$sql = "DELETE FROM `player_items` WHERE `player_id`='".$this->id."' AND `item_id`='".$item->getID()."'";
			query($sql);
		}
	}

	public function gainEnemyKnowledge(Enemy $enemy) {
		$sql = "SELECT * FROM `player_enemies_knowledge` WHERE `enemy_id`='".$enemy->getID()."' AND `player_id`='".$this->id."'";
		$query = query($sql);
		if(mysql_num_rows($query) == 0) {
			$sql = "INSERT INTO `player_enemies_knowledge` (`player_id`, `enemy_id`) VALUES ('".$this->id."', '".$enemy->getID()."')";
			query($sql);
		}
	}
	
	public function gainEquipKnowledge(Equip $equip) {
		$sql = "SELECT * FROM `player_equips_knowledge` WHERE `equip_id`='".$equip->getID()."' AND `player_id`='".$this->id."'";
		$query = query($sql);
		if(mysql_num_rows($query) == 0) {
			$sql = "INSERT INTO `player_equips_knowledge` (`player_id`, `equip_id`) VALUES ('".$this->id."', '".$equip->getID()."')";
			query($sql);
		}
	}
	
	public function gainItemKnowledge(Item $item) {
		$sql = "SELECT * FROM `player_items_knowledge` WHERE `item_id`='".$item->getID()."' AND `player_id`='".$this->id."'";
		$query = query($sql);
		if(mysql_num_rows($query) == 0) {
			$sql = "INSERT INTO `player_items_knowledge` (`player_id`, `item_id`) VALUES ('".$this->id."', '".$item->getID()."')";
			query($sql);
		}
	}
	
	public function earnEquip(Equip $equip, $amount) {
		$sql = "SELECT `amount` FROM `player_equips` WHERE `player_id`='".$this->id."' AND `equip_id`='".$equip->getID()."'";
		$query = query($sql);
		if(mysql_num_rows($query) != 0) {
			$row = mysql_fetch_assoc($query);

			$row['amount'] += $amount;

			$sql = "UPDATE `player_equips` SET `amount`='".$row['amount']."' WHERE `player_id`='".$this->id."' AND `equip_id`='".$equip->getID()."'";
			query($sql);
		} else {
			$sql = "INSERT INTO `player_equips` (`player_id`, `equip_id`, `amount`) VALUES ('".$this->id."', '".$equip->getID()."', '".$amount."')";
			query($sql);
		}
	}

	public function earnItem(Item $item, $amount) {
		$sql = "SELECT `amount` FROM `player_items` WHERE `player_id`='".$this->id."' AND `item_id`='".$item->getID()."'";
		$query = query($sql);
		if(mysql_num_rows($query) != 0) {
			$row = mysql_fetch_assoc($query);

			$row['amount'] += $amount;

			$sql = "UPDATE `player_items` SET `amount`='".$row['amount']."' WHERE `player_id`='".$this->id."' AND `item_id`='".$item->getID()."'";
			query($sql);
		} else {
			$sql = "INSERT INTO `player_items` (`player_id`, `item_id`, `amount`) VALUES ('".$this->id."', '".$item->getID()."', '".$amount."')";
			query($sql);
		}
	}

	public function increasingGold($amount) {
		$this->gold += $amount;
		$sql = "UPDATE `users` SET `gold`='".$this->gold."' WHERE `id`='".$this->id."'";
		query($sql);
	}

	public function decreasingGold($amount) {
		$this->gold -= $amount;
		$sql = "UPDATE `users` SET `gold`='".$this->gold."' WHERE `id`='".$this->id."'";
		query($sql);
	}

	public $actualFloorName;
	public $maxFloorName;

	private $id;
	private $username;
	private $password;
	private $gold;
	private $class;
	private $actualFloor;
	private $maxFloor;
	private $stats;
	private $equips;
	private $equipsName;
	private $pet;
	private $statsPoints;
}
?>