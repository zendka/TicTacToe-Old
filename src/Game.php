<?php namespace Florin\TicTacToe;

/**
 * Represents a Tic-tac-toe game:
 *
 * Tic-tac-toe is played by two players who take turns marking the spaces in a 3×3 grid
 * using X (for player 1) and O (for player 2)
 * The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game.
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
    const DIAGONAL1 = [0,4,8];
    /** The grid's second diagonal positions */
    const DIAGONAL2 = [2,4,6];

    /** @var array Players' positions. E.g. [[1, 3, 4], [2, 6, 7]] */
    private $playersPositions = [[], []];

    const HUMAN_VS_COMPUTER    = 0;
    const HUMAN_VS_HUMAN       = 1;
    const COMPUTER_VS_COMPUTER = 2;
    /** @var int Game type: 0 for human vs computer, 1 for human vs human and 2 for computer vs computer */
    private $gameType = self::HUMAN_VS_COMPUTER;

    /**
     * @var bool $winner The winning player
     */
    private $winner = null;

    /**
     * Constructor
     *
     * @param array $playersPositions Players' positions. E.g. [[1, 3, 4], [2, 6, 7]]
     * @param int   $gameType         Game type: 0 for human vs computer, 1 for human vs human and 2 for computer vs computer
     */
    public function __construct($playersPositions = [[], []], $gameType = self::HUMAN_VS_COMPUTER)
    {
        if (!self::validGameType($gameType) || !self::validPlayersPositions($playersPositions)) {
            throw new \InvalidArgumentException('Game::__construct was called with invalid arguments.');
        }

        $this->gameType = $gameType;
        $this->playersPositions = $playersPositions;
    }

    /**
     * Checks if the given parameter represents valid players positions
     *
     * @param array $playersPositions Players positions
     *
     * @return bool
     */
    private static function validPlayersPositions($playersPositions)
    {
        if (!isset($playersPositions[0]) || !isset($playersPositions[1])) {
            return false;
        } elseif (array_intersect($playersPositions[0], $playersPositions[1])) {
            // Players positions overlap
            return false;
        } elseif (array_diff($playersPositions[0] + $playersPositions[1], self::GRID)) {
            // Players positions are outside the grid
            return false;
        } else {
            return true;
        }
    }

    /**
     * Checks if game type is valid
     *
     * @param int $gameType The game type
     *
     * @return bool
     */
    private static function validGameType($gameType)
    {
        if (in_array($gameType, [self::HUMAN_VS_COMPUTER, self::HUMAN_VS_HUMAN, self::COMPUTER_VS_COMPUTER])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if player is valid
     *
     * @param int $player Player
     *
     * @return bool
     */
    private static function validPlayer($player)
    {
        if (in_array($player, [0, 1])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns players positions
     *
     * @return array Players' positions. E.g. [[1, 3, 4], [2, 6, 7]]
     */
    public function getPlayersPositions()
    {
        return $this->playersPositions;
    }

    /**
     * Returns the winner
     *
     * @return int Returns 0 if the first player won and 1 if the second player won
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Returns the winner
     *
     * @return int Returns 0 if it's the first player's turn and 1 if it's the second player's turn
     */
    private function getPlayerForThisTurn()
    {
        return count($this->playersPositions[0]) > count($this->playersPositions[1]) ? 1 : 0;
    }

    /**
     * Computer playes its turn
     */
    public function computerPlays()
    {
        $player = $this->getPlayerForThisTurn();

        if ($this->win($player)) {
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
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function win($player)
    {
        if ($winningPositions = $this->getWinningPositions($player)) {
            $this->playersPositions[$player][] = $winningPositions[array_rand($winningPositions)];
            sort($this->playersPositions[$player]);
            $this->winner = $player;
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
     * Checks if there's a fork opportunity for the opponent and avoids it
     *
     * @return bool Returns true if a position was found and blocked
     */
    private function blockFork()
    {
        $forkPositions = [];

        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    // Simulate an opponent's mark at this position
                    $this->grid[$i][$j] = 'X';

                    $leadsToFork = sizeof($this->getWinningPositions('X')) > 1;
                    if ($leadsToFork) {
                        $forkPositions[] = array('row' => $i, 'col' => $j);
                    }

                    // Remove the mark
                    $this->grid[$i][$j] = null;
                }
            }
        }

        if (sizeof($forkPositions) == 1) {
            // Block fork
            $this->grid[$forkPositions[0]['row']][$forkPositions[0]['col']] = 'O';
            return true;
        } elseif (sizeof($forkPositions) > 1) {
            $this->forceOpponent($forkPositions);
            return true;
        }

        // No forks
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
     * @param int $player Which player to play as: 0 or 1
     *
     * @return [int]
     */
    private function getWinningPositions($player)
    {
        $winningPositions = [];

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            if (count(array_intersect($this->playersPositions[$player], $this->positionsOnSameRow($position))) == 2) {
                $winningPositions[] = $position;
                continue;
            }
            if (count(array_intersect($this->playersPositions[$player], $this->positionsOnSameColumn($position))) == 2) {
                $winningPositions[] = $position;
                continue;
            }
            if (in_array($position, self::DIAGONAL1) && count(array_intersect($this->playersPositions[$player], self::DIAGONAL1)) == 2) {
                $winningPositions[] = $position;
                continue;
            }
            if (in_array($position, self::DIAGONAL2) && count(array_intersect($this->playersPositions[$player], self::DIAGONAL2)) == 2) {
                $winningPositions[] = $position;
                continue;
            }
        }

        return $winningPositions;
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
     * Returns the positions on the same row as the give position
     *
     * @param int $position A position
     *
     * @return [int]
     */
    private function positionsOnSameRow($position)
    {
        $firstPositionInRow = $position - ($position%3);

        return [$firstPositionInRow, $firstPositionInRow+1, $firstPositionInRow+2];
    }

    /**
     * Returns the positions on the same column as the give position
     *
     * @param int $position A position
     *
     * @return [int]
     */
    private function positionsOnSameColumn($position)
    {
        return [$position, ($position+3) % 9, ($position+6) % 9];
    }

    /**
     * Force opponent to mark outside specific positions
     *
     * Do this by creating two in a row - a future winning position that the oponent has to counter
     *
     * @param  array Array with the specific positions.
     *               E.g. [['row' => 0, 'col' => 2], ['row' => 1, 'col' => 1]]
     */
    private function forceOpponent($excludedPositions)
    {
        for ($i=0; $i<3; $i++) {
            for ($j=0; $j<3; $j++) {
                if (empty($this->grid[$i][$j])) {
                    // Simulate a mark
                    $this->grid[$i][$j] = 'O';

                    // Check if there are winning position and if they are outside the excluded positions
                    if ($winningPositions = $this->getWinningPositions('O')) {
                        $areExcluded = false;
                        foreach ($winningPositions as $winningPosition) {
                            foreach ($excludedPositions as $excludedPosition) {
                                if ($winningPosition == $excludedPosition) {
                                    $areExcluded = true;
                                }
                            }
                        }
                        if (!$areExcluded) {
                            return;
                        }
                    }

                    // Remove mark
                    $this->grid[$i][$j] = null;
                }
            }
        }
    }
}
