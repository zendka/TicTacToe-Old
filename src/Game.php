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
     * @var array $grid The the current state of the grid
     */
    private $grid = [
        [null, null, null],
        [null, null, null],
        [null, null, null]
    ];

    /**
     * Constructor
     *
     * @param array $grid The 3x3 starting grid containing 'X', 'O' and null
     */
    public function __construct($grid = null)
    {
        if ($grid) {
            $this->grid = $grid;
        }
    }

    /**
     * Returns the grid
     *
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Registers the player's mark in the grid
     *
     * @param  int  $row The row of the marked space
     * @param  int  $col The column of the market space
     * @return bool      True if the mark is valid, false otherwise
     */
    public function playerMarks($row, $col)
    {
        // Check if the mark is inside the grid
        if (!($row >= 0 && $row < 3 && $col >=0 && $row <3)) {
            return false;
        }

        // Check if the mark is in an empty space
        if (!empty($this->grid[$row][$col])) {
            return false;
        }

        $this->grid[$row][$col] = 'X';

        return true;
    }
}
