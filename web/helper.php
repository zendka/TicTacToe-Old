<?php
require_once dirname(__DIR__) . '/src/autoload.php';

function getGridFromInput($inputGrid)
{
    for ($i=0; $i<3; $i++) {
        for ($j=0; $j<3; $j++) {
            if (isset($inputGrid[$i][$j]) && in_array($inputGrid[$i][$j], array('X', 'O'))) {
                $grid[$i][$j] = $inputGrid[$i][$j];
            } else {
                $grid[$i][$j] = null;
            }
        }
    }

    return $grid;
}

$gameOver = false;

if (isset($_GET['grid'])) {
    // Continue game
    $currentGrid = getGridFromInput($_GET['grid']);
    $game = new Florin\TicTacToe\Game($currentGrid);
    $game->computerMarks();

    if ($game->isOver()) {
        $gameOver = true;

        if ($game->computerWon()) {
            $message = "Game over. Computer Won.";
        } else {
            $message = "Game over. It's a draw.";
        }
    }
} else {
    // Start new game
    $game = new Florin\TicTacToe\Game();
}

$grid = $game->getGrid();
