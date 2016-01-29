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
        $game = new Game();

        $this->assertEquals([[], []], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::__construct
     */
    public function testGameInitialisesWithGivenConfiguration()
    {
        $playersPositions = [[4, 5], [0, 2]];
        $game = new Game($playersPositions);

        $this->assertEquals($playersPositions, $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsRowOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, 'X',
            'O' , null, 'O',
            null, 'X' , null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, 'X',
            'O' , 'O' , 'O',
            null, 'X' , null
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsColumnOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, 'O',
            'X' , 'X' , 'O',
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, 'O',
            'X' , 'X' , 'O',
            null, null, 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsFirstDiagonalOpportunity()
    {
        // Just for visualisation
        $grid = [
            'O' , null, 'X',
            'X' , 'O' , 'X',
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'O' , null, 'X',
            'X' , 'O' , 'X',
            null, null, 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsSecondDiagonalOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, 'O',
            'X' , 'O' , 'X',
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, 'O',
            'X' , 'O' , 'X',
            'O' , null, null
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningRowOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, 'X',
            'O' , null, null,
            null, 'X' , 'O'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , 'O' , 'X',
            'O' , null, null,
            null, 'X' , 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningColumnOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, null,
            'X' , 'O' , 'X',
            null, null, 'O'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, null,
            'X' , 'O' , 'X',
            'O' , null, 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningFirstDiagonalOpportunity()
    {
        // Just for visualisation
        $grid = [
            'X' , null, null,
            'X' , null, 'O',
            'O' , null, 'X'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, null,
            'X' , 'O' , 'O',
            'O' , null, 'X'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningSecondDiagonalOpportunity()
    {
        // Just for visualisation
        $grid = [
            null, null, 'X',
            null, null, 'O',
            'X' , 'X' , 'O'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            null, null, 'X',
            null, 'O' , 'O',
            'X' , 'X' , 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::fork
     */
    public function testComputerForks()
    {
        // Just for visualisation
        $grid = [
            'O' , 'X' , 'X',
            'X' , null, null,
            null, 'O' , null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'O' , 'X' , 'X',
            'X' , null, null,
            null, 'O' , 'O'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     */
    public function testComputerBlocksOpponentsFork()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, null, null,
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            null, null, null
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks()
    {
        // Just for visualisation
        $grid = [
            'X' , null, null,
            null, 'O' , null,
            null, null, 'X'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , 'O' , null,
            null, 'O' , null,
            null, null, 'X'
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks2()
    {
        // Just for visualisation
        $grid = [
            null, null, 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            null, 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::center
     */
    public function testComputerPlaysTheCenter()
    {
        // Just for visualisation
        $grid = [
            'X' , null, null,
            null, null, null,
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            'X' , null, null,
            null, 'O' , null,
            null, null, null
        ];
        $this->assertEquals([array_keys($expectedGrid, 'X'), array_keys($expectedGrid, 'O')], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::corner
     */
    public function testComputerPlaysACorner()
    {
        // Just for visualisation
        $grid = [
            null, null, null,
            'X' , 'O' , 'X',
            null, null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
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
        $expectedPositions = [
            [[3, 5], [0, 4]],
            [[3, 5], [2, 4]],
            [[3, 5], [4, 6]],
            [[3, 5], [4, 8]]
        ];
        $this->assertTrue(in_array($game->getPlayersPositions(), $expectedPositions));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::side
     */
    public function testComputerPlaysASide()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, 'X' , null,
            'O' , 'X' , 'O'
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrids = [];
        $expectedGrids[] = [
            'X' , 'O' , 'X',
            null, 'X' , 'O',
            'O' , 'X' , 'O'
        ];
        $expectedGrids[] = [
            'X' , 'O' , 'X',
            'O' , 'X' , null,
            'O' , 'X' , 'O'
        ];
        $this->assertTrue(in_array($game->getPlayersPositions(), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::computerWon
     */
    public function testComputerWins()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        $this->assertTrue($game->computerWon());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::computerWon
     */
    public function testComputerHasntWon()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $this->assertFalse($game->computerWon());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::isOver
     */
    public function testGameIsOver()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $game->computerPlays();

        $this->assertTrue($game->isOver());
    }

    /**
     * @covers \Florin\TicTacToe\Game::isOver
     */
    public function testGameIsNotOver()
    {
        // Just for visualisation
        $grid = [
            'X' , 'O' , 'X',
            null, 'O' , null,
            'X' , null, null
        ];
        $game = new Game([array_keys($grid, 'X'), array_keys($grid, 'O')]);

        $this->assertFalse($game->isOver());
    }
}
