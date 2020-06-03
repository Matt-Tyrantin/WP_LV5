<?php
namespace Game;

//require_once 'table_manager.php';
require_once 'connection.php';
require_once 'fighter.php';

class FighterManager 
{
	public static function FetchAllFighters()
	{
		$sql = 'SELECT id, name, age, info, wins, losses, img FROM fighter_game.fighter_cats';

		$connection = \Database\Connection::GetConnection();
		$result = $connection->query($sql) or die ($connection->error);
		$fighters = array();

		while ($row = $result->fetch_assoc()) {
			$fighters[] = new Fighter(
				$row['name'], 
				$row['age'], 
				$row['info'], 
				$row['id'],
				$row['wins'],
				$row['losses'],
				$row['img']
			);
		}

		return $fighters;
	}

	public static function CreateFighterHTML($fighter)
	{
		echo 
			'<div class="col-md-4 mb-1">
				<div class="fighter-box"
				data-info = \'{
					"id": '.$fighter->id.',
					"name":"'.$fighter->name.'" ,
					"age" : '.$fighter->age.',
					"catInfo": "'.$fighter->info.'",
					"record" : {
						"wins":  '.$fighter->record->GetWins().',
						"loss": '.$fighter->record->GetLosses().'
					}
				}\'>
					<img src="'.$fighter->img.'" alt="Fighter Box 1" width="150" height="150">
				</div>
			</div>';
	}

	public static function CreateAllFighterHTML()
	{
		$fighters = self::FetchAllFighters();

		foreach ($fighters as $fighter) {
			self::CreateFighterHTML($fighter);
		}
	}
}

?>