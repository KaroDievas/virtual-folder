<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 14:27
 */

declare(strict_types=1);

namespace KD\VirtualFolder\Main;


use KD\VirtualFolder\Backup\BackupProviderInterface;
use KD\VirtualFolder\Exception\CommandNotFoundException;
use KD\VirtualFolder\File\FileUploadInterface;
use KD\VirtualFolder\Folder\FolderManipulationInterface;

class CommandExecutor
{
    private $backupProvider;
    private $folderManipulator;
    private $fileUpload;

    CONST HELP = 'help';
    CONST FOLDER_CREATE = 'folderCreate';
    CONST FOLDER_REMOVE = 'folderRemove';
    CONST LIST_TREE = 'tree';
    CONST UPLOAD_FILE = 'uploadFile';
    CONST REMOVE_FILE = 'removeFile';
    CONST BACKUP = 'backup';

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
        //$result =

        switch ($command) {
            case self::FOLDER_CREATE:
                $this->folderManipulator->createFolder($argument);
                break;
            case self::FOLDER_REMOVE:
                $this->folderManipulator->removeFolder($argument);
                break;
            case self::LIST_TREE;
                return $this->folderManipulator->getFoldersTree($argument);
                break;
            case self::UPLOAD_FILE:
                break;
            case self::REMOVE_FILE:
                break;
            case self::BACKUP:
                break;
            case self::HELP:
                return self::getConstants();
            default:
                throw new CommandNotFoundException(sprintf('Command %s was not found. Use help', $command));
        }
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstants(): string
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return implode("\n", array_values($oClass->getConstants()));
    }

    private function getCommandList()
    {
        return;
    }
}