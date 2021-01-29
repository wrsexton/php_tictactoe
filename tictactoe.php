<?php

require_once( __DIR__ . '/board.php');
require_once(__DIR__ . '/vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class TicTacToe
{
    private Logger $log;
    private Board $board;

    function __construct()
    {
        $this->log = new Logger('tictactoe_logger');
        $this->log->pushHandler(new StreamHandler('tictactoe.log', Logger::WARNING));
        $this->board = new Board();
    }

    public function takeTurn(string $marker, int $x, int $y)
    {
        if ($marker == "X") {
            $this->printResult("Placing " . $marker . " at " . $x . "," . $y, $this->board->placeX($x, $y));
            return;
        }

        if ($marker == "O") {
            $this->printResult("Placing " . $marker . " at " . $x . "," . $y, $this->board->placeO($x, $y));
            return;
        }

        echo "Invalid marker ( " . $marker . " ) was provided!\n";
    }

    public function resetGame()
    {
        $this->board->resetBoard();
    }

    private function printResult(string $move_desc, int $result)
    {
        $this->board->draw();
        echo "\n";
        if ($result == Board::RESULT_INVALID_MOVE) {
            echo $move_desc . " results in an invalid move!\n---\n";
            $this->log->addWarning('An invalid move was attempted!');
            return;
        }
        if ($result == Board::RESULT_WINNING_MOVE) {
            echo $move_desc . " results in a winner!\n---\n";
            return;
        }
        if ($result == Board::RESULT_DRAW) {
            echo $move_desc . " results in a draw!\n---\n";
            return;
        }
        if ($result == Board::RESULT_GAME_CONTINUES) {
            echo $move_desc . " results in the game continuing!\n---\n";
            return;
        }
    }
}