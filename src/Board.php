<?php
declare(strict_types=1);

namespace BingoSolver;

class Board
{
    /**
     * Did board won
     */
    public bool $won = false;
    /**
     * Number that was played when board won 
     */
    protected int $winningNumber = 0;

    public function __construct(
        private array $boardNumbers
    ) {
    }

    /**
     * Check if board got a number on it
     */
    public function checkNumber(int $number): void
    {
        for ($x = 0; $x < count($this->boardNumbers); ++$x) {
            $y = array_search($number, $this->boardNumbers[$x], true);
            if ($y !== false) {
                // Set 'checked' value
                $this->boardNumbers[$x][$y] = -1;
                // Check if number row or column are winning
                if ($this->checkIfLinesFull($x, $y)) {
                    $this->won = true;
                    $this->winningNumber = $number;
                };
            }
        }
    }

    /**
     * Check if x row or y column is fully checked
     */
    protected function checkIfLinesFull(int $x, int $y): bool
    {
        $boardNumbers = $this->boardNumbers;
        // Check if all elements in x row are same and got 'checked' value
        if (array_unique($boardNumbers[$x]) === [-1]) {
            return true;
        }
        // Check y column
        if (array_unique(array_column($boardNumbers, $y)) === [-1]) {
            return true;
        }
        return false;
    }

    /**
     * Get board score
     */
    public function getScore(): int
    {
        $sum = 0;
        // Sum all numbers excluding 'checked' numbers
        for ($x = 0; $x < count($this->boardNumbers); ++$x) {
            $sum += array_sum(array_filter($this->boardNumbers[$x], fn ($boardNumber) => $boardNumber !== -1));
        }

        return $sum * $this->winningNumber;
    }
}
