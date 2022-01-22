<?php

declare(strict_types=1);

namespace BingoSolver;

class BingoInput
{
    /**
     * Array of numbers to play in bingo
     * @var int[] 
     */
    public array $numbers;
    /**
     * Array of multidimensional arrays with numbers for bingo boards
     * @var array[]
     */
    public array $boards;

    public function __construct(string $fileName)
    {
        $data = file_get_contents($fileName);
        // Split data into array chunks separeted by empty lines
        $arrayData = preg_split('/(\r\n|\n){2,}/', trim($data), -1, PREG_SPLIT_NO_EMPTY);

        // Read and remove first line from data
        $this->numbers = array_map('intval', explode(',', trim(array_shift($arrayData))));

        // Read bingo boards data as array of multidimensional arrays of ints
        $this->boards = [];
        foreach ($arrayData as $boards) {
            $boardRows = array_map(
                fn ($row) => array_map('intval', $row),
                array_map(
                    fn ($row) => preg_split('/\s+/', trim($row)),
                    preg_split('/(\r\n|\n)+/', trim($boards))
                )
            );
            $this->boards[] = $boardRows;
        }
    }
}
