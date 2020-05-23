<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 21:46
 */

namespace KD\VirtualFolder;


trait PathTrait
{
    /**
     * @param $path
     * @return string
     */
    public function getPath($path): string
    {
        return sprintf('%s%s', self::getRootDirectory(), $path);
    }

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return '/home/data/';
    }
}