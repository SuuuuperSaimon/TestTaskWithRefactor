<?php

namespace App\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use App\Service\FileGetContentsHttpClient;

class FileGetContentsHttpClientTest extends TestCase
{
    public function testGetReturnsContent()
    {
        $client = new FileGetContentsHttpClient();
        $tmpFile = tempnam(sys_get_temp_dir(), 'http');
        file_put_contents($tmpFile, 'test-content');

        $result = $client->get($tmpFile);

        $this->assertSame('test-content', $result);

        unlink($tmpFile);
    }

    public function testGetThrowsExceptionOnFailure()
    {
        $client = new FileGetContentsHttpClient();

        $this->expectException(\RuntimeException::class);

        set_error_handler(fn() => true);

        $client->get('/non/existing/file');

        restore_error_handler();
    }
}
