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
     * Constructor
     *
     * @param [string] the 3x3 starging grid containing 'X', '0' and null
     */
    public function __construct($grid = null)
    {
        if ($grid) {
            $this->grid = $grid;
        }
    }

    /**
     * Shows the current state of the grid
     *
     * @return [string] the grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Registers the player's mark
     *
     * @param  array the position to mark
     * @return bool the validity of the mark
     */
    public function playerMarks($position)
    {
        if (!($position['row'] >= 0 && $position['row'] <= 2 && $position['col'] >=0 && $position['row'] <=2)) {
            return false;
        }
        if (empty($this->grid[$position['row']][$position['col']])) {
            $this->grid[$position['row']][$position['col']] = 'X';
            return true;
        } else {
            return false;
        }
    }
}
