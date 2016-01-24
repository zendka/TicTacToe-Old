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
            ['0', null, '0'],
            [null, 'X', 'X'],
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
            ['X', null, null],
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
            ['X', '0', null],
            ['0', 'X', 'X'],
            [null, '0', null]
        ];
        $game = new Game($grid);

        $game->playerMarks(2, 0);

        $expectedGrid = [
            ['X', '0', null],
            ['0', 'X', 'X'],
            ['X', '0', null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    /**
     * @covers \Florin\TicTacToe\Game::playerMarks
     */
    public function testPlayersMarkIsNotValidIfInAnAlreadyMarkedSpace()
    {
        $grid = [
            ['X', '0', null],
            ['0', 'X', 'X'],
            [null, '0', null]
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
}
