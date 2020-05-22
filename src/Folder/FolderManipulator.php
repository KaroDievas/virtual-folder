<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:41
 */

namespace KD\VirtualFolder\Folder;


class FolderManipulator implements FolderManipulationInterface
{
    CONST ROOT_DIR = __DIR__.'/../../data';

    public function __construct()
    {
    }

    public function createFolder($path)
    {

        echo sprintf('%s/%s', self::ROOT_DIR, $path);
        echo "\n";

        return mkdir(sprintf('%s/%s', self::ROOT_DIR, $path));
    }

    public function removeFolder($path)
    {
        return unlink(sprintf('%s/%s', self::ROOT_DIR, $path));
    }

    public function getFoldersTree($path = false)
    {
       // $scanPath = sprintf()

        return scandir(self::ROOT_DIR);
    }

    private function isExistsFolder($path)
    {

    }
}