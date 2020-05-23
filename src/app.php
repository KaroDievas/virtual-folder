<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:15
 */

require_once __DIR__ . '/../vendor/autoload.php';

use \KD\VirtualFolder\Main\CommandExecutor;
use \KD\VirtualFolder\Folder\FolderManipulator;
use \KD\VirtualFolder\File\FileUpload;
use \KD\VirtualFolder\Backup\FTPBackupProvider;

if (!isset($argv[1])) {
    echo "\n Please enter command. Or use help syntax: php src/app.php help \n \n";
    return;
}

$command = $argv[1];

$folderManipulator = new FolderManipulator();

$commandExecutor = new CommandExecutor(new FTPBackupProvider($folderManipulator), $folderManipulator, new FileUpload());
try {
    echo "\n";
    print_r($commandExecutor->execute($command, $argv[2]?? false, $argv[3] ?? false));
    echo "\n \n";
}
catch (Exception $exception){
    echo sprintf("\n %s \n \n", $exception->getMessage());
}

