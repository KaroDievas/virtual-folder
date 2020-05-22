<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 22:05
 */

namespace KD\VirtualFolder\tests\Folder;


use KD\VirtualFolder\Exception\FolderManipulatorException;
use KD\VirtualFolder\Folder\FolderManipulator;
use PHPUnit\Framework\TestCase;

class FolderManipulatorTest extends TestCase
{
    private $folderManipulator;

    protected function setUp()
    {
        $this->folderManipulator = new FolderManipulator();
    }

    public function testFolderIsNotCreated()
    {
        $this->expectException(FolderManipulatorException::class);
        $this->folderManipulator->createFolder('');
    }

    public function testFolderIsCreated()
    {
        $this->assertTrue($this->folderManipulator->createFolder('testDirectory'));
    }

    public function testAlreadyExistsFolder()
    {
        $this->expectException(FolderManipulatorException::class);
        $this->folderManipulator->createFolder('testDirectory');
    }

    public function testRemoveFolderSuccess()
    {
        $this->assertTrue($this->folderManipulator->removeFolder('testDirectory'));
    }
}