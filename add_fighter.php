<?php
	require_once './src/new_fighter_handler.php';

	$handler = new \Game\NewFighterHandler('./img');

	if ($handler->HandlePOST()) {
		header('Location: ./index.php');
	} else {
		header('Location: ./add_fighter_form.php');
	}
?>