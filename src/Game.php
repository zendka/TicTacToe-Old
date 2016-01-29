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
        } elseif ($this->blockWin($player)) {
            return;
        } elseif ($this->fork($player)) {
            return;
        } elseif ($this->blockFork($player)) {
            return;
        } elseif ($this->center($player)) {
            return;
        } elseif ($this->corner($player)) {
            return;
        } elseif ($this->side($player)) {
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
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if successful, false otherwise
     */
    private function blockWin($player)
    {
        $opponent = self::opponent($player);
        if ($opponentsWinningPositions = $this->getWinningPositions($opponent)) {
            $this->playersPositions[$player][] = $opponentsWinningPositions[array_rand($opponentsWinningPositions)];
            sort($this->playersPositions[$player]);
            return true;
        }

        return false;
    }

    /**
     * Checks if there's a fork opportunity and marks it
     *
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if a position was found and marked
     */
    private function fork($player)
    {
        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            // Simulate a mark at this position
            array_push($this->playersPositions[$player], $position);

            if (sizeof($this->getWinningPositions($player)) > 1) {
                // Leave the mark in place
                return true;
            } else {
                // Remove the mark
                array_pop($this->playersPositions[$player]);
            }
        }

        return false;
    }

    /**
     * Checks if there's a fork opportunity for the opponent and avoids it
     *
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if a position was found and blocked
     */
    private function blockFork($player)
    {
        $forkPositions = [];

        $opponent = self::opponent($player);

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            // Simulate a mark at this position
            array_push($this->playersPositions[$opponent], $position);

            if (sizeof($this->getWinningPositions($opponent)) > 1) {
                $forkPositions[] = $position;
            }
            // Remove the mark
            array_pop($this->playersPositions[$opponent]);
        }

        if (sizeof($forkPositions) == 1) {
            // Block fork
            array_push($this->playersPositions[$player], $position);
            return true;
        } elseif (sizeof($forkPositions) > 1) {
            $this->forceOpponent($player, $forkPositions);
            return true;
        } else {
            // No forks
            return false;
        }
    }

    /**
     * Marks the center if available
     *
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if the center has been marked, false otherwise
     */
    private function center($player)
    {
        if (in_array(self::CENTER, $this->availablePositions())) {
            array_push($this->playersPositions[$player], self::CENTER);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Marks a corner if available
     *
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if a corner has been marked, false otherwise
     */
    private function corner($player)
    {
        if ($availableCorners = array_intersect(self::CORNERS, $this->availablePositions())) {
            array_push($this->playersPositions[$player], $availableCorners[array_rand($availableCorners)]);
            sort($this->playersPositions[$player]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Marks a side if available
     *
     * @param int $player Which player to play as: 0 or 1
     *
     * @return bool Returns true if a side has been marked, false otherwise
     */
    private function side($player)
    {
        if ($availableSides = array_intersect(self::SIDES, $this->availablePositions())) {
            array_push($this->playersPositions[$player], $availableSides[array_rand($availableSides)]);
            sort($this->playersPositions[$player]);
            return true;
        } else {
            return false;
        }
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
     * Returns the player's opponent
     *
     * @param int $player The player
     *
     * @return [int] The opponent
     */
    private function opponent($player)
    {
        return 1 - $player;
    }

    /**
     * Force opponent to mark outside specific positions
     *
     * Do this by creating two in a row - a future winning position that the opponent has to counter
     *
     * @param int   $player Which player to play as: 0 or 1
     * @param [int] $excludedPositions The excluded positions
     */
    private function forceOpponent($player, $excludedPositions)
    {
        $opponent = self::opponent($player);

        $availablePositions = $this->availablePositions();
        foreach ($availablePositions as $position) {
            // Simulate a mark at this position
            array_push($this->playersPositions[$player], $position);

            // Check if there are winning position and if they are outside the excluded positions
            if ($winningPositions = $this->getWinningPositions($player)) {
                if (!array_intersect($winningPositions, $excludedPositions)) {
                    sort($this->playersPositions[$player]);
                    return;
                }
            }

            // Remove mark
            array_pop($this->playersPositions[$player]);
        }
    }
}
