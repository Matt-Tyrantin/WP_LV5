<?php
	namespace Game;

	require_once 'fighter.php';
	require_once 'post_handler.php';

	/**
	*	Class for handling new fighter database entries
	*/
	class NewFighterHandler implements POSTHandler
	{
		private $path;

		public function __construct($path)
		{
			if (substr($path, -1, 1) !== '/') {
				$path .= '/';
			}

			$this->path = $path;
		}

		/**
		*	Handles the POST request by validating it and then inserting it into database.
		*	Returns boolean based on if new fighter has been inserted.
		*/
		public function HandlePOST()
		{
			$name   = $_POST['name'];
			$age    = $_POST['age'];
			$info   = $_POST['info'];
			$wins   = $_POST['wins'];
			$losses = $_POST['losses'];
			$img    = $_FILES['img'];

			if ($name   == null)				     return false;
			if ($age    == null || $age < 0)     return false;
			if ($info   == null)				     return false;
			if ($wins   == null || $wins < 0)    return false;
			if ($losses == null || $losses < 0)  return false;
			if (filesize($img['tmp_name']) == 0) return false;

			$path = $this->path.basename($img['name']);
			if (!move_uploaded_file($img['tmp_name'], $path)) return;

			$fighter = new Fighter(
				$name,
				$age,
				$info,
				null,
				$wins,
				$losses,
				$path
			);

			return $fighter->InsertIntoDB();
		}
	}
?>