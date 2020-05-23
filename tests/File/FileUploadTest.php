<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-23
 * Time: 20:41
 */

namespace KD\VirtualFolder\tests\File;


use KD\VirtualFolder\Exception\UploadFileException;
use KD\VirtualFolder\File\FileUpload;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    private $fileUpload;

    CONST FILE_PATH = __DIR__."/../TestData/fileForUploadTest.txt";

    protected function setUp()
    {
        $this->fileUpload = new FileUpload();
    }

    public function testUploadFileException()
    {
        $this->expectException(UploadFileException::class);
        $this->fileUpload->uploadFile('', '');
        $this->fileUpload->uploadFile(self::FILE_PATH, 'noSuchDir');
        $this->fileUpload->removeFile('');
    }

    public function testUploadFileSuccess()
    {
        $this->assertTrue($this->fileUpload->uploadFile(self::FILE_PATH, ''));
    }

    public function testRemoveFileSuccess()
    {
        $this->assertTrue($this->fileUpload->removeFile('fileForUploadTest.txt'));
    }

    protected function tearDown()
    {
        unset($this->fileUpload);
    }
}