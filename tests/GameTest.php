<?php namespace Florin\TicTacToe;

/**
 * Tests the Tic-tac-toe game rules:
 *
 * Tic-tac-toe is played by two players who take turns marking the spaces in a 3×3 grid
 * using X (for player 1) and O (for player 2)
 * The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game.
 *
 * Convention: the grid's positions are identified by numbers from 0 to 8.
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Florin\TicTacToe\Game::__construct
     */
    public function testGameInitialisesWithEmptyGridByDefault()
    {
        $grid = [
            null, null, null,
            null, null, null,
            null, null, null
        ];

        $game = new Game(self::getPlayersPositions($grid));

        $this->assertEquals($grid, self::getGrid($game->getPlayersPositions()));
    }

    /**
     * @covers \Florin\TicTacToe\Game::__construct
     */
    public function testGameInitialisesWithGivenConfiguration()
    {
        $grid = [
            'O' , null, 'O' ,
            null, 'X' , 'X' ,
            null, null, null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertEquals($grid, self::getGrid($game->getPlayersPositions()));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::isInWinningRow
     */
    public function testComputerWinsRowOpportunity()
    {
        $grid = [
            'X' , null, 'X',
            'O' , null, 'O',
            null, 'X' , null
        ];
        $expectedGrid = [
            'X' , null, 'X',
            'O' , 'O' , 'O',
            null, 'X' , null
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::isInWinningColumn
     */
    public function testComputerWinsColumnOpportunity()
    {
        $grid = [
            'X' , null, 'O',
            'X' , 'X' , 'O',
            null, null, null
        ];
        $expectedGrid = [
            'X' , null, 'O',
            'X' , 'X' , 'O',
            null, null, 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::isInWinningFirstDiagonal
     */
    public function testComputerWinsFirstDiagonalOpportunity()
    {
        $grid = [
            'O' , null, 'X',
            'X' , 'O' , 'X',
            null, null, null
        ];
        $expectedGrid = [
            'O' , null, 'X',
            'X' , 'O' , 'X',
            null, null, 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::isInWinningSecondDiagonal
     */
    public function testComputerWinsSecondDiagonalOpportunity()
    {
        $grid = [
            'X' , null, 'O',
            'X' , 'O' , 'X',
            null, null, null
        ];
        $expectedGrid = [
            'X' , null, 'O',
            'X' , 'O' , 'X',
            'O' , null, null
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerBlocksOpponentsWinningRowOpportunity()
    {
        $grid = [
            'X' , null, 'X',
            'O' , null, null,
            null, 'X' , 'O'
        ];
        $expectedGrid = [
            'X' , 'O' , 'X',
            'O' , null, null,
            null, 'X' , 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerBlocksOpponentsWinningColumnOpportunity()
    {
        $grid = [
            'X' , null, null,
            'X' , 'O' , 'X',
            null, null, 'O'
        ];
        $expectedGrid = [
            'X' , null, null,
            'X' , 'O' , 'X',
            'O' , null, 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerBlocksOpponentsWinningFirstDiagonalOpportunity()
    {
        $grid = [
            'X' , null, null,
            'X' , null, 'O',
            'O' , null, 'X'
        ];
        $expectedGrid = [
            'X' , null, null,
            'X' , 'O' , 'O',
            'O' , null, 'X'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerBlocksOpponentsWinningSecondDiagonalOpportunity()
    {
        $grid = [
            null, null, 'X',
            null, null, 'O',
            'X' , 'X' , 'O'
        ];
        $expectedGrid = [
            null, null, 'X',
            null, 'O' , 'O',
            'X' , 'X' , 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::fork
     * @covers \Florin\TicTacToe\Game::availablePositions
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerForks()
    {
        $grid = [
            'O' , 'X' , 'X',
            'X' , null, null,
            null, 'O' , null
        ];
        $expectedGrid = [
            'O' , 'X' , 'X',
            'X' , null, null,
            null, 'O' , 'O'
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::availablePositions
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     */
    public function testComputerBlocksOpponentsFork()
    {
        $grid = [
            'X' , 'O' , 'X',
            null, null, null,
            null, null, null
        ];
        $expectedGrid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            null, null, null
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::availablePositions
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks()
    {
        $grid = [
            'X' , null, null,
            null, 'O' , null,
            null, null, 'X'
        ];
        $expectedGrids = [
            [
                'X' , 'O' , null,
                null, 'O' , null,
                null, null, 'X'
            ],
            [
                'X' , null, null,
                'O' , 'O' , null,
                null, null, 'X'
            ],
            [
                'X' , null, null,
                null, 'O' , 'O' ,
                null, null, 'X'
            ],
            [
                'X' , null, null,
                null, 'O' , null,
                null, 'O' , 'X'
            ]
        ];
        $this->assertTrue(in_array(self::play($grid), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::availablePositions
     * @covers \Florin\TicTacToe\Game::getWinningPositions
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks2()
    {
        $grid = [
            null, null, 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $expectedGrids = [
            [
                null, 'O' , 'X',
                null, 'O' , null,
                'X' , null, null
            ],
            [
                null, null, 'X',
                'O' , 'O' , null,
                'X' , null, null
            ],
            [
                null, null, 'X',
                null, 'O' , 'O' ,
                'X' , null, null
            ],
            [
                null, null, 'X',
                null, 'O' , null,
                'X' , 'O' , null
            ]
        ];
        $this->assertTrue(in_array(self::play($grid), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::center
     * @covers \Florin\TicTacToe\Game::availablePositions
     */
    public function testComputerPlaysTheCenter()
    {
        $grid = [
            'X' , null, null,
            null, null, null,
            null, null, null
        ];
        $expectedGrid = [
            'X' , null, null,
            null, 'O' , null,
            null, null, null
        ];
        $this->assertEquals($expectedGrid, self::play($grid));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::corner
     */
    public function testComputerPlaysACorner()
    {
        $grid = [
            null, null, null,
            'X' , 'O' , 'X',
            null, null, null
        ];
        $expectedGrids = [
            [
                'O' , null, null,
                'X' , 'O' , 'X',
                null, null, null
            ],
            [
                null, null, 'O',
                'X' , 'O' , 'X',
                null, null, null
            ],
            [
                null, null, null,
                'X' , 'O' , 'X',
                null, null, 'O'
            ],
            [
                null, null, null,
                'X' , 'O' , 'X',
                'O' , null, null
            ]
        ];
        $this->assertTrue(in_array(self::play($grid), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::side
     */
    public function testComputerPlaysASide()
    {
        $grid = [
            'X' , 'O' , 'X',
            null, 'X' , null,
            'O' , 'X' , 'O'
        ];
        $expectedGrids = [
            [
                'X' , 'O' , 'X',
                null, 'X' , 'O',
                'O' , 'X' , 'O'
            ],
            [
                'X' , 'O' , 'X',
                'O' , 'X' , null,
                'O' , 'X' , 'O'
            ]
        ];
        $this->assertTrue(in_array(self::play($grid), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testNobodyWon()
    {
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , 'X',
            'O' , null, null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertFalse($game->winner());
    }

    /**
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testPlayer0Won()
    {
        $grid = [
            'X' , 'X' , 'X',
            null, 'O' , null,
            'O' , null, null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertEquals(0, $game->winner());
    }

    /**
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testPlayer1Won()
    {
        $grid = [
            'X' , 'X' , 'O',
            'X' , 'O' , null,
            'O' , null, null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertEquals(1, $game->winner());
    }

    /**
     * @covers \Florin\TicTacToe\Game::isOver
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testGameIsOverBecauseNoMoreAvailableSpace()
    {
        $grid = [
            'X' , 'O' , 'X',
            'O' , 'O' , 'X',
            'X' , 'X' , 'O'
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertTrue($game->isOver());
    }

    /**
     * @covers \Florin\TicTacToe\Game::isOver
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testGameIsOverBecauseWon()
    {
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , 'O' , null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertTrue($game->isOver());
    }

    /**
     * @covers \Florin\TicTacToe\Game::isOver
     * @covers \Florin\TicTacToe\Game::winner
     */
    public function testGameIsNotOver()
    {
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game(self::getPlayersPositions($grid));

        $this->assertFalse($game->isOver());
    }

    /**
     * Plays a turn
     *
     * @param array $grid The initial grid
     *
     * @return array The grid after the turn
     */
    private static function play($grid)
    {
        $game = new Game(self::getPlayersPositions($grid));

        $game->computerPlays();

        return self::getGrid($game->getPlayersPositions());
    }

    /**
     * Gets players' positions from a grid
     *
     * @param array $grid The grid
     *
     * @return array Players' positions
     */
    private static function getPlayersPositions($grid)
    {
        return [array_keys($grid, 'X'), array_keys($grid, 'O')];
    }

    /**
     * Gets the grid give players' positions
     *
     * @param array $playersPositions Players' positions
     *
     * @return array The grid
     */
    private static function getGrid($playersPositions)
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
}
