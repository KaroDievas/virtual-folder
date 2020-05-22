<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:21
 */

namespace KD\VirtualFolder\Backup;


interface BackupProviderInterface
{
    public function init(string $host, string $user, string $password);
}