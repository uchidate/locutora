<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

use DateTime;
use Generator;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathPrefixer;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCopyFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCreateDirectory;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteDirectory;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToReadFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToSetVisibility;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToWriteFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\VisibilityConverter;
use ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\FinfoMimeTypeDetector;
use ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\MimeTypeDetector;
use Throwable;
use function ftp_chdir;
use function ftp_pwd;
class FtpAdapter implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemAdapter
{
    private const SYSTEM_TYPE_WINDOWS = 'windows';
    private const SYSTEM_TYPE_UNIX = 'unix';
    /**
     * @var FtpConnectionOptions
     */
    private $connectionOptions;
    /**
     * @var FtpConnectionProvider
     */
    private $connectionProvider;
    /**
     * @var ConnectivityChecker
     */
    private $connectivityChecker;
    /**
     * @var resource|false|\FTP\Connection
     */
    private $connection = \false;
    /**
     * @var PathPrefixer
     */
    private $prefixer;
    /**
     * @var VisibilityConverter
     */
    private $visibilityConverter;
    /**
     * @var bool|null
     */
    private $isPureFtpdServer;
    /**
     * @var null|string
     */
    private $systemType;
    /**
     * @var MimeTypeDetector
     */
    private $mimeTypeDetector;
    /**
     * @var null|string
     */
    private $rootDirectory = null;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $connectionOptions, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionProvider $connectionProvider = null, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\ConnectivityChecker $connectivityChecker = null, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\VisibilityConverter $visibilityConverter = null, \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\MimeTypeDetector $mimeTypeDetector = null)
    {
        $this->connectionOptions = $connectionOptions;
        $this->connectionProvider = $connectionProvider ?: new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionProvider();
        $this->connectivityChecker = $connectivityChecker ?: new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\NoopCommandConnectivityChecker();
        $this->visibilityConverter = $visibilityConverter ?: new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnixVisibility\PortableVisibilityConverter();
        $this->mimeTypeDetector = $mimeTypeDetector ?: new \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\FinfoMimeTypeDetector();
    }
    /**
     * Disconnect FTP connection on destruct.
     */
    public function __destruct()
    {
        if ($this->hasFtpConnection()) {
            @\ftp_close($this->connection);
        }
        $this->connection = \false;
    }
    /**
     * @return resource
     */
    private function connection()
    {
        start:
        if (!$this->hasFtpConnection()) {
            $this->connection = $this->connectionProvider->createConnection($this->connectionOptions);
            $this->rootDirectory = $this->resolveConnectionRoot($this->connection);
            $this->prefixer = new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathPrefixer($this->rootDirectory);
            return $this->connection;
        }
        if ($this->connectivityChecker->isConnected($this->connection) === \false) {
            $this->connection = \false;
            goto start;
        }
        \ftp_chdir($this->connection, $this->rootDirectory);
        return $this->connection;
    }
    private function isPureFtpdServer() : bool
    {
        if ($this->isPureFtpdServer !== null) {
            return $this->isPureFtpdServer;
        }
        $response = \ftp_raw($this->connection, 'HELP');
        return $this->isPureFtpdServer = \stripos(\implode(' ', $response), 'Pure-FTPd') !== \false;
    }
    public function fileExists(string $path) : bool
    {
        try {
            $this->fileSize($path);
            return \true;
        } catch (\ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata $exception) {
            return \false;
        }
    }
    public function write(string $path, string $contents, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            $writeStream = \fopen('php://temp', 'w+b');
            \fwrite($writeStream, $contents);
            \rewind($writeStream);
            $this->writeStream($path, $writeStream, $config);
        } finally {
            isset($writeStream) && \is_resource($writeStream) && \fclose($writeStream);
        }
    }
    public function writeStream(string $path, $contents, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            $this->ensureParentDirectoryExists($path, $config->get(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config::OPTION_DIRECTORY_VISIBILITY));
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToWriteFile::atLocation($path, 'creating parent directory failed', $exception);
        }
        $location = $this->prefixer()->prefixPath($path);
        if (!\ftp_fput($this->connection(), $location, $contents, $this->connectionOptions->transferMode())) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToWriteFile::atLocation($path, 'writing the file failed');
        }
        if (!($visibility = $config->get(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config::OPTION_VISIBILITY))) {
            return;
        }
        try {
            $this->setVisibility($path, $visibility);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToWriteFile::atLocation($path, 'setting visibility failed', $exception);
        }
    }
    public function read(string $path) : string
    {
        $readStream = $this->readStream($path);
        $contents = \stream_get_contents($readStream);
        \fclose($readStream);
        return $contents;
    }
    public function readStream(string $path)
    {
        $location = $this->prefixer()->prefixPath($path);
        $stream = \fopen('php://temp', 'w+b');
        $result = @\ftp_fget($this->connection(), $stream, $location, $this->connectionOptions->transferMode());
        if (!$result) {
            \fclose($stream);
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToReadFile::fromLocation($path);
        }
        \rewind($stream);
        return $stream;
    }
    public function delete(string $path) : void
    {
        $connection = $this->connection();
        $this->deleteFile($path, $connection);
    }
    /**
     * @param resource $connection
     */
    private function deleteFile(string $path, $connection) : void
    {
        $location = $this->prefixer()->prefixPath($path);
        $success = @\ftp_delete($connection, $location);
        if ($success === \false && \ftp_size($connection, $location) !== -1) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteFile::atLocation($path, 'the file still exists');
        }
    }
    public function deleteDirectory(string $path) : void
    {
        /** @var StorageAttributes[] $contents */
        $contents = $this->listContents($path, \true);
        $connection = $this->connection();
        $directories = [$path];
        foreach ($contents as $item) {
            if ($item->isDir()) {
                $directories[] = $item->path();
                continue;
            }
            try {
                $this->deleteFile($item->path(), $connection);
            } catch (\Throwable $exception) {
                throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteDirectory::atLocation($path, 'unable to delete child', $exception);
            }
        }
        \rsort($directories);
        foreach ($directories as $directory) {
            if (!@\ftp_rmdir($connection, $this->prefixer()->prefixPath($directory))) {
                throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteDirectory::atLocation($path, "Could not delete directory {$directory}");
            }
        }
    }
    public function createDirectory(string $path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        $this->ensureDirectoryExists($path, $config->get('visibility'));
    }
    public function setVisibility(string $path, string $visibility) : void
    {
        $location = $this->prefixer()->prefixPath($path);
        $mode = $this->visibilityConverter->forFile($visibility);
        if (!@\ftp_chmod($this->connection(), $mode, $location)) {
            $message = \error_get_last()['message'];
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToSetVisibility::atLocation($path, $message);
        }
    }
    private function fetchMetadata(string $path, string $type) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $location = $this->prefixer()->prefixPath($path);
        if ($this->isPureFtpdServer) {
            $location = $this->escapePath($location);
        }
        $object = @\ftp_raw($this->connection(), 'STAT ' . $location);
        if (empty($object) || \count($object) < 3 || \substr($object[1], 0, 5) === "ftpd:") {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::create($path, $type, \error_get_last()['message'] ?? '');
        }
        $attributes = $this->normalizeObject($object[1], '');
        if (!$attributes instanceof \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::create($path, $type, 'expected file, ' . ($attributes instanceof \ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes ? 'directory found' : 'nothing found'));
        }
        return $attributes;
    }
    public function mimeType(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        try {
            $contents = $this->read($path);
            $mimetype = $this->mimeTypeDetector->detectMimeType($path, $contents);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::mimeType($path, '', $exception);
        }
        if ($mimetype === null) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::mimeType($path, 'Unknown.');
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, null, null, null, $mimetype);
    }
    public function lastModified(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $location = $this->prefixer()->prefixPath($path);
        $connection = $this->connection();
        $lastModified = @\ftp_mdtm($connection, $location);
        if ($lastModified < 0) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::lastModified($path);
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, null, null, $lastModified);
    }
    public function visibility(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        return $this->fetchMetadata($path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes::ATTRIBUTE_VISIBILITY);
    }
    public function fileSize(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $location = $this->prefixer()->prefixPath($path);
        $connection = $this->connection();
        $fileSize = @\ftp_size($connection, $location);
        if ($fileSize < 0) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::fileSize($path, \error_get_last()['message'] ?? '');
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, $fileSize);
    }
    public function listContents(string $path, bool $deep) : iterable
    {
        $path = \ltrim($path, '/');
        $path = $path === '' ? $path : \trim($path, '/') . '/';
        if ($deep && $this->connectionOptions->recurseManually()) {
            yield from $this->listDirectoryContentsRecursive($path);
        } else {
            $location = $this->prefixer()->prefixPath($path);
            $options = $deep ? '-alnR' : '-aln';
            $listing = $this->ftpRawlist($options, $location);
            yield from $this->normalizeListing($listing, $path);
        }
    }
    private function normalizeListing(array $listing, string $prefix = '') : \Generator
    {
        $base = $prefix;
        foreach ($listing as $item) {
            if ($item === '' || \preg_match('#.* \\.(\\.)?$|^total#', $item)) {
                continue;
            }
            if (\preg_match('#^.*:$#', $item)) {
                $base = \preg_replace('~^\\./*|:$~', '', $item);
                continue;
            }
            (yield $this->normalizeObject($item, $base));
        }
    }
    private function normalizeObject(string $item, string $base) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        $this->systemType === null && ($this->systemType = $this->detectSystemType($item));
        if ($this->systemType === self::SYSTEM_TYPE_UNIX) {
            return $this->normalizeUnixObject($item, $base);
        }
        return $this->normalizeWindowsObject($item, $base);
    }
    private function detectSystemType(string $item) : string
    {
        return \preg_match('/^[0-9]{2,4}-[0-9]{2}-[0-9]{2}/', $item) ? self::SYSTEM_TYPE_WINDOWS : self::SYSTEM_TYPE_UNIX;
    }
    private function normalizeWindowsObject(string $item, string $base) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        $item = \preg_replace('#\\s+#', ' ', \trim($item), 3);
        $parts = \explode(' ', $item, 4);
        if (\count($parts) !== 4) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\InvalidListResponseReceived("Metadata can't be parsed from item '{$item}' , not enough parts.");
        }
        [$date, $time, $size, $name] = $parts;
        $path = $base === '' ? $name : \rtrim($base, '/') . '/' . $name;
        if ($size === '<DIR>') {
            return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes($path);
        }
        // Check for the correct date/time format
        $format = \strlen($date) === 8 ? 'm-d-yH:iA' : 'Y-m-dH:i';
        $dt = \DateTime::createFromFormat($format, $date . $time);
        $lastModified = $dt ? $dt->getTimestamp() : (int) \strtotime("{$date} {$time}");
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, (int) $size, null, $lastModified);
    }
    private function normalizeUnixObject(string $item, string $base) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        $item = \preg_replace('#\\s+#', ' ', \trim($item), 7);
        $parts = \explode(' ', $item, 9);
        if (\count($parts) !== 9) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\InvalidListResponseReceived("Metadata can't be parsed from item '{$item}' , not enough parts.");
        }
        [$permissions, , , , $size, $month, $day, $timeOrYear, $name] = $parts;
        $isDirectory = $this->listingItemIsDirectory($permissions);
        $permissions = $this->normalizePermissions($permissions);
        $path = $base === '' ? $name : \rtrim($base, '/') . '/' . $name;
        $lastModified = $this->connectionOptions->timestampsOnUnixListingsEnabled() ? $this->normalizeUnixTimestamp($month, $day, $timeOrYear) : null;
        if ($isDirectory) {
            return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes($path, $this->visibilityConverter->inverseForDirectory($permissions), $lastModified);
        }
        $visibility = $this->visibilityConverter->inverseForFile($permissions);
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, (int) $size, $visibility, $lastModified);
    }
    private function listingItemIsDirectory(string $permissions) : bool
    {
        return \substr($permissions, 0, 1) === 'd';
    }
    private function normalizeUnixTimestamp(string $month, string $day, string $timeOrYear) : int
    {
        if (\is_numeric($timeOrYear)) {
            $year = $timeOrYear;
            $hour = '00';
            $minute = '00';
            $seconds = '00';
        } else {
            $year = \date('Y');
            [$hour, $minute] = \explode(':', $timeOrYear);
            $seconds = '00';
        }
        $dateTime = \DateTime::createFromFormat('Y-M-j-G:i:s', "{$year}-{$month}-{$day}-{$hour}:{$minute}:{$seconds}");
        return $dateTime->getTimestamp();
    }
    private function normalizePermissions(string $permissions) : int
    {
        // remove the type identifier
        $permissions = \substr($permissions, 1);
        // map the string rights to the numeric counterparts
        $map = ['-' => '0', 'r' => '4', 'w' => '2', 'x' => '1'];
        $permissions = \strtr($permissions, $map);
        // split up the permission groups
        $parts = \str_split($permissions, 3);
        // convert the groups
        $mapper = function ($part) {
            return \array_sum(\str_split($part));
        };
        // converts to decimal number
        return \octdec(\implode('', \array_map($mapper, $parts)));
    }
    /**
     * @inheritdoc
     *
     * @param string $directory
     */
    private function listDirectoryContentsRecursive(string $directory) : \Generator
    {
        $location = $this->prefixer()->prefixPath($directory);
        $listing = $this->ftpRawlist('-aln', $location);
        /** @var StorageAttributes[] $listing */
        $listing = $this->normalizeListing($listing, $directory);
        foreach ($listing as $item) {
            (yield $item);
            if (!$item->isDir()) {
                continue;
            }
            $children = $this->listDirectoryContentsRecursive($item->path());
            foreach ($children as $child) {
                (yield $child);
            }
        }
    }
    private function ftpRawlist(string $options, string $path) : array
    {
        $path = \rtrim($path, '/') . '/';
        $connection = $this->connection();
        if ($this->isPureFtpdServer()) {
            $path = \str_replace(' ', '\\ ', $path);
            $path = $this->escapePath($path);
        }
        return \ftp_rawlist($connection, $options . ' ' . $path, \stripos($options, 'R') !== \false) ?: [];
    }
    public function move(string $source, string $destination, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            $this->ensureParentDirectoryExists($destination, $config->get(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config::OPTION_DIRECTORY_VISIBILITY));
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile::fromLocationTo($source, $destination, $exception);
        }
        $sourceLocation = $this->prefixer()->prefixPath($source);
        $destinationLocation = $this->prefixer()->prefixPath($destination);
        $connection = $this->connection();
        if (!@\ftp_rename($connection, $sourceLocation, $destinationLocation)) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile::fromLocationTo($source, $destination);
        }
    }
    public function copy(string $source, string $destination, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            $readStream = $this->readStream($source);
            $visibility = $this->visibility($source)->visibility();
            $this->writeStream($destination, $readStream, new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config(\compact('visibility')));
        } catch (\Throwable $exception) {
            if (isset($readStream) && \is_resource($readStream)) {
                @\fclose($readStream);
            }
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCopyFile::fromLocationTo($source, $destination, $exception);
        }
    }
    private function ensureParentDirectoryExists(string $path, ?string $visibility) : void
    {
        $dirname = \dirname($path);
        if ($dirname === '' || $dirname === '.') {
            return;
        }
        $this->ensureDirectoryExists($dirname, $visibility);
    }
    /**
     * @param string $dirname
     */
    private function ensureDirectoryExists(string $dirname, ?string $visibility) : void
    {
        $connection = $this->connection();
        $dirPath = '';
        $parts = \explode('/', \trim($dirname, '/'));
        $mode = $visibility ? $this->visibilityConverter->forDirectory($visibility) : \false;
        foreach ($parts as $part) {
            $dirPath .= '/' . $part;
            $location = $this->prefixer()->prefixPath($dirPath);
            if (@\ftp_chdir($connection, $location)) {
                continue;
            }
            \error_clear_last();
            $result = @\ftp_mkdir($connection, $location);
            if ($result === \false) {
                $errorMessage = \error_get_last()['message'] ?? 'unable to create the directory';
                throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCreateDirectory::atLocation($dirPath, $errorMessage);
            }
            if ($mode !== \false && @\ftp_chmod($connection, $mode, $location) === \false) {
                throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCreateDirectory::atLocation($dirPath, 'unable to chmod the directory');
            }
        }
    }
    private function escapePath(string $path) : string
    {
        return \str_replace(['*', '[', ']'], ['\\*', '\\[', '\\]'], $path);
    }
    /**
     * @return bool
     */
    private function hasFtpConnection() : bool
    {
        return $this->connection instanceof \ZOOlanders\YOOessentials\Vendor\FTP\Connection || \is_resource($this->connection);
    }
    /**
     * @param resource|\FTP\Connection $connection
     */
    private function resolveConnectionRoot($connection) : string
    {
        $root = $this->connectionOptions->root();
        if ($root !== '') {
            \ftp_chdir($connection, $root);
        }
        return \ftp_pwd($connection);
    }
    /**
     * @return PathPrefixer
     */
    private function prefixer() : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathPrefixer
    {
        if ($this->rootDirectory === null) {
            $this->connection();
        }
        return $this->prefixer;
    }
}
