<?php
	require_once './src/edit_fighter_handler.php';
	
	$id = $_GET['id'];
	$handler = new \Game\EditFighterHandler($id, './img');

	if ($handler->HandlePOST()) {
		header('Location: ./index.php');
	} else {
		header('Location: ./edit_fighter_form.php?id='.$id);
	}
?>