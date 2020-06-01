<?php
	namespace Game;

	require_once 'table_manager.php';
	require_once 'record.php';

	class Fighter 
	{
		public $id;
		public $name;
		public $age;
		public $info;
		public $record;
		public $img;

		public function __construct($name, $age, $info, $id = null, $wins = 0, $losses = 0, $img = null) 
		{	
			$this->id = $id;
			$this->name = $name;
			$this->age = $age;
			$this->info = $info;
			$this->record = new Record($wins, $losses);
			$this->img = $img;
		}

		/**
		*	Records the fighter into the connected database
		*/
		private function InsertIntoDB()
		{
			$manager = new \Database\TableManager('fighter_cats');
			$manager->addColumn('name', $this->name);
			$manager->addColumn('age', $this->age);
			$manager->addColumn('info', $this->info);
			$manager->addColumn('wins', $this->record->GetWins());
			$manager->addColumn('losses', $this->record->GetLosses());
			$manager->addColumn('img', $this->img);
			$manager->insertColumn();
		}
	}

?>
