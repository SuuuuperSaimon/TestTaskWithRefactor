<?php

namespace App\Service;

use App\DTO\Transaction;

class FileTransactionReader implements TransactionReaderInterface
{
    public function read(string $inputFile): iterable
    {
        foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            yield Transaction::fromJson($line);
        }
    }
}
