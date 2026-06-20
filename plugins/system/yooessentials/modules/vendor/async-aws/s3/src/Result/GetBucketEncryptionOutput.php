<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Result;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Result;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionByDefault;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionConfiguration;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionRule;
class GetBucketEncryptionOutput extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Result
{
    private $serverSideEncryptionConfiguration;
    public function getServerSideEncryptionConfiguration() : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionConfiguration
    {
        $this->initialize();
        return $this->serverSideEncryptionConfiguration;
    }
    protected function populateResult(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response $response) : void
    {
        $data = new \SimpleXMLElement($response->getContent());
        $this->serverSideEncryptionConfiguration = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionConfiguration(['Rules' => $this->populateResultServerSideEncryptionRules($data->Rule)]);
    }
    /**
     * @return ServerSideEncryptionRule[]
     */
    private function populateResultServerSideEncryptionRules(\SimpleXMLElement $xml) : array
    {
        $items = [];
        foreach ($xml as $item) {
            $items[] = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionRule(['ApplyServerSideEncryptionByDefault' => !$item->ApplyServerSideEncryptionByDefault ? null : new \ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\ValueObject\ServerSideEncryptionByDefault(['SSEAlgorithm' => (string) $item->ApplyServerSideEncryptionByDefault->SSEAlgorithm, 'KMSMasterKeyID' => ($v = $item->ApplyServerSideEncryptionByDefault->KMSMasterKeyID) ? (string) $v : null]), 'BucketKeyEnabled' => ($v = $item->BucketKeyEnabled) ? \filter_var((string) $v, \FILTER_VALIDATE_BOOLEAN) : null]);
        }
        return $items;
    }
}
