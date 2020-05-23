<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 21:58
 */

namespace KD\VirtualFolder\tests\Main;


use KD\VirtualFolder\Backup\FTPBackupProviderProvider;
use KD\VirtualFolder\Exception\CommandNotFoundException;
use KD\VirtualFolder\File\FileUpload;
use KD\VirtualFolder\Folder\FolderManipulator;
use KD\VirtualFolder\Main\CommandExecutor;
use PHPUnit\Framework\TestCase;

class CommandExecutorTest extends TestCase
{
    private $commandExecutor;

    protected function setUp()
    {
        $fileUploadMock = $this->getMockBuilder(FileUpload::class)->getMock();
        $fileUploadMock->expects($this->any())->method('uploadFile')->willReturn(true);
        $fileUploadMock->expects($this->any())->method('removeFile')->willReturn(true);

        $folderManipulatorMock = $this->getMockBuilder(FolderManipulator::class)->getMock();
        $folderManipulatorMock->expects($this->any())->method('createFolder')->willReturn(true);
        $folderManipulatorMock->expects($this->any())->method('removeFolder')->willReturn(true);
        $folderManipulatorMock->expects($this->any())->method('getFoldersTree')->willReturn('onlyOneFolder');

        $backupMock = $this->getMockBuilder(FTPBackupProviderProvider::class)->disableOriginalConstructor()->getMock();

        $this->commandExecutor = new CommandExecutor($backupMock, $folderManipulatorMock, $fileUploadMock);
    }

    public function testCommandNotFound()
    {
        $this->expectException(CommandNotFoundException::class);
        $this->commandExecutor->execute('noSuchCommand');
    }

    public function testCommands()
    {
        $this->assertNull($this->commandExecutor->execute('folderCreate', ''));
        $this->assertNull($this->commandExecutor->execute('folderRemove', ''));
        $this->assertNull($this->commandExecutor->execute('uploadFile', 'someFileName', 'SomeDirectory'));
        $this->assertNull($this->commandExecutor->execute('removeFile', 'someFileName'));
    }

    public function testGetCommandsList()
    {
        $list = $this->commandExecutor->getConstants();
        $this->assertEquals('help
folderCreate
folderRemove
tree
listFiles
uploadFile
removeFile
backup', $list);
    }

    protected function tearDown()
    {
        unset($this->commandExecutor);
    }
}