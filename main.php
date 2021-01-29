<?php

require_once(__DIR__ . "/tictactoe.php");

function print_result(Board $board, string $move_desc, int $result)
{
    $board->draw();
    echo "\n";
    if ($result == Board::RESULT_INVALID_MOVE) {
        echo $move_desc . " results in an invalid move!\n---\n";
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

$b = new Board();

print_result($b, "Placing X at 0,0", $b->place_X(0, 0));
print_result($b, "Placing O at 0,0", $b->place_O(0, 0));
print_result($b, "Placing O at 0,1", $b->place_O(0, 1));
print_result($b, "Placing X at 1,0", $b->place_X(1, 0));
print_result($b, "Placing O at 1,1", $b->place_O(1, 1));
print_result($b, "Placing X at 2,0", $b->place_X(2, 0));