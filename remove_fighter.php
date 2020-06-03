<?php
	require_once './src/fighter.php';

	$id = $_GET['id'];
	$fighter = \Game\Fighter::GetFighterByID($id);

	if ($fighter->RemoveFromDB()) {
		header('Location: ./index.php');
	} else {
		die('Error removing a figther');
	}
?>