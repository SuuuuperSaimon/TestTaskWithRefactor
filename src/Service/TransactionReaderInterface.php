<?php

namespace App\Service;

interface TransactionReaderInterface
{
    public function read(string $inputFile): iterable;
}
