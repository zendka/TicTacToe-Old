<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;

const HUMAN_VS_COMPUTER = 1;
const HUMAN_VS_HUMAN = 2;
const COMPUTER_VS_COMPUTER = 3;

/**
 * Processes user input
 *
 * @return array
 */
function processInput()
{
    $input['playersPositions'] = isset($_GET['grid']) && is_array($_GET['grid']) ?
                                 [array_keys($_GET['grid'], 'X'), array_keys($_GET['grid'], 'O')] :
                                 [[], []];

    $input['gameType'] = isset($_GET['gameType']) &&
                         in_array($_GET['gameType'], [HUMAN_VS_COMPUTER, HUMAN_VS_HUMAN, COMPUTER_VS_COMPUTER]) ?
                         $_GET['gameType'] :
                         HUMAN_VS_COMPUTER;

    $input['humanStarts'] = isset($_GET['humanStarts']) && $_GET['humanStarts'] ? true : false;

    return $input;
}

/**
 * Plays round based on the gien input
 *
 * @return Game The game after the round has been played
 */
function playRound($playersPositions, $gameType, $humanStarts)
{
    $game = new Game($playersPositions);

    if ($gameType == COMPUTER_VS_COMPUTER) {
        $game->computerPlays();
    } elseif ($gameType == HUMAN_VS_COMPUTER) {
        $newGame = empty($playersPositions[0]) && empty($playersPositions[1]) ? true : false;

        if (!($newGame && $humanStarts)) {
            $game->computerPlays();
        }
    }

    return $game;
}

/**
 * Marks players positions on a grid
 *
 * @return array The grid
 */
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

/**
 * Generates data to be used in the template file
 *
 * @return array
 */
function getTemplateData($input, $game)
{
    if ($game->isOver()) {
        if ($game->winner() === false) {
            $message = "Game over. It's a draw.";
        } else {
            $winner = $game->winner() == 0 ? 'X' : 'O';
            $message = "Game over. The winner is " . $winner;
        }
    } else {
        $message = '';
    }

    $playersPositions = $game->getPlayersPositions();

    return [
        'gameOver' => $game->isOver(),
        'message' => $message,
        'grid' => getGrid($playersPositions),
        'currentPlayer' => count($playersPositions[0]) > count($playersPositions[1]) ? 'O' : 'X',
        'gameType' => $input['gameType']
    ];
}

$input = processInput();
$game = playRound($input['playersPositions'], $input['gameType'], $input['humanStarts']);
$data = getTemplateData($input, $game);
