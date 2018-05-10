<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'yeseo';

@mysql_connect($host, $user, $pass) or die(mysql_error());
mysql_query("CREATE DATABASE IF NOT EXISTS `".$db."`") or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS `users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(12) NOT NULL,
	`password` VARCHAR(12) NOT NULL,
	`gold` INT NOT NULL DEFAULT '0',
	`class` VARCHAR(50) NOT NULL DEFAULT 'Aprendiz',
	`class_level` INT NOT NULL DEFAULT '0',
	`actual_floor` INT NOT NULL DEFAULT '1',
	`max_floor` INT NOT NULL DEFAULT '1',
	`hp` INT NOT NULL DEFAULT '100',
	`mp` INT NOT NULL DEFAULT '100',
	`strength` INT NOT NULL DEFAULT '1',
	`intelligence` INT NOT NULL DEFAULT '1',
	`agility` INT NOT NULL DEFAULT '1',
	`dexterity` INT NOT NULL DEFAULT '1',
	`lucky` INT NOT NULL DEFAULT '1',
	`current_hp` INT NOT NULL DEFAULT '100',
	`current_lucky` INT NOT NULL DEFAULT '1',
	`capacete` INT NOT NULL DEFAULT '0',
	`armadura` INT NOT NULL DEFAULT '0',
	`luvas` INT NOT NULL DEFAULT '0',
	`botas` INT NOT NULL DEFAULT '0',
	`arma1` INT NOT NULL DEFAULT '0',
	`arma2` INT NOT NULL DEFAULT '0',
	`capa` INT NOT NULL DEFAULT '0',
	`colar` INT NOT NULL DEFAULT '0',
	`pet` INT NOT NULL DEFAULT '0',
	`stats_points` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
) ENGINE = InnoDB") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `class` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20) NOT NULL,
	`image` VARCHAR(20) NOT NULL,
	`class_level` INT NOT NULL DEFAULT '0',
	`str_bonus` INT NOT NULL DEFAULT '0',
	`int_bonus` INT NOT NULL DEFAULT '0',
	`agi_bonus` INT NOT NULL DEFAULT '0',
	`dex_bonus` INT NOT NULL DEFAULT '0',
	`luk_bonus` INT NOT NULL DEFAULT '0',
	`sword_type` VARCHAR(20) NOT NULL,
	`desc` VARCHAR(200) NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `floors` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(35) NOT NULL,
	`bossID` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `equips` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(25) NOT NULL,
	`image` VARCHAR(50) NOT NULL,
	`in_store` INT NOT NULL DEFAULT '0',
	`floor_level` INT NOT NULL DEFAULT '1',
	`price` INT NOT NULL DEFAULT '0',
	`slot` VARCHAR(20) NOT NULL,
	`rarity` INT NOT NULL DEFAULT '1',
	`sword_type` VARCHAR(12) NOT NULL DEFAULT '',
	`handed` INT NOT NULL DEFAULT '1',
	`strength` INT NOT NULL DEFAULT '0',
	`intelligence` INT NOT NULL DEFAULT '0',
	`agility` INT NOT NULL DEFAULT '0',
	`dexterity` INT NOT NULL DEFAULT '0',
	`lucky` INT NOT NULL DEFAULT '0',
	`desc` VARCHAR(200),
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `items` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(25) NOT NULL,
	`image` VARCHAR(50) NOT NULL,
	`price` INT NOT NULL DEFAULT '0',
	`rarity` INT NOT NULL DEFAULT '0',
	`type` INT NOT NULL DEFAULT '0',
	`desc` VARCHAR(200),
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `enemies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20) NOT NULL,
	`boss` INT NOT NULL DEFAULT '0',
	`img` VARCHAR(120) NOT NULL,
	`level` INT NOT NULL DEFAULT '1',
	`time` INT NOT NULL DEFAULT '10',
	`HP` INT NOT NULL DEFAULT '0',
	`physical_defense` INT NOT NULL DEFAULT '0',
	`magic_defense` INT NOT NULL DEFAULT '0',
	`agility` INT NOT NULL DEFAULT '0',
	`gold` INT NOT NULL DEFAULT '0',
	`item` INT NOT NULL DEFAULT '0',
	`equip` INT NOT NULL DEFAULT '0',
	`skill` INT NOT NULL DEFAULT '0',
	`itemDropChance` INT NOT NULL DEFAULT '100',
	`equipDropChance` INT NOT NULL DEFAULT '100',
	`stats_point_amount` INT NOT NULL DEFAULT '0',
	`desc` VARCHAR(200) NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `floor_enemies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`floor_id` INT NOT NULL,
	`enemy_id` INT NOT NULL,
	`chance` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `skills` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20) NOT NULL,
	`image` VARCHAR(50) NOT NULL,
	`min_level` INT NOT NULL DEFAULT '1',
	`class` VARCHAR(20) NOT NULL DEFAULT 'Qualquer',
	`type` VARCHAR(5) NOT NULL DEFAULT 'P',
	`out_arena` INT NOT NULL DEFAULT '0',
	`rarity` INT NOT NULL DEFAULT '1',
	`damage` INT NOT NULL DEFAULT '0',
	`buffer` INT NOT NULL DEFAULT '0',
	`debuffer` INT NOT NULL DEFAULT '0',
	`groupBuff` INT NOT NULL DEFAULT '0',
	`revive` INT NOT NULL DEFAULT '0',
	`strength` INT NOT NULL DEFAULT '0',
	`intelligence` INT NOT NULL DEFAULT '0',
	`agility` INT NOT NULL DEFAULT '0',
	`dexterity` INT NOT NULL DEFAULT '0',
	`lucky` INT NOT NULL DEFAULT '0',
	`MP_cost` INT NOT NULL DEFAULT '0',
	`need_boss` INT NOT NULL DEFAULT '0',
	`desc` VARCHAR(100),
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `graveyard` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(20) NOT NULL,
	`actual_floor` INT NOT NULL,
	`max_floor` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `lobby` (
	`id`  INT NOT NULL AUTO_INCREMENT,
	`lobby_id` INT NOT NULL,
	`leader_id` INT NOT NULL,
	`player_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `bank` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`account_id` INT NOT NULL, 
	`owner` INT NOT NULL,
	`password` VARCHAR(7) NOT NULL,
	`amount` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `pets` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(20) NOT NULL,
	`image` VARCHAR(40) NOT NULL,
	`damage` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `messages` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`sender_id` INT NOT NULL,
	`receiver_id` INT NOT NULL,
	`topic` VARCHAR(32) NOT NULL,
	`message` VARCHAR(250) NOT NULL,
	`type` INT NOT NULL DEFAULT '1',
	`time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', 
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `quests` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`min_floor` INT NOT NULL DEFAULT '1',
	`price` INT NOT NULL DEFAULT '0',
	`gold` INT NOT NULL DEFAULT '0',
	`equip` INT NOT NULL DEFAULT '0',
	`item` INT NOT NULL DEFAULT '0',
	`itemAmount` INT NOT NULL DEFAULT '0',
	`skill` INT NOT NULL DEFAULT '0',
	`pet` INT NOT NULL DEFAULT '0',
	`desc` VARCHAR(220) NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `guilds` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`creator` INT NOT NULL,
	`sub_leader` INT NOT NULL DEFAULT '0',
	`tag` VARCHAR(5) NOT NULL,
	`level` INT NOT NULL DEFAULT '1',
	`level_gold` INT NOT NULL DEFAULT '0',
	`total_gold` INT NOT NULL DEFAULT '0',
	`welcome_message` VARCHAR(240),
	`bank` INT NOT NULL DEFAULT '0',
	`gold_in_bank` INT NOT NULL DEFAULT '0',
	`blacksmith` INT NOT NULL DEFAULT '0',
	`castle` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `guild_players` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`guild_id` INT NOT NULL,
	`player_id` INT NOT NULL,
	`amount_donated` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_enemies_knowledge` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`enemy_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_equips_knowledge` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`equip_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_items_knowledge` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`item_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `quest_items` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`quest_id` INT NOT NULL,
	`item_id` INT NOT NULL,
	`amount` INT NOT NULL DEFAULT '1',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `quest_enemies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`quest_id` INT NOT NULL,
	`enemy_id` INT NOT NULL,
	`amount` INT NOT NULL DEFAULT '1',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_quests` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`quest_id` INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(player_id)
		REFERENCES users(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
) ENGINE = InnoDB") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_enemies_quests` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`quest_id` INT NOT NULL,
	`player_id` INT NOT NULL,
	`enemy_id` INT NOT NULL,
	`amount` INT NOT NULL DEFAULT '0',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `completed_quests` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`quest_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_enemies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`battle_id` INT NOT NULL,
	`player_id` INT NOT NULL,
	`enemy_id` INT NOT NULL,
	`player_current_mp` INT NOT NULL,
	`player_current_strength` INT NOT NULL,
	`player_current_intelligence` INT NOT NULL,
	`player_current_agility` INT NOT NULL,
	`player_current_dexterity` INT NOT NULL,
	`enemy_current_time` INT NOT NULL, 
	`enemy_current_hp` INT NOT NULL,
	`enemy_current_physical_defense` INT NOT NULL,
	`enemy_current_magic_defense` INT NOT NULL,
	`enemy_current_agility` INT NOT NULL,
	`player_died` INT NOT NULL DEFAULT '0',
	`enemy_died` INT NOT NULL DEFAULT '0',
	`equip_caught` INT NOT NULL DEFAULT '0',
	`item_caught` INT NOT NULL DEFAULT '0',
	`mob_type` VARCHAR(20) NOT NULL, 
	PRIMARY KEY(id)
)") or die(mysql_error());


mysql_query("CREATE TABLE IF NOT EXISTS `player_equips` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`equip_id` INT NOT NULL,
	`amount` INT NOT NULL DEFAULT '1',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_items` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`item_id` INT NOT NULL,
	`amount` INT NOT NULL DEFAULT '1',
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_skills` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`skill_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());

mysql_query("CREATE TABLE IF NOT EXISTS `player_friends` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`player_id` INT NOT NULL,
	`friend_id` INT NOT NULL,
	PRIMARY KEY(id)
)") or die(mysql_error());
?>