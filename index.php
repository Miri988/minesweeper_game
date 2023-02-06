<?php
require_once('service/class/Game.php');

session_start();
$game = $_SESSION['minesweeper'] ?? null;
$completed = $game ? $game->isCompleted() : false;
$failed = $game ? $game->isFailed() : false;

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style.css">
    <title>Document</title>
  </head>
  <body>
    <div id="main" class="flex">
      <div class="form">
        <?php if ($game && !$completed): ?>
          <div class="field">
            <button class="fluid button" name="resume">Resume</button>
          </div>
          <div class="field">
            <div class="divider">OR</div>
          </div>
        <?php endif; ?>
        <div class="field">
          <label>Difficulty</label>
          <select class="fluid dropdown" name="difficulty">
            <option value="1">10x20</option>
            <option value="2">20x20</option>
            <option value="3">30x20</option>
          </select>
        </div>
        <div class="center aligned field">
          <button class="fluid button" name="start">Start</button>
        </div>
      </div>
    </div>
    <script src="src/app.js"></script>
  </body>
</html>