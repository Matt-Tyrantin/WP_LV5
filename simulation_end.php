<?php
	require_once './src/simulation_fighter_handler.php';

	error_log('TELL ME');
	$handler = new \Game\SimulationFighterHandler();
	
	if(!$handler->HandlePOST()) {
		echo 'Something went wrong';
	}
?>
