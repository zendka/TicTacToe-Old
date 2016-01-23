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
     * @param  row the row of the marked space
     * @param  col the column of the market space
     * @return bool true if the mark is valid, false otherwise
     */
    public function playerMarks($row, $col)
    {
        // Check if the mark is inside the grid
        if (!($row >= 0 && $row <= 2 && $col >=0 && $row <=2)) {
            return false;
        }

        // Check the mark is in an empty space
        if (!is_null($this->grid[$row][$col])) {
            return false;
        }

        $this->grid[$row][$col] = 'X';

        return true;
    }
}
