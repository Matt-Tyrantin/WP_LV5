<?php
	namespace Game;

	class Record 
	{
		private $wins;
		private $losses;

		public function __construct($wins = 0, $losses = 0) 
		{
			$this->wins = $wins;
			$this->losses = $losses;
		}

		public function GetWins() 
		{
			return $this->wins;
		}

		public function GetLosses() 
		{
			return $this->losses;
		}

		public function AddWin() 
		{
			++$this->wins;
		}

		public function AddLoss() 
		{
			++$this->losses;
		}
	}

?>