<?php
	namespace Game;

	require_once 'fighter.php';
	require_once 'post_handler.php';

	/**
	*	Class for handling fighter editing in database
	*/
	class EditFighterHandler implements POSTHandler
	{
		private $id;
		private $path;

		public function __construct($id, $path)
		{
			if (substr($path, -1, 1) !== '/') {
				$path .= '/';
			}

			$this->id = $id;
			$this->path = $path;
		}

		/**
		*	Handles the POST request by validating it and then inserting it into database.
		*	Returns boolean based on if new fighter has been inserted.
		*/
		public function HandlePOST()
		{
			$fighter = Fighter::GetFighterById($this->id);

			$name   = $_POST['name'];
			$age    = $_POST['age'];
			$info   = $_POST['info'];
			//$wins   = $_POST['wins'];
			//$losses = $_POST['losses'];
			$img    = $_FILES['img'];

			if ($name != null) {
				$fighter->name = $name;
			}

			if ($age != null && $age >= 0) {
				$fighter->age = $age;
			}

			if ($info != null) {
				$fighter->info = $info;
			}

			if (filesize($img['tmp_name']) != 0) {
				$path = $this->path.basename($img['name']);
				if (!move_uploaded_file($img['tmp_name'], $path)) return;
			}

			return $fighter->UpdateDB();
		}
	}
?>