<?php namespace Florin\TicTacToe;

/**
 * Tests the Tic-tac-toe game rules:
 *
 * Tic-tac-toe is played by two players who take turns marking the spaces in a 3×3 grid
 * using X (for the 1st player) and O (for the 2nd)
 * The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row wins the game.
 *
 * Assumption: the 1st player (using X) is always the human
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
        $winningGrid = [
            ['X' , null, 'X' ],
            ['O' , null, 'O' ],
            [null, 'X' , null]
        ];
        $game = new Game([[0, 2, 7], [3, 5]]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            ['X' , null, 'X' ],
            ['O' , 'O' , 'O' ],
            [null, 'X' , null]
        ];
        $this->assertEquals([[0, 2, 7], [3, 5, 4]], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsColumnOpportunity()
    {
        // Just for visualisation
        $winningGrid = [
            ['X' , null, 'O' ],
            ['X' , 'X' , 'O' ],
            [null, null, null]
        ];
        $game = new Game([[0, 3, 4], [2, 5]]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            ['X' , null, 'O' ],
            ['X' , 'X' , 'O' ],
            [null, null, 'O' ]
        ];
        $this->assertEquals([[0, 3, 4], [2, 5, 8]], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsFirstDiagonalOpportunity()
    {
        // Just for visualisation
        $winningGrid = [
            ['O' , null, 'X' ],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $game = new Game([[2, 3, 5], [0, 4]]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            ['O' , null, 'X' ],
            ['X' , 'O' , 'X' ],
            [null, null, 'O' ]
        ];
        $this->assertEquals([[2, 3, 5], [0, 4, 8]], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsSecondDiagonalOpportunity()
    {
        // Just for visualisation
        $winningGrid = [
            ['X' , null, 'O' ],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $game = new Game([[0, 3, 5], [2, 4]]);

        $game->computerPlays();

        // Just for visualisation
        $expectedGrid = [
            ['X' , null, 'O' ],
            ['X' , 'O' , 'X' ],
            ['O' , null, null]
        ];
        $this->assertEquals([[0, 3, 5], [2, 4, 6]], $game->getPlayersPositions());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningRowOpportunity()
    {
        $blockingGrid = [
            ['X' , null, 'X' ],
            ['O' , null, null],
            [null, 'X' , 'O' ]
        ];
        $game = new Game($blockingGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , 'O' , 'X' ],
            ['O' , null, null],
            [null, 'X' , 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningColumnOpportunity()
    {
        $blockingGrid = [
            ['X' , null, null],
            ['X' , 'O' , 'X' ],
            [null, null, 'O' ]
        ];
        $game = new Game($blockingGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, null],
            ['X' , 'O' , 'X' ],
            ['O' , null, 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningFirstDiagonalOpportunity()
    {
        $blockingGrid = [
            ['X' , null, null],
            ['X' , null, 'O' ],
            ['O' , null, 'X' ]
        ];
        $game = new Game($blockingGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, null],
            ['X' , 'O' , 'O' ],
            ['O' , null, 'X' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksOpponentsWinningSecondDiagonalOpportunity()
    {
        $blockingGrid = [
            [null, null, 'X' ],
            [null, null, 'O' ],
            ['X' , 'X' , 'O' ]
        ];
        $game = new Game($blockingGrid);

        $game->computerMarks();

        $expectedGrid = [
            [null, null, 'X' ],
            [null, 'O' , 'O' ],
            ['X' , 'X' , 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::fork
     */
    public function testComputerForks()
    {
        $grid = [
            ['O' , 'X' , 'X' ],
            ['X' , null, null],
            [null, 'O' , null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrid = [
            ['O' , 'X' , 'X' ],
            ['X' , null, null],
            [null, 'O' , 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     */
    public function testComputerBlocksOpponentsFork()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, null, null],
            [null, null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , 'O' , 'X' ],
            [null, 'O' , null],
            [null, null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks()
    {
        $grid = [
            ['X' , null, null],
            [null, 'O' , null],
            [null, null, 'X' ]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , 'O' , null],
            [null, 'O' , null],
            [null, null, 'X' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksOpponentsMultipleForks2()
    {
        $grid = [
            [null, null, 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrid = [
            [null, 'O' , 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::center
     */
    public function testComputerPlaysTheCenter()
    {
        $grid = [
            ['X' , null, null],
            [null, null, null],
            [null, null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, null],
            [null, 'O' , null],
            [null, null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::corner
     */
    public function testComputerPlaysACorner()
    {
        $grid = [
            [null, null, null],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrids = [];
        $expectedGrids[] = [
            ['O' , null, null],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $expectedGrids[] = [
            [null, null, 'O' ],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $expectedGrids[] = [
            [null, null, null],
            ['X' , 'O' , 'X' ],
            [null, null, 'O' ]
        ];
        $expectedGrids[] = [
            [null, null, null],
            ['X' , 'O' , 'X' ],
            ['O' , null, null]
        ];
        $this->assertTrue(in_array($game->getGrid(), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::side
     */
    public function testComputerPlaysASide()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, 'X' , null],
            ['O' , 'X' , 'O' ]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $expectedGrids = [];
        $expectedGrids[] = [
            ['X' , 'O' , 'X' ],
            [null, 'X' , 'O' ],
            ['O' , 'X' , 'O' ]
        ];
        $expectedGrids[] = [
            ['X' , 'O' , 'X' ],
            ['O' , 'X' , null],
            ['O' , 'X' , 'O' ]
        ];
        $this->assertTrue(in_array($game->getGrid(), $expectedGrids));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::computerWon
     */
    public function testComputerWins()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $this->assertTrue($game->computerWon());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::computerWon
     */
    public function testComputerHasntWon()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $game = new Game($grid);

        $this->assertFalse($game->computerWon());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerPlays
     * @covers \Florin\TicTacToe\Game::isOver
     */
    public function testGameIsOver()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $game = new Game($grid);

        $game->computerMarks();

        $this->assertTrue($game->isOver());
    }

    /**
     * @covers \Florin\TicTacToe\Game::isOver
     */
    public function testGameIsNotOver()
    {
        $grid = [
            ['X' , 'O' , 'X' ],
            [null, 'O' , null],
            ['X' , null, null]
        ];
        $game = new Game($grid);

        $this->assertFalse($game->isOver());
    }
}
