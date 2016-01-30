<?php namespace Florin\TicTacToe;

/**
 * Represents a Tic-tac-toe game:
 *
 * Tic-tac-toe is played by two players who take turns marking the spaces in a 3×3 grid
 * using X (for player 1) and O (for player 2)
 * The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game.
 *
 * In order to play perfectly the Game::computerPlays method implements Newell and Simon's algorithm
 * as described at https://en.wikipedia.org/wiki/Tic-tac-toe
 *
 * Convention: the grid's positions are identified by numbers from 0 to 8. See self::GRID
 *
 * @package TicTacToe
 */
class Game
{
    /** The grid's positions */
    const GRID = [
        0, 1, 2,
        3, 4, 5,
        6, 7, 8
    ];
    /** The grid's corner positions */
    const CORNERS   = [0, 2, 6, 8];
    /** The grid's side positions */
    const SIDES     = [1, 3, 5, 7];
    /** The grid's first diagonal positions */
    const DIAGONAL1 = [0, 4, 8];
    /** The grid's second diagonal positions */
    const DIAGONAL2 = [2, 4, 6];
    /** The grid's central position */
    const CENTER    = 4;

    /** @var array Players' positions. E.g. [[1, 3, 4], [2, 6, 7]] */
    private $playersPositions = [[], []];

    /** @var int The player for this turn: 0 or 1 */
    private $player = null;

    /** @var int The player's opponent for this turn: 0 or 1 */
    private $opponent = null;

    /** @var bool $winner The winning player */
    private $winner = null;

    /**
     * Constructor
     *
     * @param array $playersPositions Players' positions. E.g. [[1, 3, 4], [2, 6, 7]]
     */
    public function __construct($playersPositions = [[], []])
    {
        if (!self::validPlayersPositions($playersPositions)) {
            throw new \InvalidArgumentException('Game::__construct was called with invalid arguments.');
        }

        $this->playersPositions = $playersPositions;
        $this->player           = count($this->playersPositions[0]) > count($this->playersPositions[1]) ? 1 : 0;
        $this->opponent         = 1 - $this->player;
    }

    /**
     * Checks if the given players' positions are valid
     *
     * @param array $playersPositions Players' positions. E.g. [[1, 3, 4], [2, 6, 7]]
     *
     * @return bool
     */
    private static function validPlayersPositions($playersPositions)
    {
        if (!isset($playersPositions[0]) || !isset($playersPositions[1])) {
            return false;
        } elseif (array_intersect($playersPositions[0], $playersPositions[1])) {
            // Players' positions overlap
            return false;
        } elseif (array_diff(array_merge($playersPositions[0], $playersPositions[1]), self::GRID)) {
            // Players' positions are outside the grid
            return false;
        } elseif (count($playersPositions[0]) < count($playersPositions[1])) {
            // First player has fewer positions than the second player. Not possible as it went first
            return false;
        } elseif (count($playersPositions[0]) > count($playersPositions[1]) + 1) {
            // First player has way to many positions
            return false;
        } else {
            return true;
        }
    }

    /**
     * Gets players' positions
     *
     * @return array Players' positions. E.g. [[1, 3, 4], [2, 6, 7]]
     */
    public function getPlayersPositions()
    {
        return $this->playersPositions;
    }

    /**
     * Gets the winner
     *
     * @return int Returns 0 if the first player won and 1 if the second player won
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Computer plays
     */
    public function computerPlays()
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
     * Checks if the game is over
     *
     * @return bool
     */
    public function isOver()
    {
        if ($this->computerWon) {
            return true;
        }

        // Check if there's any empty space left to play
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if there's a winning position and plays it
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function win()
    {
        if ($winningPositions = $this->getWinningPositions($this->player)) {
            array_push($this->playersPositions[$this->player], $winningPositions[array_rand($winningPositions)]);
            $this->winner = $this->player;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if there's a winning position for the opponent and blocks it
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function blockWin()
    {
        if ($opponentsWinningPositions = $this->getWinningPositions($this->opponent)) {
            array_push($this->playersPositions[$this->player], $opponentsWinningPositions[array_rand($opponentsWinningPositions)]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if there's a fork opportunity and plays it
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function fork()
    {
        if ($forkPositions = $this->forkPositions($this->player)) {
            array_push($this->playersPositions[$this->player], $forkPositions[array_rand($forkPositions)]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if there's a fork opportunity for the opponent and avoids it
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function blockFork()
    {
        if ($forkPositions = $this->forkPositions($this->opponent)) {
            if (sizeof($forkPositions) == 1) {
                // Block fork
                array_push($this->playersPositions[$this->player], $forkPositions[0]);
                return true;
            } elseif (sizeof($forkPositions) > 1) {
                return $this->forceOpponent($forkPositions);
            }
        } else {
            return false;
        }
    }

    /**
     * Marks the center if available
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function center()
    {
        if (in_array(self::CENTER, $this->availablePositions())) {
            array_push($this->playersPositions[$this->player], self::CENTER);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Marks a corner if available
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function corner()
    {
        if ($availableCorners = array_intersect(self::CORNERS, $this->availablePositions())) {
            array_push($this->playersPositions[$this->player], $availableCorners[array_rand($availableCorners)]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Marks a side if available
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function side()
    {
        if ($availableSides = array_intersect(self::SIDES, $this->availablePositions())) {
            array_push($this->playersPositions[$this->player], $availableSides[array_rand($availableSides)]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the winning positions for a given player
     *
     * A winning position is an available position which is in line with two of the player's positions
     *
     * @param int $player The player
     *
     * @return [int]
     */
    private function getWinningPositions($player)
    {
        $winningPositions = [];

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            if ($this->isInWinningRow($position, $player) ||
                $this->isInWinningColumn($position, $player) ||
                $this->isInWinningFirstDiagonal($position, $player) ||
                $this->isInWinningSecondDiagonal($position, $player)) {

                $winningPositions[] = $position;
            }
        }
        return $winningPositions;
    }

    /**
     * Checks if the available position is on the same row with two of the players positions
     *
     * @param  int  $position The available position
     * @param  int  $player   The player
     *
     * @return boolean
     */
    private function isInWinningRow($position, $player)
    {
        return count(array_intersect($this->playersPositions[$player], $this->positionsOnSameRow($position))) == 2;
    }

    /**
     * Checks if the available position is on the same column with two of the players positions
     *
     * @param  int  $position The available position
     * @param  int  $player   The player
     *
     * @return boolean
     */
    private function isInWinningColumn($position, $player)
    {
        return count(array_intersect($this->playersPositions[$player], $this->positionsOnSameColumn($position))) == 2;
    }

    /**
     * Checks if the available position is on the first diagonal together with two of the players positions
     *
     * @param  int  $position The available position
     * @param  int  $player   The player
     *
     * @return boolean
     */
    private function isInWinningFirstDiagonal($position, $player)
    {
        return in_array($position, self::DIAGONAL1) && count(array_intersect($this->playersPositions[$player], self::DIAGONAL1)) == 2;
    }

    /**
     * Checks if the available position is on the second diagonal together with two of the players positions
     *
     * @param  int  $position The available position
     * @param  int  $player   The player
     *
     * @return boolean
     */
    private function isInWinningSecondDiagonal($position, $player)
    {
        return in_array($position, self::DIAGONAL2) && count(array_intersect($this->playersPositions[$player], self::DIAGONAL2)) == 2;
    }

    /**
     * Returns the available positions
     *
     * @return [int]
     */
    private function availablePositions()
    {
        return array_diff(self::GRID, array_merge($this->playersPositions[0], $this->playersPositions[1]));
    }

    /**
     * Returns the positions on the same row as the given position
     *
     * @param int $position Position
     *
     * @return [int]
     */
    private function positionsOnSameRow($position)
    {
        $firstPositionInRow = $position - ($position % 3);

        return [$firstPositionInRow, $firstPositionInRow + 1, $firstPositionInRow + 2];
    }

    /**
     * Returns the positions on the same column as the given position
     *
     * @param int $position Position
     *
     * @return [int]
     */
    private function positionsOnSameColumn($position)
    {
        return [$position, ($position + 3) % 9, ($position + 6) % 9];
    }

    /**
     * Returns the fork positions for a given player
     *
     * @param int $player The player
     *
     * @return [int]
     */
    private function forkPositions($player)
    {
        $forkPositions = [];

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            // Simulate a mark at this position
            array_push($this->playersPositions[$player], $position);

            if (sizeof($this->getWinningPositions($player)) > 1) {
                $forkPositions[] = $position;
            }
            // Remove the mark
            array_pop($this->playersPositions[$player]);
        }

        return $forkPositions;
    }

    /**
     * Force opponent to play outside specific excluded positions
     *
     * Here's how: Create a winning position outside the excluded positions.
     * The opponent will have to play into this position in order not to lose.
     *
     * @param [int] $excludedPositions The excluded positions
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function forceOpponent($excludedPositions)
    {
        $forcedPositions = [];

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            // Simulate a mark at this position
            array_push($this->playersPositions[$this->player], $position);

            // Check if there are winning position and if they are outside the excluded positions
            if ($winningPositions = $this->getWinningPositions($this->player)) {
                if (!array_intersect($winningPositions, $excludedPositions)) {
                    $forcedPositions[] = $position;
                }
            }

            // Remove mark
            array_pop($this->playersPositions[$this->player]);
        }

        if ($forcedPositions) {
            array_push($this->playersPositions[$this->player], $forcedPositions[array_rand($forcedPositions)]);
            return true;
        } else {
            return false;
        }
    }
}
