<?php

require_once(__DIR__ . "/tictactoe.php");


echo "\n***\nWinner result test\n***\n";
$t = new TicTacToe();
$t->takeTurn("X", 0, 0);
$t->takeTurn("O", 0, 0);
$t->takeTurn("O", 0, 1);
$t->takeTurn("X", 1, 0);
$t->takeTurn("O", 1, 1);
$t->takeTurn("X", 2, 0);

echo "\n***\nDraw result test\n***\n";
$t->resetGame();
$t->takeTurn("X", 1, 0);
$t->takeTurn("O", 0, 1);
$t->takeTurn("X", 1, 2);
$t->takeTurn("O", 1, 1);
$t->takeTurn("X", 2, 1);
$t->takeTurn("O", 2, 0);
$t->takeTurn("X", 0, 2);
$t->takeTurn("O", 2, 2);
$t->takeTurn("X", 0, 0);