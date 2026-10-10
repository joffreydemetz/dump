<?php

namespace JDZ\Utils\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\Utils\Dump;

class DumpTest extends TestCase
{
    private string $tempFile;

    protected function setUp(): void
    {
        $this->tempFile = sys_get_temp_dir() . '/jdz_dump_test_' . uniqid() . '.txt';
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempFile)) {
            unlink($this->tempFile);
        }
    }

    public function testExistsReturnsFalseForMissingFile(): void
    {
        $dump = new Dump($this->tempFile);

        $this->assertFalse($dump->exists());
    }

    public function testWriteTrimsAndAddsNewline(): void
    {
        $dump = new Dump($this->tempFile);
        $dump->write('  hello  ');

        $content = file_get_contents($this->tempFile);

        $this->assertEquals("hello\n", $content);
    }

    public function testReadReturnsFileContent(): void
    {
        $dump = new Dump($this->tempFile);
        $dump->write('content');

        $result = $dump->read();

        $this->assertEquals("content\n", $result);
    }

    public function testReadReturnsNullForMissingFile(): void
    {
        $dump = new Dump($this->tempFile);

        $result = $dump->read();

        $this->assertNull($result);
    }

    public function testDeleteRemovesFile(): void
    {
        $dump = new Dump($this->tempFile);
        $dump->write('to be deleted');
        $this->assertTrue($dump->exists());

        $dump->delete();

        $this->assertFalse($dump->exists());
        $this->assertFileDoesNotExist($this->tempFile);
    }

    public function testDeleteReturnsSelfForChaining(): void
    {
        $dump = new Dump($this->tempFile);
        $dump->write('test');

        $result = $dump->delete();

        $this->assertSame($dump, $result);
    }

    public function testDeleteOnMissingFileDoesNotError(): void
    {
        $dump = new Dump($this->tempFile);

        $dump->delete();

        $this->assertFalse($dump->exists());
    }

    public function testWriteDeleteWrite(): void
    {
        $dump = new Dump($this->tempFile);
        $dump->write('old content');
        $dump->delete();
        $dump->write('new content');

        $content = $dump->read();

        $this->assertEquals("new content\n", $content);
        $this->assertStringNotContainsString('old content', $content);
    }

    public function testFluentChaining(): void
    {
        $dump = new Dump($this->tempFile);

        $dump->write('line1')
             ->write('line2')
             ->write('line3');

        $content = $dump->read();

        $this->assertEquals("line1\nline2\nline3\n", $content);
    }
}
