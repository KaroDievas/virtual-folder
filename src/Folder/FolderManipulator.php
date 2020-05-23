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
use KD\VirtualFolder\PathTrait;

class FolderManipulator implements FolderManipulationInterface
{
    use PathTrait;

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

        $folderToCreate = self::getPath($path);

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

        $folderToRemove = self::getPath($path);
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
        return implode("\n", $this->getFoldersTreeArray($path));
    }

    /**
     * @param bool $path
     * @return array
     */
    public function getFoldersTreeArray($path = false): array
    {
        $files = array();
        foreach ($this->getDirContents(self::getPath($path)) as $value) {
            $files[] = str_replace(self::getRootDirectory(), '', $value);
        }

        return array_values($files);
    }

    /**
     * @param $dir
     * @return \Generator
     */
    private function getDirContents($dir)
    {
        $files = scandir($dir);
        foreach ($files as $key => $value) {
            if ($value == "." || $value == "..") {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $value;
            if (!is_dir($path)) {
                yield $path;

            } else {
                yield from $this->getDirContents($path);
                yield $path;
            }
        }
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