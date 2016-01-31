<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;

/**
 * Processes user input
 *
 * @return array Array with two keys: firstPlayer - and integer representing the first player
 *               and playersPositions - an array representing the players positions
 */
function processInput()
{
    $firstPlayer = isset($_GET['firstPlayer']) && in_array($_GET['firstPlayer'], ['human', 'computer']) ? $_GET['firstPlayer'] : null;
    $playersPositions = isset($_GET['grid']) && is_array($_GET['grid']) ?
                        [array_keys($_GET['grid'], 'X'), array_keys($_GET['grid'], 'O')] :
                        [[], []];
    return [
        'firstPlayer' => $firstPlayer,
        'playersPositions' => $playersPositions
    ];
}

/**
 * Plays round based on a given configuration
 *
 * @param  int   $firstPlayer      Which player to go first if
 * @param  array $playersPositions [description]
 *
 * @return Game The game after the round has been played
 */
function playRound($firstPlayer, $playersPositions)
{
    $game = new Game($playersPositions);

    if (!($firstPlayer == 'human')) {
        $game->computerPlays();
    }

    return $game;
}

function getGrid($playersPositions)
{
    $grid = [
        null, null, null,
        null, null, null,
        null, null, null
    ];

    foreach ($playersPositions[0] as $position) {
        $grid[$position] = 'X';
    }
    foreach ($playersPositions[1] as $position) {
        $grid[$position] = 'O';
    }

    return $grid;
}

function getGameData($game)
{
    if ($game->isOver()) {
        if ($game->winner() === false) {
            $message = "Game over. It's a draw.";
        } else {
            $message = "Game over. The winner is " . $game->winner();
        }
    } else {
        $message = '';
    }

    $playersPositions = $game->getPlayersPositions();

    return [
        'gameOver' => $game->isOver(),
        'message' => $message,
        'grid' => getGrid($playersPositions),
        'currentPlayer' => count($playersPositions[0]) > count($playersPositions[1]) ? 'O' : 'X'
    ];
}

$input = processInput();
$game = playRound($input['firstPlayer'], $input['playersPositions']);
$data = getGameData($game);
