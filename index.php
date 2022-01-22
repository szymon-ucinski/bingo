<?php
declare(strict_types=1);

use BingoSolver\BingoGame;
use BingoSolver\BingoInput;

require 'vendor/autoload.php';

$inputFile = '';
$stopOnFirstWinner = false;

if ($argc > 1 && (in_array('test', $argv))) {
    $inputFile = 'test.txt';
} else {
    $inputFile = 'input.txt';
}

if ($argc > 1 && (in_array('part:1', $argv))) {
    $stopOnFirstWinner = true;
}

$start = \microtime(true);

// Initialize game
$game = new BingoGame(new BingoInput($inputFile));
// Solve game
$game->play($stopOnFirstWinner);

echo "Part 1 result: " . $game->getFirstWinner()->getScore() . "\n";
if (!$stopOnFirstWinner) {
    echo "Part 2 result: " . $game->getLastWinner()->getScore() . "\n";
}
echo "Solved in " . \round((\microtime(true) - $start) * 1000, 5) . " ms\n";
