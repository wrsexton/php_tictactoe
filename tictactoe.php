<?php

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

    public function take_turn(string $marker, int $x, int $y)
    {
        if ($marker == "X") {
            $this->print_result("Placing " . $marker . " at " . $x . "," . $y, $this->board->place_X($x, $y));
            return;
        }

        if ($marker == "O") {
            $this->print_result("Placing " . $marker . " at " . $x . "," . $y, $this->board->place_O($x, $y));
            return;
        }

        echo "Invalid marker ( " . $marker . " ) was provided!\n";
    }

    public function reset_game()
    {
        $this->board->reset_board();
    }

    private function print_result(string $move_desc, int $result)
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

class Board
{
    private array $board;

    public const RESULT_INVALID_MOVE = 0;
    public const RESULT_WINNING_MOVE = 1;
    public const RESULT_DRAW = 2;
    public const RESULT_GAME_CONTINUES = 3;

    function __construct()
    {
        $this->reset_board();
    }

    public function reset_board()
    {
        $this->board = [
            ["", "", ""],
            ["", "", ""],
            ["", "", ""]
        ];
    }

    private function check_for_winner($marker): bool
    {
        if ($this->check_cols_and_rows($marker)) {
            return true;
        }
        if ($this->check_diags($marker)) {
            return true;
        }
        return false;
    }

    private function check_cols_and_rows($marker): bool
    {
        $boardsize = count($this->board);
        for ($i = 0; $i < $boardsize; $i++) {
            // Evaluate Column $i
            $combo_flag = true;
            for ($j = 0; $j < $boardsize; $j++) {
                if ($this->board[$j][$i] != $marker) {
                    $combo_flag = false;
                    break;
                }
            }
            if ($combo_flag) {
                return true;
            }

            // Evaluate Row $i
            $combo_flag = true;
            for ($j = 0; $j < $boardsize; $j++) {
                if ($this->board[$i][$j] != $marker) {
                    $combo_flag = false;
                    break;
                }
            }
            if ($combo_flag) {
                return true;
            }
        }
        return false;
    }

    private function check_diags($marker): bool
    {
        $boardsize = count($this->board);
        // Evaluate Left-To-Right Diag
        $combo_flag = true;
        for ($i = 0; $i < $boardsize; $i++) {
            if ($this->board[$i][$i] != $marker) {
                $combo_flag = false;
                break;
            }
        }
        if ($combo_flag) {
            return true;
        }

        // Evaluate Right-To-Left Diag
        for ($i = 0; $i < $boardsize; $i++) {
            $j = ($boardsize - 1) - $i;
            if ($this->board[$i][$j] != $marker) {
                return false;
            }
        }
        return true;
    }

    private function check_board_full(): bool
    {
        $empty_flag = false;
        array_walk_recursive($this->board, function ($value, $key) use (&$empty_flag) {
            if (!$value) {
                $empty_flag = true;
            }
        }, $empty_flag);
        return !$empty_flag;
    }

    private function place_marker($marker, $x, $y): int
    {
        if ($this->board[$y][$x]) {
            return self::RESULT_INVALID_MOVE;
        }

        try {
            $this->board[$y][$x] = $marker;
        } catch (OutOfBoundsException $e) {
            return self::RESULT_INVALID_MOVE;
        }

        if ($this->check_for_winner($marker)) {
            return self::RESULT_WINNING_MOVE;
        }
        if ($this->check_board_full()) {
            return self::RESULT_DRAW;
        }
        return self::RESULT_GAME_CONTINUES;
    }

    public function place_X($x, $y): int
    {
        return $this->place_marker("X", $x, $y);
    }

    public function place_O($x, $y): int
    {
        return $this->place_marker("O", $x, $y);
    }

    public function draw()
    {
        foreach ($this->board as $row) {
            foreach ($row as $marker) {
                echo " | " . ($marker ? $marker : "-");
            }
            echo " | \n";
        }
    }
}

