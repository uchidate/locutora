<?php

/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */
namespace ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube;

class LocalizedProperty extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
{
    protected $collection_key = 'localized';
    /**
     * @var string
     */
    public $default;
    protected $defaultLanguageType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LanguageTag::class;
    protected $defaultLanguageDataType = '';
    protected $localizedType = \ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LocalizedString::class;
    protected $localizedDataType = 'array';
    /**
     * @param string
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }
    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }
    /**
     * @param LanguageTag
     */
    public function setDefaultLanguage(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LanguageTag $defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
    }
    /**
     * @return LanguageTag
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }
    /**
     * @param LocalizedString[]
     */
    public function setLocalized($localized)
    {
        $this->localized = $localized;
    }
    /**
     * @return LocalizedString[]
     */
    public function getLocalized()
    {
        return $this->localized;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\ZOOlanders\YOOessentials\Vendor\Google\Service\YouTube\LocalizedProperty::class, 'ZOOlanders\\YOOessentials\\Vendor\\Google_Service_YouTube_LocalizedProperty');
