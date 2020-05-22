<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2020-05-22
 * Time: 13:21
 */

declare(strict_types=1);

namespace KD\VirtualFolder\Backup;


use KD\VirtualFolder\Exception\FtpConnectionFailedException;
use KD\VirtualFolder\Folder\FolderManipulationInterface;

class FTPBackupProviderProvider implements BackupProviderInterface
{
    private $host;
    private $user;
    private $password;

    private $folderManipulation;

    private $connection;

    public function __construct(FolderManipulationInterface $folderManipulation)
    {
        $this->folderManipulation = $folderManipulation;
    }

    public function init(string $host, string $user, string $password)
    {
        $this->user = $user;
        $this->host = $host;
        $this->password = $password;
    }

    public function connect()
    {
        $this->connection = ftp_connect($this->host);
        $login = ftp_login($this->connection, $this->user, $this->password);
        if ((!$this->connection) || (!$login)) {
            throw new FtpConnectionFailedException(sprintf('FTP connection has failed! Attempted to connect to %s for user %s', $this->host, $this->user));
        }
    }

    public function close()
    {
        ftp_close($this->connection);
    }
}