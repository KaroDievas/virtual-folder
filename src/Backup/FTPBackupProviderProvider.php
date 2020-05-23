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
use KD\VirtualFolder\PathTrait;

class FTPBackupProviderProvider implements BackupProviderInterface
{
    use PathTrait;

    CONST HOST = '';
    CONST USER = 'root';
    CONST PASSWORD = '';
    CONST PORT = 22;
    CONST ROOT_PATH = '/data';

    private $folderManipulation;

    private $connection;
    private $sftp;

    public function __construct(FolderManipulationInterface $folderManipulation)
    {
        $this->folderManipulation = $folderManipulation;
    }

    private function connect()
    {
        $this->connection = @ssh2_connect(self::HOST, self::PORT);
        if (!$this->connection) {
            throw new FtpConnectionFailedException(sprintf('FTP connection has failed! Attempted to connect to %s for user %s',
                self::HOST, self::USER));
        }
    }

    private function login()
    {
        if (!@ssh2_auth_password($this->connection, self::USER, self::PASSWORD)) {
            throw new FtpConnectionFailedException(sprintf('Could not authenticate with username %s and password %s',
                self::USER, self::PASSWORD));
        }

        $this->sftp = @ssh2_sftp($this->connection);
        if (!$this->sftp) {
            throw new FtpConnectionFailedException("Could not initialize SFTP subsystem.");
        }
    }

    /**
     * Backups all files to remote server
     *
     * @throws FtpConnectionFailedException
     */
    public function backup()
    {
        $this->connect();
        $this->login();

        // Creating root path in file system
        // After login we appearing at /
        // no need to check result cause if directory not exists ir will be create
        // or if exists returns false
        ssh2_sftp_mkdir($this->sftp, self::ROOT_PATH);

        $treeList = $this->folderManipulation->getFoldersTreeArray();
        $fileList = [];
        foreach ($treeList as $date) {
            if (is_dir(self::getPath($date))) {
                // create whole directory chains if needed.
                ssh2_sftp_mkdir($this->sftp, sprintf('%s%s', self::ROOT_PATH, $date), 0644, true);
            } else {
                // collect files
                $fileList[] = $date;
            }
        }

        foreach ($fileList as $file) {
            $realPath = self::getPath($file);
            if (is_file($realPath)) {
                ssh2_scp_send($this->connection, self::getPath($file), self::ROOT_PATH . $file, 0644);
            }
        }

        unset($this->connection);
    }
}