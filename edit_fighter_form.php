<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadatak 1</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
</head>
<body>
    <?php
        require_once './src/fighter.php';

        $fighterID = $_GET['id'];
        $fighter = \Game\Fighter::GetFighterByID($fighterID);
    ?>
    <section class="container d-flex flex-column  align-items-center mb-4">
        <h1>CFC 3</h1>
        <h2>Edit your fighter</h2>
        <button id="generateFight" class="btn btn-secondary mb-4 btn-lg"><a href="./index.php" style="color:white">Go back</a></button>
    </section>
    <div class="row">
        <div id="firstSide" class="container d-flex flex-column  align-items-center side first-side col-5">
            <div class="row d-flex justify-content-end">
                <form action="<?php echo "./edit_fighter.php?id=".$fighter->id ?>" method="POST" enctype="multipart/form-data">
                    <label for="name" class="col-3">Name: </label>
                    <input id="name" name="name" type="text" class="col-8" value="<?php echo $fighter->name ?>"><br>

                    <label for="age" class="col-3">Age: </label>
                    <input id="age" name="age" type="number" class="col-8" value="<?php echo $fighter->age ?>"><br>

                    <label for="info" class="col-3">Cat info: </label>
                    <input id="info" name="info" type="text" class="col-8" value="<?php echo $fighter->info ?>"><br>

                    <label for="wins" class="col-3">Wins: </label>
                    <input id="wins" name="wins" type="number" class="col-2" value="<?php echo $fighter->record->GetWins() ?>" disabled>
                    <label for="losses" class="col-3">Losses: </label>
                    <input id="losses" name="losses" type="number" class="col-2" value="<?php echo $fighter->record->GetLosses() ?>" disabled><br>   

                    <label for="img" class="col-3">Cat Image: </label>
                    <input id="img" name="img" type="file" class="col-8"><br><br>

                    <input type="submit" class="btn btn-primary mb-4 btn-lg col-11" value="Edit fighter">
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="secondSide" class="container d-flex flex-column  align-items-center side first-side col-5">
            <form action="<?php echo "./remove_fighter.php?id=".$fighter->id ?>" type="POST">
                <input type="hidden" name="id" id="id" value="<?php echo $fighter->id ?>">
                <input type="submit" class="btn btn-warning mb-4 btn-lg col-11" value="Delete fighter">
            </form>
        </div>
    </div>
</body>
</html>
