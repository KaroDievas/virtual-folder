<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:41
 */

namespace KD\VirtualFolder\Folder;


interface FolderManipulationInterface
{
    public function createFolder($path);

    public function removeFolder($path);

    public function getFoldersTree($path = false);

    public function getFoldersTreeArray($path = false);

    public function getFilesInPath($path = false);

    public function getFilesListInPathArray($path = false);
}