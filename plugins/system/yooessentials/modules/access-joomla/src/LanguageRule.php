<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Access\Joomla;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\LanguageHelper;
use ZOOlanders\YOOessentials\Access\AbstractRule;

class LanguageRule extends AbstractRule
{
    public function group(): string
    {
        return 'site';
    }

    public function name(): string
    {
        return 'Language';
    }

    public function namespace(): string
    {
        return 'yooessentials_access_language';
    }

    public function description(): string
    {
        return 'Validates against the site language.';
    }

    public function resolve($props, $node): bool
    {
        if (!isset($props->languages)) {
            throw new \RuntimeException('Not Valid Input');
        }

        $selection = (array) $props->languages;
        $activeLanguage = str_replace('_', '-', Factory::getLanguage()->get('tag'));

        return in_array($activeLanguage, $selection);
    }

    public function fields(): array
    {
        return [
            'languages' => [
                'label' => 'Selection',
                'type' => 'select',
                'source' => true,
                'description' => 'The languages that the site current language must match. Use the shift or ctrl/cmd key to select multiple entries.',
                'attrs' => [
                    'multiple' => true,
                    'class' => 'uk-height-small uk-resize-vertical'
                ],
                'options' => $this->getAvailableLanguages()
            ]
        ];
    }

    protected function getAvailableLanguages(): array
    {
        static $availableLanguages = [];

        if (empty($availableLanguages)) {
            $availableLanguages = array_flip(array_map(function ($language) {
                return $language['name'];
            }, LanguageHelper::getKnownLanguages(JPATH_SITE)));
        }

        return $availableLanguages;
    }
}
