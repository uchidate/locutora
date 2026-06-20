<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\AsyncAwsS3;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\ResultStream;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Result\HeadObjectOutput;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\AwsObject;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\CommonPrefix;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ObjectIdentifier;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\SimpleS3\SimpleS3Client;
use Generator;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemAdapter;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathPrefixer;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCheckFileExistence;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCopyFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToReadFile;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToSetVisibility;
use ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility;
use ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\FinfoMimeTypeDetector;
use ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\MimeTypeDetector;
use Throwable;
class AsyncAwsS3Adapter implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FilesystemAdapter
{
    /**
     * @var string[]
     */
    public const AVAILABLE_OPTIONS = ['ACL', 'CacheControl', 'ContentDisposition', 'ContentEncoding', 'ContentLength', 'ContentType', 'Expires', 'GrantFullControl', 'GrantRead', 'GrantReadACP', 'GrantWriteACP', 'Metadata', 'RequestPayer', 'SSECustomerAlgorithm', 'SSECustomerKey', 'SSECustomerKeyMD5', 'SSEKMSKeyId', 'ServerSideEncryption', 'StorageClass', 'Tagging', 'WebsiteRedirectLocation'];
    /**
     * @var string[]
     */
    private const EXTRA_METADATA_FIELDS = ['Metadata', 'StorageClass', 'ETag', 'VersionId'];
    /**
     * @var S3Client
     */
    private $client;
    /**
     * @var PathPrefixer
     */
    private $prefixer;
    /**
     * @var string
     */
    private $bucket;
    /**
     * @var VisibilityConverter
     */
    private $visibility;
    /**
     * @var MimeTypeDetector
     */
    private $mimeTypeDetector;
    /**
     * @param S3Client|SimpleS3Client $client Uploading of files larger than 5GB is only supported with SimpleS3Client
     */
    public function __construct(\ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client $client, string $bucket, string $prefix = '', \ZOOlanders\YOOessentials\Vendor\League\Flysystem\AsyncAwsS3\VisibilityConverter $visibility = null, \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\MimeTypeDetector $mimeTypeDetector = null)
    {
        $this->client = $client;
        $this->prefixer = new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\PathPrefixer($prefix);
        $this->bucket = $bucket;
        $this->visibility = $visibility ?: new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\AsyncAwsS3\PortableVisibilityConverter();
        $this->mimeTypeDetector = $mimeTypeDetector ?: new \ZOOlanders\YOOessentials\Vendor\League\MimeTypeDetection\FinfoMimeTypeDetector();
    }
    public function fileExists(string $path) : bool
    {
        try {
            return $this->client->objectExists(['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path)])->isSuccess();
        } catch (\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException $e) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCheckFileExistence::forLocation($path, $e);
        }
    }
    public function write(string $path, string $contents, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        $this->upload($path, $contents, $config);
    }
    public function writeStream(string $path, $contents, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        $this->upload($path, $contents, $config);
    }
    public function read(string $path) : string
    {
        $body = $this->readObject($path);
        return $body->getContentAsString();
    }
    public function readStream(string $path)
    {
        $body = $this->readObject($path);
        return $body->getContentAsResource();
    }
    public function delete(string $path) : void
    {
        $arguments = ['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path)];
        try {
            $this->client->deleteObject($arguments);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToDeleteFile::atLocation($path, '', $exception);
        }
    }
    public function deleteDirectory(string $path) : void
    {
        $prefix = $this->prefixer->prefixPath($path);
        $prefix = \ltrim(\rtrim($prefix, '/') . '/', '/');
        $objects = [];
        $params = ['Bucket' => $this->bucket, 'Prefix' => $prefix];
        $result = $this->client->listObjectsV2($params);
        /** @var AwsObject $item */
        foreach ($result->getContents() as $item) {
            $key = $item->getKey();
            if (null !== $key) {
                $objects[] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ObjectIdentifier(['Key' => $key]);
            }
        }
        if (empty($objects)) {
            return;
        }
        $this->client->deleteObjects(['Bucket' => $this->bucket, 'Delete' => ['Objects' => $objects]]);
    }
    public function createDirectory(string $path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        $config = $config->withDefaults(['visibility' => $this->visibility->defaultForDirectories()]);
        $this->upload(\rtrim($path, '/') . '/', '', $config);
    }
    public function setVisibility(string $path, string $visibility) : void
    {
        $arguments = ['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path), 'ACL' => $this->visibility->visibilityToAcl($visibility)];
        try {
            $this->client->putObjectAcl($arguments);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToSetVisibility::atLocation($path, '', $exception);
        }
    }
    public function visibility(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $arguments = ['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path)];
        try {
            $result = $this->client->getObjectAcl($arguments);
            $grants = $result->getGrants();
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::visibility($path, '', $exception);
        }
        $visibility = $this->visibility->aclToVisibility($grants);
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, null, $visibility);
    }
    public function mimeType(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes::ATTRIBUTE_MIME_TYPE);
        if (null === $attributes->mimeType()) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::mimeType($path);
        }
        return $attributes;
    }
    public function lastModified(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes::ATTRIBUTE_LAST_MODIFIED);
        if (null === $attributes->lastModified()) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::lastModified($path);
        }
        return $attributes;
    }
    public function fileSize(string $path) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes::ATTRIBUTE_FILE_SIZE);
        if (null === $attributes->fileSize()) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::fileSize($path);
        }
        return $attributes;
    }
    public function listContents(string $path, bool $deep) : iterable
    {
        $prefix = \trim($this->prefixer->prefixPath($path), '/');
        $prefix = empty($prefix) ? '' : $prefix . '/';
        $options = ['Bucket' => $this->bucket, 'Prefix' => $prefix];
        if (\false === $deep) {
            $options['Delimiter'] = '/';
        }
        $listing = $this->retrievePaginatedListing($options);
        foreach ($listing as $item) {
            (yield $this->mapS3ObjectMetadata($item));
        }
    }
    public function move(string $source, string $destination, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            $this->copy($source, $destination, $config);
            $this->delete($source);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToMoveFile::fromLocationTo($source, $destination, $exception);
        }
    }
    public function copy(string $source, string $destination, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        try {
            /** @var string $visibility */
            $visibility = $config->get(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config::OPTION_VISIBILITY) ?: $this->visibility($source)->visibility();
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCopyFile::fromLocationTo($source, $destination, $exception);
        }
        $arguments = ['ACL' => $this->visibility->visibilityToAcl($visibility), 'Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($destination), 'CopySource' => $this->bucket . '/' . $this->prefixer->prefixPath($source)];
        try {
            $this->client->copyObject($arguments);
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToCopyFile::fromLocationTo($source, $destination, $exception);
        }
    }
    /**
     * @param string|resource $body
     */
    private function upload(string $path, $body, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : void
    {
        $key = $this->prefixer->prefixPath($path);
        $acl = $this->determineAcl($config);
        $options = $this->createOptionsFromConfig($config);
        $shouldDetermineMimetype = '' !== $body && !\array_key_exists('ContentType', $options);
        if ($shouldDetermineMimetype && ($mimeType = $this->mimeTypeDetector->detectMimeType($key, $body))) {
            $options['ContentType'] = $mimeType;
        }
        if ($this->client instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\SimpleS3\SimpleS3Client) {
            // Supports upload of files larger than 5GB
            $this->client->upload($this->bucket, $key, $body, \array_merge($options, ['ACL' => $acl]));
        } else {
            $this->client->putObject(\array_merge($options, ['Bucket' => $this->bucket, 'Key' => $key, 'Body' => $body, 'ACL' => $acl]));
        }
    }
    private function determineAcl(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : string
    {
        $visibility = (string) $config->get(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config::OPTION_VISIBILITY, \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Visibility::PRIVATE);
        return $this->visibility->visibilityToAcl($visibility);
    }
    private function createOptionsFromConfig(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Config $config) : array
    {
        $options = [];
        foreach (static::AVAILABLE_OPTIONS as $option) {
            $value = $config->get($option, '__NOT_SET__');
            if ('__NOT_SET__' !== $value) {
                $options[$option] = $value;
            }
        }
        return $options;
    }
    private function fetchFileMetadata(string $path, string $type) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes
    {
        $arguments = ['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path)];
        try {
            $result = $this->client->headObject($arguments);
            $result->resolve();
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::create($path, $type, '', $exception);
        }
        $attributes = $this->mapS3ObjectMetadata($result, $path);
        if (!$attributes instanceof \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToRetrieveMetadata::create($path, $type, '');
        }
        return $attributes;
    }
    /**
     * @param HeadObjectOutput|AwsObject|CommonPrefix $item
     */
    private function mapS3ObjectMetadata($item, string $path = null) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\StorageAttributes
    {
        if (null === $path) {
            if ($item instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\AwsObject) {
                $path = $this->prefixer->stripPrefix($item->getKey() ?? '');
            } elseif ($item instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\CommonPrefix) {
                $path = $this->prefixer->stripPrefix($item->getPrefix() ?? '');
            } else {
                throw new \RuntimeException(\sprintf('Argument 2 of "%s" cannot be null when $item is not instance of "%s" or %s', __METHOD__, \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\AwsObject::class, \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\CommonPrefix::class));
            }
        }
        if ('/' === \substr($path, -1)) {
            return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\DirectoryAttributes(\rtrim($path, '/'));
        }
        $mimeType = null;
        $fileSize = null;
        $lastModified = null;
        $dateTime = null;
        $metadata = [];
        if ($item instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\AwsObject) {
            $dateTime = $item->getLastModified();
            $fileSize = $item->getSize();
        } elseif ($item instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\CommonPrefix) {
            // No data available
        } elseif ($item instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Result\HeadObjectOutput) {
            $mimeType = $item->getContentType();
            $fileSize = $item->getContentLength();
            $dateTime = $item->getLastModified();
            $metadata = $this->extractExtraMetadata($item);
        } else {
            throw new \RuntimeException(\sprintf('Object of class "%s" is not supported in %s()', \get_class($item), __METHOD__));
        }
        if ($dateTime instanceof \DateTimeInterface) {
            $lastModified = $dateTime->getTimestamp();
        }
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\FileAttributes($path, $fileSize !== null ? (int) $fileSize : null, null, $lastModified, $mimeType, $metadata);
    }
    /**
     * @param HeadObjectOutput $metadata
     */
    private function extractExtraMetadata($metadata) : array
    {
        $extracted = [];
        foreach (static::EXTRA_METADATA_FIELDS as $field) {
            $method = 'get' . $field;
            if (!\method_exists($metadata, $method)) {
                continue;
            }
            $value = $metadata->{$method}();
            if (null !== $value) {
                $extracted[$field] = $value;
            }
        }
        return $extracted;
    }
    private function retrievePaginatedListing(array $options) : \Generator
    {
        $result = $this->client->listObjectsV2($options);
        foreach ($result as $item) {
            (yield $item);
        }
    }
    private function readObject(string $path) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\ResultStream
    {
        $options = ['Bucket' => $this->bucket, 'Key' => $this->prefixer->prefixPath($path)];
        try {
            return $this->client->getObject($options)->getBody();
        } catch (\Throwable $exception) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\UnableToReadFile::fromLocation($path, '', $exception);
        }
    }
}
