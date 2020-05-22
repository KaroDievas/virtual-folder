<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:46
 */

declare(strict_types=1);

namespace KD\VirtualFolder\File;


use KD\VirtualFolder\Exception\UploadFileException;
use KD\VirtualFolder\PathTrait;

class FileUpload implements FileUploadInterface
{
    use PathTrait;

    /**
     * @param $file
     * @param $pathToPlace
     * @return bool
     * @throws UploadFileException
     */
    public function uploadFile($file, $pathToPlace)
    {
        if (!is_file($file)) {
            throw new UploadFileException('Please provide correct file');
        }
        $fileName = basename($file);
        $folder = self::getPath($pathToPlace);
        if (!is_dir($folder)) {
            throw new UploadFileException('Such directory do not exists');
        }

        return copy($file, $folder . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @param $fileWithPath
     * @return bool
     * @throws UploadFileException
     */
    public function removeFile($fileWithPath)
    {
        $realPath = self::getPath($fileWithPath);
        if (!is_file($realPath)) {
            throw new UploadFileException('Please provide correct file');
        }

        return unlink($realPath);
    }
}