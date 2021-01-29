<?php

class Board
{
    private $board;

    const RESULT_INVALID_MOVE = 0;
    const RESULT_WINNING_MOVE = 1;
    const RESULT_DRAW = 2;
    const RESULT_GAME_CONTINUES = 3;

    function __construct()
    {
        $this->board = [
            ["", "", ""],
            ["", "", ""],
            ["", "", ""]
        ];
    }

    private function check_for_winner($marker)
    {
        if ($this->check_cols_and_rows($marker)) {
            return true;
        }
        if ($this->check_diags($marker)) {
            return true;
        }
    }

    private function check_cols_and_rows($marker)
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

    private function check_diags($marker)
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

    private function check_board_full()
    {
        $empty_flag = false;
        array_walk_recursive($this->board, function ($value, $key) use (&$empty_flag) {
            if (!$value) {
                $empty_flag = true;
            }
        }, $empty_flag);
        return !$empty_flag;
    }

    private function place_marker($marker, $x, $y)
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

    public function place_X($x, $y)
    {
        return $this->place_marker("X", $x, $y);
    }

    public function place_O($x, $y)
    {
        return $this->place_marker("O", $x, $y);
    }

    public function draw()
    {
        foreach($this->board as $row){
            foreach($row as $marker){
                echo " | " . ($marker ? $marker : "-");
            }
            echo " | \n";
        }
    }
}
