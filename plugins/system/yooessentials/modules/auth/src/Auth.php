<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Auth;

use function YOOtheme\app;
use YOOtheme\Encrypter;
use ZOOlanders\YOOessentials\Config\ConfigEncrypter;
use ZOOlanders\YOOessentials\Data;

class Auth extends Data
{
    public const TYPE_OAUTH = 'oauth';
    public const TYPE_APIKEY = 'apikey';

    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * @var array
     */
    protected $encryptableKeys = [];

    /**
     * @var AuthDriver|null
     */
    protected $driver = null;

    public function __construct(array $data)
    {
        /** @var ConfigEncrypter */
        $this->encrypter = app(ConfigEncrypter::class);

        parent::__construct($data);
    }

    public function encryptableKeys(): array
    {
        return $this->encryptableKeys;
    }

    public function setEncryptableKeys(array $keys): Auth
    {
        $this->encryptableKeys = $keys;

        return $this;
    }

    public function addEncryptableKeys(array $keys): Auth
    {
        $this->encryptableKeys = array_unique(array_merge($this->encryptableKeys, $keys));

        return $this;
    }

    public function withEncryptedKeys(): self
    {
        $auth = clone ($this);

        foreach ($this->encryptableKeys() as $key) {
            if (empty($auth->{$key}) || $this->encrypter->decrypt($auth->{$key})) {
                continue;
            }

            $auth->{$key} = $this->encrypter->encrypt($auth->{$key});
        }

        return $auth;
    }

    public function withDecryptedKeys(): self
    {
        $auth = clone ($this);

        foreach ($this->encryptableKeys() as $key) {
            if (isset($auth->{$key}) && $decryptedValue = $this->encrypter->decrypt($auth->{$key})) {
                $auth->{$key} = $decryptedValue;
            }
        }

        return $auth;
    }

    public function forDriver(AuthDriver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function driver(): ?AuthDriver
    {
        return $this->driver;
    }

    public function driverName(): string
    {
        return $this->driver() ? $this->driver()->name() : $this->data['driver'] ?? '';
    }
}
