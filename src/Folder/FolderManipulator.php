<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:41
 */

declare(strict_types=1);

namespace KD\VirtualFolder\Folder;


use KD\VirtualFolder\Exception\FolderManipulatorException;

class FolderManipulator implements FolderManipulationInterface
{
    CONST ROOT_DIR = '/home/virtual-folder/data';

    /**
     * @param $path
     * @return bool
     * @throws FolderManipulatorException
     */
    public function createFolder($path): bool
    {
        if (empty($path)) {
            throw new FolderManipulatorException('Missing folder which you want to create');
        }

        $folderToCreate = $this->getPath($path);

        if (is_dir($folderToCreate)) {
            throw new FolderManipulatorException('Folder already exists');
        }

        return mkdir($folderToCreate);
    }

    /**
     * @param $path
     * @return bool
     * @throws FolderManipulatorException
     */
    public function removeFolder($path): bool
    {
        if (empty($path)) {
            throw new FolderManipulatorException('Missing folder which you want to remove');
        }

        $folderToRemove = $this->getPath($path);
        if (!is_dir($folderToRemove)) {
            throw new FolderManipulatorException('Folder already exists');
        }

        if (!$this->isDirEmpty($folderToRemove)) {
            throw new FolderManipulatorException('Directory is not empty');
        }

        return rmdir($folderToRemove);
    }

    /**
     * Gets all tructure tree
     * It would be more easier to get this in bash 'find data/'
     *
     * @param bool $path
     * @return string
     */
    public function getFoldersTree($path = false): string
    {
        $files = array();
        foreach($this->getDirContents($this->getPath($path)) as $value) {
            $files[] = str_replace(self::ROOT_DIR.DIRECTORY_SEPARATOR, '', $value);
        }

        return implode("\n", array_values($files));
    }

    /**
     * @param $dir
     * @return \Generator
     */
    private function getDirContents($dir) {
        $files = scandir($dir);
        foreach($files as $key => $value){
            if ($value == "." || $value == "..") {
                continue;
            }
            $path = $dir.DIRECTORY_SEPARATOR.$value;
            if(!is_dir($path)) {
                yield $path;

            } else {
                yield from $this->getDirContents($path);
                yield $path;
            }
        }
    }



    /**
     * @param $path
     * @return string
     */
    private function getPath($path): string
    {
        return sprintf('%s%s%s', self::ROOT_DIR, DIRECTORY_SEPARATOR, $path);
    }

    /**
     * @param $path
     * @return bool
     */
    private function isDirEmpty($path): bool
    {
        $di = new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS);
        return iterator_count($di) === 0;
    }
}