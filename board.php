<?php

class Board
{
    private array $board;

    public const RESULT_INVALID_MOVE = 0;
    public const RESULT_WINNING_MOVE = 1;
    public const RESULT_DRAW = 2;
    public const RESULT_GAME_CONTINUES = 3;

    function __construct()
    {
        $this->resetBoard();
    }

    public function resetBoard()
    {
        $this->board = [
            ["", "", ""],
            ["", "", ""],
            ["", "", ""]
        ];
    }

    private function checkForWinner($marker): bool
    {
        if ($this->checkColsAndRows($marker)) {
            return true;
        }
        if ($this->checkDiags($marker)) {
            return true;
        }
        return false;
    }

    private function checkColsAndRows($marker): bool
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

    private function checkDiags($marker): bool
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

    private function checkBoardFull(): bool
    {
        $empty_flag = false;
        array_walk_recursive($this->board, function ($value, $key) use (&$empty_flag) {
            if (!$value) {
                $empty_flag = true;
            }
        }, $empty_flag);
        return !$empty_flag;
    }

    private function placeMarker($marker, $x, $y): int
    {
        if ($this->board[$y][$x]) {
            return self::RESULT_INVALID_MOVE;
        }

        try {
            $this->board[$y][$x] = $marker;
        } catch (OutOfBoundsException $e) {
            return self::RESULT_INVALID_MOVE;
        }

        if ($this->checkForWinner($marker)) {
            return self::RESULT_WINNING_MOVE;
        }
        if ($this->checkBoardFull()) {
            return self::RESULT_DRAW;
        }
        return self::RESULT_GAME_CONTINUES;
    }

    public function placeX($x, $y): int
    {
        return $this->placeMarker("X", $x, $y);
    }

    public function placeO($x, $y): int
    {
        return $this->placeMarker("O", $x, $y);
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