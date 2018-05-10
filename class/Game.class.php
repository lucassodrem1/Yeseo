<?php
class Game {
	public $messageType;
	public $classImage;
		
	public function __construct() {
		$this->messageType = array (
			1 => "Mensagem",
			2 => "Pedido de amizade",
			3 => "Convite para zona",
			4 => "Convite para ARENA",
			5 => "Convite para guilda"
		);
		
		$this->classImage = array (
			"Aprendiz" => "aprendiz.jpg",
			"Espadachim" => "espadachim.jpg", 
			"Mago" => "mago.jpg", 
			"Arqueiro" => "arqueiro.jpg",
			"Mercador" => "mercador.jpg",
			"Gatuno" => "gatuno.jpg",
			"Noviço" => "novico.jpg"
		);
	}
}
?>