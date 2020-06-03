<?php
	namespace Game;

	/**
	*	Class for more secure manipulation over fighters' wins and losses
	*/
	class Record 
	{
		private $wins;
		private $losses;

		public function __construct($wins = 0, $losses = 0) 
		{
			$this->wins = $wins;
			$this->losses = $losses;
		}

		/**
		*	Retrusn the number of recorded wins
		*/
		public function GetWins() 
		{
			return $this->wins;
		}

		/**
		*	Retrusn the number of recoreded losses
		*/
		public function GetLosses() 
		{
			return $this->losses;
		}

		/**
		*	Adds one win to the record and immediatly returns it
		*/
		public function AddWin() 
		{
			return ++$this->wins;
		}

		/**
		*	Adds one loss to the record and immediatly returns it
		*/
		public function AddLoss() 
		{
			return ++$this->losses;
		}
	}

?>