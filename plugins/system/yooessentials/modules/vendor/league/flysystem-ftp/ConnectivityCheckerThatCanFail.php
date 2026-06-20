<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

class ConnectivityCheckerThatCanFail implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\ConnectivityChecker
{
    /**
     * @var bool
     */
    private $failNextCall = \false;
    /**
     * @var ConnectivityChecker
     */
    private $connectivityChecker;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\ConnectivityChecker $connectivityChecker)
    {
        $this->connectivityChecker = $connectivityChecker;
    }
    public function failNextCall() : void
    {
        $this->failNextCall = \true;
    }
    /**
     * @inheritDoc
     */
    public function isConnected($connection) : bool
    {
        if ($this->failNextCall) {
            $this->failNextCall = \false;
            return \false;
        }
        return $this->connectivityChecker->isConnected($connection);
    }
}
