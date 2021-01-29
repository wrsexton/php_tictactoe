<?php

require_once(__DIR__ . "/tictactoe.php");


echo "\n***\nWinner result test\n***\n";
$t = new TicTacToe();
$t->take_turn("X", 0, 0);
$t->take_turn("O", 0, 0);
$t->take_turn("O", 0, 1);
$t->take_turn("X", 1, 0);
$t->take_turn("O", 1, 1);
$t->take_turn("X", 2, 0);

echo "\n***\nDraw result test\n***\n";
$t->reset_game();
$t->take_turn("X", 1, 0);
$t->take_turn("O", 0, 1);
$t->take_turn("X", 1, 2);
$t->take_turn("O", 1, 1);
$t->take_turn("X", 2, 1);
$t->take_turn("O", 2, 0);
$t->take_turn("X", 0, 2);
$t->take_turn("O", 2, 2);
$t->take_turn("X", 0, 0);