<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

use const FTP_USEPASVADDRESS;
class FtpConnectionProvider implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\ConnectionProvider
{
    /**
     * @return resource
     *
     * @throws FtpConnectionException
     */
    public function createConnection(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $options)
    {
        $connection = $this->createConnectionResource($options->host(), $options->port(), $options->timeout(), $options->ssl());
        try {
            $this->authenticate($options, $connection);
            $this->enableUtf8Mode($options, $connection);
            $this->ignorePassiveAddress($options, $connection);
            $this->makeConnectionPassive($options, $connection);
        } catch (\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionException $exception) {
            \ftp_close($connection);
            throw $exception;
        }
        return $connection;
    }
    /**
     * @return resource
     */
    private function createConnectionResource(string $host, int $port, int $timeout, bool $ssl)
    {
        $connection = $ssl ? @\ftp_ssl_connect($host, $port, $timeout) : @\ftp_connect($host, $port, $timeout);
        if ($connection === \false) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToConnectToFtpHost::forHost($host, $port, $ssl);
        }
        return $connection;
    }
    /**
     * @param resource $connection
     */
    private function authenticate(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $options, $connection) : void
    {
        if (!@\ftp_login($connection, $options->username(), $options->password())) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToAuthenticate();
        }
    }
    /**
     * @param resource $connection
     */
    private function enableUtf8Mode(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $options, $connection) : void
    {
        if (!$options->utf8()) {
            return;
        }
        $response = \ftp_raw($connection, "OPTS UTF8 ON");
        if (!\in_array(\substr($response[0], 0, 3), ['200', '202'])) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToEnableUtf8Mode('Could not set UTF-8 mode for connection: ' . $options->host() . '::' . $options->port());
        }
    }
    /**
     * @param resource $connection
     */
    private function ignorePassiveAddress(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $options, $connection) : void
    {
        $ignorePassiveAddress = $options->ignorePassiveAddress();
        if (!\is_bool($ignorePassiveAddress) || !\defined('FTP_USEPASVADDRESS')) {
            return;
        }
        if (!\ftp_set_option($connection, \FTP_USEPASVADDRESS, !$ignorePassiveAddress)) {
            throw \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToSetFtpOption::whileSettingOption('FTP_USEPASVADDRESS');
        }
    }
    /**
     * @param resource $connection
     */
    private function makeConnectionPassive(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionOptions $options, $connection) : void
    {
        if (!\ftp_pasv($connection, $options->passive())) {
            throw new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToMakeConnectionPassive('Could not set passive mode for connection: ' . $options->host() . '::' . $options->port());
        }
    }
}
