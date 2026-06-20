<?php

namespace ZOOlanders\YOOessentials\Vendor;

if (!\function_exists('ZOOlanders\\YOOessentials\\Vendor\\dd')) {
    function dd()
    {
        $args = \func_get_args();
        \call_user_func_array('ZOOlanders\YOOessentials\Vendor\dump', $args);
        die;
    }
}
if (!\function_exists('ZOOlanders\\YOOessentials\\Vendor\\d')) {
    function d()
    {
        $args = \func_get_args();
        \call_user_func_array('ZOOlanders\YOOessentials\Vendor\dump', $args);
    }
}
