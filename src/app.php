<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:15
 */

require_once __DIR__ . '/../vendor/autoload.php';

use \KD\VirtualFolder\Main\CommandExecutor;
use \KD\VirtualFolder\Exception\CommandNotFoundException;
use \KD\VirtualFolder\Folder\FolderManipulator;
use \KD\VirtualFolder\File\FileUpload;
use \KD\VirtualFolder\Backup\FTPBackupProviderProvider;

if (!isset($argv[1])) {
    throw new CommandNotFoundException();
}

$argument = false;
$command = $argv[1];
if (isset($argv[2])) {
    $argument = $argv[2];
}

$folderManipulator = new FolderManipulator();

$commandExecutor = new CommandExecutor(new FTPBackupProviderProvider($folderManipulator), $folderManipulator, new FileUpload());
try {
    print_r($commandExecutor->execute($command, $argument));
}
catch (Exception $exception){
    echo sprintf("\n %s \n", $exception->getMessage());
}

