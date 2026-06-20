<?php

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;

class JFormFieldCache extends FormField {

    protected $type = 'Cache';

    public function getInput() {
        return '
        <button id="wk-clear-cache" class="btn btn-secondary">Clear Cache</button>
        <span class="wk-cache-size" style="padding-left: 15px;"></span>

        <script>
        jQuery(function($) {

            var getCache = function() {
                $.get("index.php?option=com_widgetkit&p=/cache/get", function(data) {
                    $(".wk-cache-size").text(JSON.parse(data));
                });
            }

            $("#wk-clear-cache").on("click", function(e) {

                e.preventDefault();

                $(".wk-cache-size").text("Clearing cache...");
                $.get("index.php?option=com_widgetkit&p=/cache/clear", getCache);
            });

            getCache();

        });
        </script>';
    }

}
