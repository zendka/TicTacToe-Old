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
     * @var bool $computerWon True if the computer won, false otherwise
     */
    private $computerWon = false;

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
     * Checks if the computer won
     *
     * @return array
     */
    public function computerWon()
    {
        return $this->computerWon;
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
     * Calculates computer's best position and marks it
     */
    public function computerMarks()
    {
        if ($this->win()) {
            return;
        } elseif ($this->blockWin()) {
            return;
        } elseif ($this->fork()) {
            return;
        } elseif ($this->blockFork()) {
            return;
        } elseif ($this->center()) {
            return;
        } elseif ($this->corner()) {
            return;
        } elseif ($this->side()) {
            return;
        }
    }

    /**
     * Checks if there's a winning position and marks it
     *
     * @return bool Returns true if a position was found and marked
     */
    private function win()
    {
        if ($computerWinningPositions = $this->getWinningPositions('O')) {
            $this->grid[$computerWinningPositions[0]['row']][$computerWinningPositions[0]['col']] = 'O';
            $this->computerWon = true;
            return true;
        }

        return false;
    }

    /**
     * Checks if there's a winning position for the opponent and blocks it
     *
     * @return bool Returns true if a position was found and blocked
     */
    private function blockWin()
    {
        if ($humanWinningPositions = $this->getWinningPositions('X')) {
            $this->grid[$humanWinningPositions[0]['row']][$humanWinningPositions[0]['col']] = 'O';
            return true;
        }

        return false;
    }

    /**
     * Checks if there's a fork opportunity and marks it
     *
     * @return bool Returns true if a position was found and marked
     */
    private function fork()
    {
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    // Simulate a mark at this position
                    $this->grid[$i][$j] = 'O';
                    $leadsToFork = sizeof($this->getWinningPositions('O')) > 1;
                    if ($leadsToFork) {
                        // Leave the mark in place
                        return true;
                    }

                    // Remove the mark
                    $this->grid[$i][$j] = null;
                }
            }
        }

        return false;
    }

    /**
     * Checks if there's a fork opportunity for the opponent and blocks it
     *
     * @todo Choose the best position if several available
     *
     * @return bool Returns true if a position was found and blocked
     */
    private function blockFork()
    {
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    // Simulate an opponent's mark at this position
                    $this->grid[$i][$j] = 'X';
                    $leadsToFork = sizeof($this->getWinningPositions('X')) > 1;
                    if ($leadsToFork) {
                        // Block it
                        $this->grid[$i][$j] = 'O';
                        return true;
                    }

                    // Remove the mark
                    $this->grid[$i][$j] = null;
                }
            }
        }

        return false;
    }

    /**
     * Marks the center if available
     *
     * @return bool Returns true if the center has been marked, false otherwise
     */
    private function center()
    {
        if (empty($this->grid[1][1])) {
            $this->grid[1][1] = 'O';
            return true;
        }

        return false;
    }

    /**
     * Marks a corner if available
     *
     * @return bool Returns true if a corner has been marked, false otherwise
     */
    private function corner()
    {
        if (empty($this->grid[0][0])) {
            $this->grid[0][0] = 'O';
            return true;
        } elseif (empty($this->grid[0][2])) {
            $this->grid[0][2] = 'O';
            return true;
        } elseif (empty($this->grid[2][0])) {
            $this->grid[2][0] = 'O';
            return true;
        } elseif (empty($this->grid[2][2])) {
            $this->grid[2][2] = 'O';
            return true;
        }

        return false;
    }

    /**
     * Marks a side if available
     *
     * @return bool Returns true if a side has been marked, false otherwise
     */
    private function side()
    {
        if (empty($this->grid[0][1])) {
            $this->grid[0][1] = 'O';
            return true;
        } elseif (empty($this->grid[1][0])) {
            $this->grid[1][0] = 'O';
            return true;
        } elseif (empty($this->grid[1][2])) {
            $this->grid[1][2] = 'O';
            return true;
        } elseif (empty($this->grid[2][1])) {
            $this->grid[2][1] = 'O';
            return true;
        }

        return false;
    }

    /**
     * Returns the winning positions for a given player
     *
     * A winning position is an empty space on a line with two of the player's marks
     *
     * @param  str   $player Which player to check: 'X' or 'O'
     * @return array         Array with the winning positions.
     *                       E.g. [['row' => 0, 'col' => 2], ['row' => 1, 'col' => 1]]
     */
    private function getWinningPositions($player = 'O')
    {
        $winningPositions = [];

        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    $winningRow    = $this->grid[$i][($j+1)%3] == $player && $this->grid[$i][($j+2)%3] == $player;
                    $winningColumn = $this->grid[($i+1)%3][$j] == $player && $this->grid[($i+2)%3][$j] == $player;
                    $winningFirstDiagonal  = $i == $j   && $this->grid[($i+1)%3][($j+1)%3]   == $player && $this->grid[($i+2)%3][($j+2)%3]   == $player;
                    $winningSecondDiagonal = $i == 2-$j && $this->grid[($i+1)%3][2-($i+1)%3] == $player && $this->grid[($i+2)%3][2-($i+2)%3] == $player;
                    if ($winningRow || $winningColumn || $winningFirstDiagonal || $winningSecondDiagonal) {
                        $winningPositions[] = array('row' => $i, 'col' => $j);
                    }
                }
            }
        }

        return $winningPositions;
    }
}
