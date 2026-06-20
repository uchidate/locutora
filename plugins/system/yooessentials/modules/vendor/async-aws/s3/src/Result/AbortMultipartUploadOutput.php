<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Result;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Result;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Enum\RequestCharged;
class AbortMultipartUploadOutput extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Result
{
    private $requestCharged;
    /**
     * @return RequestCharged::*|null
     */
    public function getRequestCharged() : ?string
    {
        $this->initialize();
        return $this->requestCharged;
    }
    protected function populateResult(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Response $response) : void
    {
        $headers = $response->getHeaders();
        $this->requestCharged = $headers['x-amz-request-charged'][0] ?? null;
    }
}
