<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 14:27
 */

namespace KD\VirtualFolder\Main;


use KD\VirtualFolder\Backup\BackupProviderInterface;
use KD\VirtualFolder\File\FileUploadInterface;
use KD\VirtualFolder\Folder\FolderManipulationInterface;

class CommandExecutor
{
    private $backupProvider;
    private $folderManipulator;
    private $fileUpload;

    public function __construct(
        BackupProviderInterface $backupProvider,
        FolderManipulationInterface $folderManipulation,
        FileUploadInterface $fileUpload
    ) {
        $this->backupProvider = $backupProvider;
        $this->fileUpload = $fileUpload;
        $this->folderManipulator = $folderManipulation;
    }

    /**
     * @param $command
     * @param bool $argument - in this case it can be folder name, file name
     */
    public function execute($command, $argument = false)
    {

    }
}