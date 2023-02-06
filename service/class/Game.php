<?php

require_once('Cell.php');

class Game
{
  private int $w;
  private int $h;
  private bool $generated = false;
  private array $cells = [];
  private int $minesCount;
  private array $minedCells = [];

  public function __construct(int $w = 10, int $h = 10, int $minesCount = 10)
  {
    $this->w = $w;
    $this->h = $h;
    $this->minesCount = $minesCount;
    $this->generateCells();
  }

  private function generateCells() : void
  {
    foreach (range(0, $this->h - 1) as $y) {
      foreach (range(0, $this->w - 1) as $x) {
        $cell = new Cell($x, $y);
        array_push($this->cells, $cell);
      }
    }
    
    // foreach ($this->cells as $cell) {
    //   $cell->outerCells = array_filter($this->cells, function ($el) use ($cell) {
    //     return $el !== $cell && abs($cell->getX() - $el->getX()) <= 1 && abs($cell->getY() - $el->getY()) <= 1;
    //   });
    // }
  }

  private function getOuterCells(Cell $cell) : array
  {
    return array_filter($this->cells, function ($el) use ($cell) {
      return $cell !== $el && abs($cell->getX() - $el->getX()) <= 1 && abs($cell->getY() - $el->getY()) <= 1; 
    });
  }

  private function generateMines($startingCell) : void
  {
    $exclude = [$startingCell, ...$this->getOuterCells($startingCell)];
    $count = 0;
    while ($count < $this->minesCount) {
      $index = random_int(0, $this->w * $this->h - 1);
      $cell = $this->cells[$index];
      if (!in_array($cell, $exclude)) {
        $cell->hasMine = true;
        array_push($exclude, $cell);
        array_push($this->minedCells, $cell);
        $count++;
      }
    }
    $this->generated = true;
  }

  public function reveal(int $x, int $y) : void
  {
    $cell = $this->getCell($x, $y);
    if (!$this->generated) {
      $this->generateMines($cell);
    }
    $this->revealCell($cell);
  }

  public function revealCell(Cell $cell)
  {
    if (!$cell->explored) {
      $outerCells = $this->getOuterCells($cell);
      $cell->outerCells = $outerCells;
      $cell->explored = true;
      if ($cell->isBlank()) {
        foreach ($cell->getClosedCells() as $c) {
          $this->revealCell($c);
        }
      }
    }
  }

  public function mark($x, $y) : void
  {
    $cell = $this->getCell($x, $y);
    if ($cell) {
      $cell->marked = !$cell->marked;
    }
  }

  public function getCell(int $x, int $y) : Cell | null
  {
    return $this->cells[$this->w * $y + $x];
  }

  public function getUnExploredCells() : array
  {
    return array_filter($this->cells, function ($el) {
      return !$el->isExplored();
    });
  }

  public function isFailed() : bool
  {
    foreach ($this->minedCells as $cell) {
      if ($cell->isExplored()) {
        return true;
      }
    }
    return false;
  }

  public function isCompleted() : bool
  {
    return $this->isFailed() || count($this->getUnExploredCells()) === $this->minesCount;
  }

  public function getW() : int
  {
    return $this->w;
  }

  public function getH() : int
  {
    return $this->h;
  }
}
