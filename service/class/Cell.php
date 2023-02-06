<?php

class Cell
{
  private int $x;
  private int $y;
  public bool $marked = false;
  public bool $hasMine;
  public bool $explored = false;
  public array $outerCells = [];
  private int $minesCount;

  public function __construct(int $x, int $y, bool $hasMine = false)
  {
    $this->x = $x;
    $this->y = $y;
    $this->hasMine = $hasMine;
  }

  public function getMinesCount() : int
  {
    if ($this->hasMine) {
      return 0;
    }
    if (!isset($this->minesCount)) {
      $this->minesCount = count(array_filter($this->outerCells, function ($el) {
        return $el->hasMine;
      }));
    }
    return $this->minesCount;
  }

  public function getClosedCells() : array
  {
    return array_filter($this->outerCells, function ($el) {
      return !$el->explored;
    });
  }

  public function reveal() : void
  {
    if ($this->explored) {
      return;
    }
    $this->explored = true;
    if ($this->isBlank()) {
      foreach ($this->outerCells as $cell) {
        $cell->reveal();
      }
    }
  }

  public function isBlank() : bool
  {
    return !$this->hasMine && !$this->getMinesCount();
  }

  public function getX() : int
  {
    return $this->x;
  }

  public function getY() : int
  {
    return $this->y;
  }

  public function isExplored() : bool
  {
    return $this->explored;
  }

  public function getClass() : string
  {
    if ($this->explored) {
      $class = 'explored';
      if ($this->hasMine) {
        $class .= ' mined';
      }
      return $class;
    } elseif ($this->marked) {
      return 'marked';
    }
    return '';
  }
}
