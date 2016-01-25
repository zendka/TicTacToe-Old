<?php
/*
 * This file handles the HTTP requests:
 * - processes input
 * - plays the game round
 * - initialises the variables to be used in the template file
 */

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;

/**
 * Cleans up input grid
 *
 * @param  array $inputGrid The input grid
 * @return array $grid      The cleaned grid
 */
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

// Process input
$firstPlayer = isset($_GET['first']) ? $_GET['first'] : null;
$cleanedGrid = isset($_GET['grid']) ? getGridFromInput($_GET['grid']) : null;

// Play round
$game = new Game($cleanedGrid);
$newGame = is_null($cleanedGrid) ? true : false;
if (!$newGame || ($newGame && $firstPlayer == 'computer')) {
    $game->computerMarks();
}

// Initialise variables to unse in template
$grid = $game->getGrid();
$gameOver = $game->isOver();
if ($gameOver) {
    $message = $game->computerWon() ? "Game over. Computer Won." : "Game over. It's a draw.";
}
