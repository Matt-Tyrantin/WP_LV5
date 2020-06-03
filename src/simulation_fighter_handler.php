<?php
	namespace Game;

	require_once 'fighter.php';
	require_once 'post_handler.php';

	/**
	*	Handler for updating victor and loser of the simulation into database.
	*/
	class SimulationFighterHandler implements POSTHandler
	{
		public function HandlePOST()
		{
			$winnerID = $_POST['winner'];
			$loserID  = $_POST['loser'];

			$winner = Fighter::GetFighterById($winnerID);
			$loser  = Fighter::GetFighterById($loserID);

			return $winner->AddWin() && $loser->AddLoss();
		}
	}
?>