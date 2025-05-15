<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\FileTransactionReader;
use App\DTO\Transaction;

class FileTransactionReaderTest extends TestCase
{
    public function testReadReturnsTransactions()
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'trans');
        file_put_contents($tmpFile, '{"bin":"123456","amount":"10.00","currency":"EUR"}' . PHP_EOL);

        $reader = new FileTransactionReader();
        $transactions = iterator_to_array($reader->read($tmpFile), false);

        $this->assertCount(1, $transactions);
        $this->assertInstanceOf(Transaction::class, $transactions[0]);
        $this->assertSame('123456', $transactions[0]->bin);

        unlink($tmpFile);
    }
}

