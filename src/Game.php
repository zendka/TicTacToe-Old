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

    /**
     * Calculates computer's best position and marks it on the grid
     */
    public function computerMarks()
    {
        if ($this->win()) {
            return;
        } elseif ($this->block()) {
            return;
        }
    }

    /**
     * Checks if there's a winning position and marks it
     *
     * That is: check if there is a row with two Os and an empty space
     *
     * @todo Build a Grid class that implements getPositionsContaining($value, $context = 'row', $no = 0)
     *
     * @return bool True if a winning position was found and marked, false otherwise
     */
    private function win()
    {
        // Check rows
        for ($i=0; $i<3; $i++) {
            $numberOf0s = 0;
            $numberOfEmptySpaces = 0;
            for ($j=0; $j<3; $j++) {
                if ($this->grid[$i][$j] == 'O') {
                    $numberOf0s++;
                } elseif (empty($this->grid[$i][$j])) {
                    $numberOfEmptySpaces++;
                    $emptySpaceRow = $i;
                    $emptySpaceCol = $j;
                }
            }
            if ($numberOf0s == 2 && $numberOfEmptySpaces == 1) {
                // That's a win
                $this->grid[$emptySpaceRow][$emptySpaceCol] = 'O';
                return true;
            }
        }

        // Check columns
        for ($j=0; $j<3; $j++) {
            $numberOf0s = 0;
            $numberOfEmptySpaces = 0;
            for ($i=0; $i<3; $i++) {
                if ($this->grid[$i][$j] == 'O') {
                    $numberOf0s++;
                } elseif (empty($this->grid[$i][$j])) {
                    $numberOfEmptySpaces++;
                    $emptySpaceRow = $i;
                    $emptySpaceCol = $j;
                }
            }
            if ($numberOf0s == 2 && $numberOfEmptySpaces == 1) {
                // That's a win
                $this->grid[$emptySpaceRow][$emptySpaceCol] = 'O';
                return true;
            }
        }

        // Check first diagonal
        $numberOf0s = 0;
        $numberOfEmptySpaces = 0;
        for ($i=0; $i<3; $i++) {
            if ($this->grid[$i][$i] == 'O') {
                $numberOf0s++;
            } elseif (empty($this->grid[$i][$i])) {
                $numberOfEmptySpaces++;
                $emptySpaceRow = $i;
                $emptySpaceCol = $i;
            }
        }
        if ($numberOf0s == 2 && $numberOfEmptySpaces == 1) {
            // That's a win
            $this->grid[$emptySpaceRow][$emptySpaceCol] = 'O';
            return true;
        }

        // Check second diagonal
        $numberOf0s = 0;
        $numberOfEmptySpaces = 0;
        for ($i=0; $i<3; $i++) {
            if ($this->grid[$i][2-$i] == 'O') {
                $numberOf0s++;
            } elseif (empty($this->grid[$i][2-$i])) {
                $numberOfEmptySpaces++;
                $emptySpaceRow = $i;
                $emptySpaceCol = 2-$i;
            }
        }
        if ($numberOf0s == 2 && $numberOfEmptySpaces == 1) {
            // That's a win
            $this->grid[$emptySpaceRow][$emptySpaceCol] = 'O';
            return true;
        }

        return false;
    }

    /**
     * Checks if there's a winning position for the opponent and blocks it
     *
     * That is: check if there is a row with two Xs and an empty space
     *
     * @todo Build a Grid class that implements getPositionsContaining($value, $context = 'row', $no = 0)
     *
     * @return bool True if a winning position was found and blocked, false otherwise
     */
    private function block()
    {
        // Check rows
        for ($i=0; $i<3; $i++) {
            $numberOfXs = 0;
            $numberOfEmptySpaces = 0;
            for ($j=0; $j<3; $j++) {
                if ($this->grid[$i][$j] == 'X') {
                    $numberOfXs++;
                } elseif (empty($this->grid[$i][$j])) {
                    $numberOfEmptySpaces++;
                    $emptySpaceRow = $i;
                    $emptySpaceCol = $j;
                }
            }
            if ($numberOfXs == 2 && $numberOfEmptySpaces == 1) {
                // That's a win
                $this->grid[$emptySpaceRow][$emptySpaceCol] = 'O';
                return true;
            }
        }
    }
}
