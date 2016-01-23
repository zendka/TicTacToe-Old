<?php namespace Florin\TicTacToe;

/**
 * Represents a Tic-tac-toe game:
 *
 * Tic-tac-toe is played by two players who take turns marking the spaces in a 3×3 grid
 * using X (for the 1st player) and O (for the 2nd)
 * The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game.
 *
 * Assumption: the 1st player (using X) is always the human
 *
 * @package    TicTacToe
 */
class Game
{
    /**
     * Stores the current state of the grid
     * @var [string]
     */
    private $grid = [
        [null, null, null],
        [null, null, null],
        [null, null, null]
    ];

    /**
     * Shows the current state of the grid
     *
     * @return [string] the grid
     */
    public function showGrid()
    {
        return $this->grid;
    }

    /**
     * Registers the player's mark
     *
     * @return bool the validity of the mark
     */
    public function playerMarks($position)
    {
        if (empty($this->grid[$position['row']][$position['col']])) {
            $this->grid[$position['row']][$position['col']] = 'X';
            return true;
        } else {
            return false;
        }
    }
}
