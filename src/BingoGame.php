<?php
declare(strict_types=1);

namespace BingoSolver;

class BingoGame
{
    /**
     * Numbers drawn for each game step
     * @var int[] 
     */
    protected array $numbers;
    /**
     * Set of boards for game
     * @var Board[] 
     */
    protected array $boards;
    /**
     * Array of winning boards from first to last
     * @var Board[] 
     */
    protected array $winners = [];

    public function __construct(BingoInput $input)
    {
        $this->numbers = $input->numbers;
        foreach ($input->boards as $board) {
            $this->boards[] = new Board($board);
        }
    }

    /**
     * Play bingo game
     * @param bool $stopOnFirstWinner Should game stop after finding first winner
     */
    public function play(bool $stopOnFirstWinner = false): void
    {
        $this->winners = [];
        // Iterate through all drawn numbers and check all boards if they contain it
        foreach ($this->numbers as $number) {
            foreach ($this->boards as $board) {
                if (!$board->won) {
                    $board->checkNumber($number);
                    if ($board->won) {
                        $this->winners[] = $board;
                        if ($stopOnFirstWinner) {
                            return;
                        }
                    }
                }
            }
            if (count($this->boards) === count($this->winners)) {
                return;
            }
        }
    }

    public function getFirstWinner(): Board
    {
        return $this->winners[array_key_first($this->winners)] ?? [];
    }

    public function getLastWinner(): Board
    {
        return $this->winners[array_key_last($this->winners)] ?? [];
    }
}
