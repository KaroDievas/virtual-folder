<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:46
 */

namespace KD\VirtualFolder\File;


interface FileUploadInterface
{
    public function uploadFile($file, $pathToPlace);

    public function removeFile($fileWithPath);
}