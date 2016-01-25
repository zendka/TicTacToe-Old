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
    public function testGameStartsWithEmptyGridByDefault()
    {
        $game = new Game();

        $emptyGrid = [
            [null, null, null],
            [null, null, null],
            [null, null, null]
        ];
        $this->assertEquals($emptyGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::__construct
     */
    public function testGameStartsWithGivenGrid()
    {
        $grid = [
            ['O' , null, 'O' ],
            [null, 'X' , 'X' ],
            [null, null, null]
        ];
        $game = new Game($grid);

        $this->assertEquals($grid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::playerMarks
     */
    public function testPlayersMarkIsRegisteredCorrectlyInEmptyGrid()
    {
        $game = new Game();

        $game->playerMarks(0, 0);

        $expectedGrid = [
            ['X' , null, null],
            [null, null, null],
            [null, null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::playerMarks
     */
    public function testPlayersMarkIsRegisteredCorrectlyInRandomGrid()
    {
        $grid = [
            ['X' , 'O' , null],
            ['O' , 'X' , 'X' ],
            [null, 'O' , null]
        ];
        $game = new Game($grid);

        $game->playerMarks(2, 0);

        $expectedGrid = [
            ['X' , 'O' , null],
            ['O' , 'X' , 'X' ],
            ['X' , 'O' , null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::playerMarks
     */
    public function testPlayersMarkIsNotValidIfInAnAlreadyMarkedSpace()
    {
        $grid = [
            ['X' , 'O' , null],
            ['O' , 'X' , 'X' ],
            [null, 'O' , null]
        ];
        $game = new Game($grid);

        $this->assertFalse($game->playerMarks(1, 0));
    }

    /**
     * @covers \Florin\TicTacToe\Game::playerMarks
     */
    public function testPlayersMarkIsNotValidIfOutsideThe3x3Grid()
    {
        $game = new Game();

        $this->assertFalse($game->playerMarks(3, 0));
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsRow()
    {
        $winningGrid = [
            ['X' , null, 'X' ],
            ['O' , null, 'O' ],
            [null, 'X' , null]
        ];
        $game = new Game($winningGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, 'X' ],
            ['O' , 'O' , 'O' ],
            [null, 'X' , null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsColumn()
    {
        $winningGrid = [
            ['X' , null, 'O' ],
            ['X' , 'X' , 'O' ],
            [null, null, null]
        ];
        $game = new Game($winningGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, 'O' ],
            ['X' , 'X' , 'O' ],
            [null, null, 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsFirstDiagonal()
    {
        $winningGrid = [
            ['O' , null, 'X' ],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $game = new Game($winningGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['O' , null, 'X' ],
            ['X' , 'O' , 'X' ],
            [null, null, 'O' ]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::win
     */
    public function testComputerWinsSecondDiagonal()
    {
        $winningGrid = [
            ['X' , null, 'O' ],
            ['X' , 'O' , 'X' ],
            [null, null, null]
        ];
        $game = new Game($winningGrid);

        $game->computerMarks();

        $expectedGrid = [
            ['X' , null, 'O' ],
            ['X' , 'O' , 'X' ],
            ['O' , null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksWinningRow()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksWinningColumn()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksWinningFirstDiagonal()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockWin
     */
    public function testComputerBlocksWinningSecondDiagonal()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockFork
     */
    public function testComputerBlocksFork()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksMultipleForks()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::blockFork
     * @covers \Florin\TicTacToe\Game::forceOpponent
     */
    public function testComputerBlocksMultipleForks2()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::center
     */
    public function testComputerMarksTheCenter()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::corner
     */
    public function testComputerMarksCorner()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
     * @covers \Florin\TicTacToe\Game::side
     */
    public function testComputerMarksSide()
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
     * @covers \Florin\TicTacToe\Game::computerMarks
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
     * @covers \Florin\TicTacToe\Game::computerMarks
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
     * @covers \Florin\TicTacToe\Game::computerMarks
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
