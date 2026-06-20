<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AbstractApi;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\XmlAwsErrorFactory;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\ExpiredTokenException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\IDPCommunicationErrorException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\IDPRejectedClaimException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\InvalidIdentityTokenException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\MalformedPolicyDocumentException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\PackedPolicyTooLargeException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\RegionDisabledException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\AssumeRoleRequest;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\AssumeRoleWithWebIdentityRequest;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\GetCallerIdentityRequest;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleResponse;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleWithWebIdentityResponse;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\GetCallerIdentityResponse;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\ValueObject\PolicyDescriptorType;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\ValueObject\Tag;
class StsClient extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AbstractApi
{
    /**
     * Returns a set of temporary security credentials that you can use to access Amazon Web Services resources that you
     * might not normally have access to. These temporary credentials consist of an access key ID, a secret access key, and
     * a security token. Typically, you use `AssumeRole` within your account or for cross-account access. For a comparison
     * of `AssumeRole` with other API operations that produce temporary credentials, see Requesting Temporary Security
     * Credentials and Comparing the Amazon Web Services STS API operations in the *IAM User Guide*.
     *
     * @see https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_temp_request.html
     * @see https://docs.aws.amazon.com/IAM/latest/UserGuide/id_credentials_temp_request.html#stsapi_comparison
     * @see https://docs.aws.amazon.com/STS/latest/APIReference/API_AssumeRole.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sts-2011-06-15.html#assumerole
     *
     * @param array{
     *   RoleArn: string,
     *   RoleSessionName: string,
     *   PolicyArns?: PolicyDescriptorType[],
     *   Policy?: string,
     *   DurationSeconds?: int,
     *   Tags?: Tag[],
     *   TransitiveTagKeys?: string[],
     *   ExternalId?: string,
     *   SerialNumber?: string,
     *   TokenCode?: string,
     *   SourceIdentity?: string,
     *   @region?: string,
     * }|AssumeRoleRequest $input
     *
     * @throws MalformedPolicyDocumentException
     * @throws PackedPolicyTooLargeException
     * @throws RegionDisabledException
     * @throws ExpiredTokenException
     */
    public function assumeRole($input) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleResponse
    {
        $input = \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\AssumeRoleRequest::create($input);
        $response = $this->getResponse($input->request(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext(['operation' => 'AssumeRole', 'region' => $input->getRegion(), 'exceptionMapping' => ['MalformedPolicyDocument' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\MalformedPolicyDocumentException::class, 'PackedPolicyTooLarge' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\PackedPolicyTooLargeException::class, 'RegionDisabledException' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\RegionDisabledException::class, 'ExpiredTokenException' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\ExpiredTokenException::class]]));
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleResponse($response);
    }
    /**
     * Returns a set of temporary security credentials for users who have been authenticated in a mobile or web application
     * with a web identity provider. Example providers include the OAuth 2.0 providers Login with Amazon and Facebook, or
     * any OpenID Connect-compatible identity provider such as Google or Amazon Cognito federated identities.
     *
     * @see https://docs.aws.amazon.com/cognito/latest/developerguide/cognito-identity.html
     * @see https://docs.aws.amazon.com/STS/latest/APIReference/API_AssumeRoleWithWebIdentity.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sts-2011-06-15.html#assumerolewithwebidentity
     *
     * @param array{
     *   RoleArn: string,
     *   RoleSessionName: string,
     *   WebIdentityToken: string,
     *   ProviderId?: string,
     *   PolicyArns?: PolicyDescriptorType[],
     *   Policy?: string,
     *   DurationSeconds?: int,
     *   @region?: string,
     * }|AssumeRoleWithWebIdentityRequest $input
     *
     * @throws MalformedPolicyDocumentException
     * @throws PackedPolicyTooLargeException
     * @throws IDPRejectedClaimException
     * @throws IDPCommunicationErrorException
     * @throws InvalidIdentityTokenException
     * @throws ExpiredTokenException
     * @throws RegionDisabledException
     */
    public function assumeRoleWithWebIdentity($input) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleWithWebIdentityResponse
    {
        $input = \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\AssumeRoleWithWebIdentityRequest::create($input);
        $response = $this->getResponse($input->request(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext(['operation' => 'AssumeRoleWithWebIdentity', 'region' => $input->getRegion(), 'exceptionMapping' => ['MalformedPolicyDocument' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\MalformedPolicyDocumentException::class, 'PackedPolicyTooLarge' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\PackedPolicyTooLargeException::class, 'IDPRejectedClaim' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\IDPRejectedClaimException::class, 'IDPCommunicationError' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\IDPCommunicationErrorException::class, 'InvalidIdentityToken' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\InvalidIdentityTokenException::class, 'ExpiredTokenException' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\ExpiredTokenException::class, 'RegionDisabledException' => \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception\RegionDisabledException::class]]));
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\AssumeRoleWithWebIdentityResponse($response);
    }
    /**
     * Returns details about the IAM user or role whose credentials are used to call the operation.
     *
     * @see https://docs.aws.amazon.com/STS/latest/APIReference/API_GetCallerIdentity.html
     * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sts-2011-06-15.html#getcalleridentity
     *
     * @param array{
     *   @region?: string,
     * }|GetCallerIdentityRequest $input
     */
    public function getCallerIdentity($input = []) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\GetCallerIdentityResponse
    {
        $input = \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input\GetCallerIdentityRequest::create($input);
        $response = $this->getResponse($input->request(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext(['operation' => 'GetCallerIdentity', 'region' => $input->getRegion()]));
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Result\GetCallerIdentityResponse($response);
    }
    protected function getAwsErrorFactory() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\AwsErrorFactoryInterface
    {
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\AwsError\XmlAwsErrorFactory();
    }
    protected function getEndpointMetadata(?string $region) : array
    {
        if (null === $region) {
            return ['endpoint' => 'https://sts.amazonaws.com', 'signRegion' => 'us-east-1', 'signService' => 'sts', 'signVersions' => ['v4']];
        }
        switch ($region) {
            case 'cn-north-1':
            case 'cn-northwest-1':
                return ['endpoint' => "https://sts.{$region}.amazonaws.com.cn", 'signRegion' => $region, 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-east-1-fips':
                return ['endpoint' => 'https://sts-fips.us-east-1.amazonaws.com', 'signRegion' => 'us-east-1', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-east-2-fips':
                return ['endpoint' => 'https://sts-fips.us-east-2.amazonaws.com', 'signRegion' => 'us-east-2', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-west-1-fips':
                return ['endpoint' => 'https://sts-fips.us-west-1.amazonaws.com', 'signRegion' => 'us-west-1', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-west-2-fips':
                return ['endpoint' => 'https://sts-fips.us-west-2.amazonaws.com', 'signRegion' => 'us-west-2', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-gov-east-1-fips':
                return ['endpoint' => 'https://sts.us-gov-east-1.amazonaws.com', 'signRegion' => 'us-gov-east-1', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-gov-west-1-fips':
                return ['endpoint' => 'https://sts.us-gov-west-1.amazonaws.com', 'signRegion' => 'us-gov-west-1', 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-iso-east-1':
            case 'us-iso-west-1':
                return ['endpoint' => "https://sts.{$region}.c2s.ic.gov", 'signRegion' => $region, 'signService' => 'sts', 'signVersions' => ['v4']];
            case 'us-isob-east-1':
                return ['endpoint' => 'https://sts.us-isob-east-1.sc2s.sgov.gov', 'signRegion' => 'us-isob-east-1', 'signService' => 'sts', 'signVersions' => ['v4']];
        }
        return ['endpoint' => "https://sts.{$region}.amazonaws.com", 'signRegion' => $region, 'signService' => 'sts', 'signVersions' => ['v4']];
    }
    protected function getServiceCode() : string
    {
        @\trigger_error('Using the client with an old version of Core is deprecated. Run "composer update async-aws/core".', \E_USER_DEPRECATED);
        return 'sts';
    }
    protected function getSignatureScopeName() : string
    {
        @\trigger_error('Using the client with an old version of Core is deprecated. Run "composer update async-aws/core".', \E_USER_DEPRECATED);
        return 'sts';
    }
    protected function getSignatureVersion() : string
    {
        @\trigger_error('Using the client with an old version of Core is deprecated. Run "composer update async-aws/core".', \E_USER_DEPRECATED);
        return 'v4';
    }
}
