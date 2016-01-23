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
     * @covers \Florin\TicTacToe\Game::getGrid
     */
    public function testGameStartsWithEmptyGrid()
    {
        $game = new Game();
        $emptyGrid = [
            [null, null, null],
            [null, null, null],
            [null, null, null]
        ];
        $this->assertEquals($emptyGrid, $game->getGrid());
    }

    public function testPlayersMarkIsRegisteredCorrectly()
    {
        $game = new Game();

        $position = ['row' => 0, 'col' => 0];
        $game->playerMarks($position);

        $expectedGrid = [
            ['X', null, null],
            [null, null, null],
            [null, null, null]
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }
}
