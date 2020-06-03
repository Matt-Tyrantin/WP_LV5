<?php
	namespace Game;

	require_once 'connection.php';
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
		*	Fetches a fighter with given ID from the database
		*/
		public static function GetFighterByID($id)
		{
			$sql = 'SELECT name, age, info, wins, losses, img FROM fighter_game.fighter_cats WHERE id='.$id.' LIMIT 1';
			$connection = \Database\Connection::GetConnection();
			$result = $connection->query($sql) or die ($connection->error);
			$result = mysqli_fetch_assoc($result);

			return new Fighter(
				$result['name'],
				$result['age'],
				$result['info'],
				$id,
				$result['wins'],
				$result['losses'],
				$result['img']
			);
		}

		/**
		*	Records the fighter into the connected database. Retruns true if fighter has been inserted
		*/
		public function InsertIntoDB()
		{
			$manager = new \Database\TableManager('fighter_game', 'fighter_cats');
			$manager->addColumn('name', $this->name);
			$manager->addColumn('age', $this->age);
			$manager->addColumn('info', $this->info);
			$manager->addColumn('wins', $this->record->GetWins());
			$manager->addColumn('losses', $this->record->GetLosses());
			$manager->addColumn('img', $this->img);

			return $manager->InsertRow();
		}

		/**
		*	Removes the fighter with matching criteria from the connected database. Returns true if 
		*	the fighter has been removed
		*/
		public function RemoveFromDB()
		{
			$manager = new \Database\TableManager('fighter_game', 'fighter_cats');
			$manager->addColumn('id', $this->id);

			return $manager->RemoveRow();
		}

		/**
		*	Updates the fighter's information in the database. Retruns true if update is successful
		*/
		public function UpdateDB()
		{
			$manager = new \Database\TableManager('fighter_game', 'fighter_cats');
			$manager->addColumn('name', $this->name);
			$manager->addColumn('age', $this->age);
			$manager->addColumn('info', $this->info);
			$manager->addColumn('wins', $this->record->GetWins());
			$manager->addColumn('losses', $this->record->GetLosses());
			$manager->addColumn('img', $this->img);

			return $manager->UpdateRow('id', $this->id);
		}

		/**
		*	Adds a single win to the fighter's record in database. Returns true if addition is successful
		*/
		public function AddWin()
		{	
			$manager = new \Database\TableManager('fighter_game', 'fighter_cats');
			$manager->addColumn('wins', $this->record->AddWin());

			return $manager->UpdateRow('id', $this->id);
		}

		/**
		*	Adds a single loss to the figther's record in database. Returns true if addition is successful
		*/
		public function AddLoss()
		{
			$manager = new \Database\TableManager('fighter_game', 'fighter_cats');
			$manager->addColumn('wins', $this->record->AddLoss());

			return $manager->UpdateRow('id', $this->id);
		}
	}

?>
