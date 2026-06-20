<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\AppSync\AppSyncClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFormation\CloudFormationClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFront\CloudFrontClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatch\CloudWatchClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatchLogs\CloudWatchLogsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeBuild\CodeBuildClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeCommit\CodeCommitClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeDeploy\CodeDeployClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Comprehend\ComprehendClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CacheProvider;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\ChainProvider;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\DynamoDb\DynamoDbClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Ecr\EcrClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\ElastiCache\ElastiCacheClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\EventBridge\EventBridgeClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Firehose\FirehoseClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Iam\IamClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Iot\IotClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\IotData\IotDataClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Kinesis\KinesisClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Kms\KmsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Lambda\LambdaClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\RdsDataService\RdsDataServiceClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Rekognition\RekognitionClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Route53\Route53Client;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\SecretsManager\SecretsManagerClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Ses\SesClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Sns\SnsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Sqs\SqsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Ssm\SsmClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\StepFunctions\StepFunctionsClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamQuery\TimestreamQueryClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamWrite\TimestreamWriteClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Translate\TranslateClient;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\XRay\XRayClient;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * Factory that instantiate API clients.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AwsClientFactory
{
    /**
     * @var array
     */
    private $serviceCache;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var CredentialProvider
     */
    private $credentialProvider;
    /**
     * @var LoggerInterface|null
     */
    private $logger;
    /**
     * @param Configuration|array $configuration
     */
    public function __construct($configuration = [], ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider $credentialProvider = null, ?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null, ?\ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null)
    {
        if (\is_array($configuration)) {
            $configuration = \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::create($configuration);
        } elseif (!$configuration instanceof \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument(\sprintf('Second argument to "%s::__construct()" must be an array or an instance of "%s"', __CLASS__, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::class));
        }
        $this->httpClient = $httpClient ?? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        $this->logger = $logger ?? new \ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger();
        $this->configuration = $configuration;
        $this->credentialProvider = $credentialProvider ?? new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CacheProvider(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\ChainProvider::createDefaultChain($this->httpClient, $this->logger));
    }
    public function appSync() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\AppSync\AppSyncClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\AppSync\AppSyncClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/app-sync', 'AppSync');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\AppSync\AppSyncClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function cloudFormation() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFormation\CloudFormationClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFormation\CloudFormationClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/cloud-formation', 'CloudFormation');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFormation\CloudFormationClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function cloudFront() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFront\CloudFrontClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFront\CloudFrontClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/cloud-front', 'CloudFront');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudFront\CloudFrontClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function cloudWatch() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatch\CloudWatchClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatch\CloudWatchClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/cloud-watch', 'CloudWatch');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatch\CloudWatchClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function cloudWatchLogs() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatchLogs\CloudWatchLogsClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatchLogs\CloudWatchLogsClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/cloud-watch-logs', 'CloudWatchLogs');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CloudWatchLogs\CloudWatchLogsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function codeBuild() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeBuild\CodeBuildClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeBuild\CodeBuildClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/code-build', 'CodeBuild');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeBuild\CodeBuildClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function codeCommit() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeCommit\CodeCommitClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeCommit\CodeCommitClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/code-commit', 'CodeCommit');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeCommit\CodeCommitClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function codeDeploy() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeDeploy\CodeDeployClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeDeploy\CodeDeployClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/code-deploy', 'CodeDeploy');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CodeDeploy\CodeDeployClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function comprehend() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Comprehend\ComprehendClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Comprehend\ComprehendClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/comprehend', 'ComprehendClient');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Comprehend\ComprehendClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function dynamoDb() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\DynamoDb\DynamoDbClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\DynamoDb\DynamoDbClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/dynamo-db', 'DynamoDb');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\DynamoDb\DynamoDbClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function ecr() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ecr\EcrClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Ecr\EcrClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/ecr', 'ECR');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ecr\EcrClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function elastiCache() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\ElastiCache\ElastiCacheClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\ElastiCache\ElastiCacheClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/elasti-cache', 'ElastiCache');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\ElastiCache\ElastiCacheClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function eventBridge() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\EventBridge\EventBridgeClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\EventBridge\EventBridgeClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/event-bridge', 'EventBridge');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\EventBridge\EventBridgeClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function firehose() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Firehose\FirehoseClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Firehose\FirehoseClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/firehose', 'Firehose');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Firehose\FirehoseClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function iam() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Iam\IamClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Iam\IamClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/iam', 'IAM');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Iam\IamClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function iot() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Iot\IotClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Iot\IotClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/iot', 'Iot');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Iot\IotClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function iotData() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\IotData\IotDataClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\IotData\IotDataClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/iot-data', 'IotData');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\IotData\IotDataClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function kinesis() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Kinesis\KinesisClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Kinesis\KinesisClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('aws/kinesis', 'Kinesis');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Kinesis\KinesisClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function kms() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Kms\KmsClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Kms\KmsClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('aws/kms', 'Kms');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Kms\KmsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function lambda() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Lambda\LambdaClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Lambda\LambdaClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/lambda', 'Lambda');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Lambda\LambdaClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function rdsDataService() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\RdsDataService\RdsDataServiceClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\RdsDataService\RdsDataServiceClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/rds-data-service', 'RdsDataService');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\RdsDataService\RdsDataServiceClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function rekognition() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Rekognition\RekognitionClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Rekognition\RekognitionClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('aws/rekognition', 'Rekognition');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Rekognition\RekognitionClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function route53() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Route53\Route53Client
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Route53\Route53Client::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('aws/route53', 'Route53');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Route53\Route53Client($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function s3() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/s3', 'S3');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\S3Client($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function secretsManager() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\SecretsManager\SecretsManagerClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\SecretsManager\SecretsManagerClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/secret-manager', 'SecretsManager');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\SecretsManager\SecretsManagerClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function ses() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ses\SesClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Ses\SesClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/ses', 'SES');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ses\SesClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function sns() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Sns\SnsClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Sns\SnsClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/sns', 'SNS');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Sns\SnsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function sqs() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Sqs\SqsClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Sqs\SqsClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/sqs', 'SQS');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Sqs\SqsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function ssm() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ssm\SsmClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Ssm\SsmClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/ssm', 'SSM');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Ssm\SsmClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function sts() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function stepFunctions() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\StepFunctions\StepFunctionsClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\StepFunctions\StepFunctionsClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/step-functions', 'StepFunctions');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\StepFunctions\StepFunctionsClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function timestreamQuery() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamQuery\TimestreamQueryClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamQuery\TimestreamQueryClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/timestream-query', 'TimestreamQuery');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamQuery\TimestreamQueryClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function timestreamWrite() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamWrite\TimestreamWriteClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamWrite\TimestreamWriteClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/timestream-write', 'TimestreamWrite');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\TimestreamWrite\TimestreamWriteClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function translate() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Translate\TranslateClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Translate\TranslateClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/translate', 'Translate');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Translate\TranslateClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function xRay() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\XRay\XRayClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\XRay\XRayClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('async-aws/x-ray', 'XRay');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\XRay\XRayClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
    public function cognitoIdentityProvider() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\CognitoIdentityProvider\CognitoIdentityProviderClient
    {
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\AsyncAws\CognitoIdentityProvider\CognitoIdentityProviderClient::class)) {
            throw \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\MissingDependency::create('aws/cognito-identity-provider', 'CognitoIdentityProvider');
        }
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\CognitoIdentityProvider\CognitoIdentityProviderClient($this->configuration, $this->credentialProvider, $this->httpClient, $this->logger);
        }
        return $this->serviceCache[__METHOD__];
    }
}
