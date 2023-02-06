<?php

require_once('class/Game.php');

session_start();

$game = $_SESSION['minesweeper'] ?? null;
$type = $_GET['type'] ?? null;
$params = [
  '1' => [ 'x' => 10, 'y' => 20, 'm' => 20 ],
  '2' => [ 'x' => 20, 'y' => 20 , 'm' => 40],
  '3' => [ 'x' => 30, 'y' => 20, 'm' => 60 ]
];

if ($type === 'start') {
  $difficulty = $_GET['difficulty'] ?? '1';
  $p = $params[$difficulty];
  $game = new Game($p['x'], $p['y'], $p['m']);
  $_SESSION['minesweeper'] = $game;
} elseif (in_array($type, ['mark', 'reveal'])) {
  $x = (int) $_GET['x'];
  $y = (int) $_GET['y'];
  if ($type === 'mark') {
    $game->mark($x, $y);
  } else {
    $game->reveal($x, $y);
  }
}

if (!$game) {
  exit();
}

?>

<div class="game">
  <div class="fitted segments">
    <div class="segment">
      <div class="flex centered">
        <div class="fluid">
          <a href="/" class="button">Back</a>
        </div>
        <span class="flex timer">
          &#8987;<span class="text"></span>
        </span>
      </div>
    </div>
    <div class="segment">
      <table class="table field">
        <?php foreach(range(0, $game->getH() - 1) as $y): ?>
          <tr>
            <?php foreach(range(0, $game->getW() - 1) as $x): ?>
              <td>
                <?php
                  $cell = $game->getCell($x, $y);
                ?>
                <div class="cell <?php echo $cell->getClass(); ?>" x="<?php echo $x; ?>" y="<?php echo $y; ?>" >
                  <?php if ($cell->isExplored() && $cell->getMinesCount()): ?>
                    <span class="ui text"><?php echo $cell->getMinesCount(); ?></span>
                  <?php endif; ?>
                </div>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <?php if ($game->isCompleted()): ?>
      <div class="segment">
        <?php if ($game->isFailed()): ?>
          <div class="negative message">Oops! Sorry, you lost. Try again!</div>
        <?php else: ?>
          <div class="positive message">Hurray! You won!</div>
        <?php endif; ?>
        <?php unset($_SESSION['minesweeper']); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
