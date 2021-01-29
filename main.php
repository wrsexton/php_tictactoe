<?php

require_once(__DIR__ . "/tictactoe.php");

function take_turn(Board $b, string $marker, int $x, int $y)
{
    if($marker == "X")
    {
        print_result($b, "Placing " . $marker . " at " . $x . "," . $y, $b->place_X($x, $y));
        return;
    }

    if($marker == "O")
    {
        print_result($b, "Placing " . $marker . " at " . $x . "," . $y, $b->place_O($x, $y));
        return;
    }

    echo "Invalid marker ( " . $marker . " ) was provided!\n";
}

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

echo "\n***\nWinner result test\n***\n";
$b = new Board();
take_turn($b, "X", 0,0);
take_turn($b, "O", 0,0);
take_turn($b, "O", 0,1);
take_turn($b, "X", 1,0);
take_turn($b, "O", 1,1);
take_turn($b, "X", 2,0);

echo "\n***\nDraw result test\n***\n";
$b->reset_board();

take_turn($b, "X", 1,0);
take_turn($b, "O", 0,1);
take_turn($b, "X", 1,2);
take_turn($b, "O", 1,1);
take_turn($b, "X", 2,1);
take_turn($b, "O", 2,0);
take_turn($b, "X", 0,2);
take_turn($b, "O", 2,2);
take_turn($b, "X", 0,0);