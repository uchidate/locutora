<?php

namespace ZOOlanders\YOOessentials\Vendor;

if (\PHP_VERSION_ID < 80000 && \extension_loaded('tokenizer')) {
    class PhpToken extends \ZOOlanders\YOOessentials\Vendor\Symfony\Polyfill\Php80\PhpToken
    {
    }
}
