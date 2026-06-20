<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form;

use YOOtheme\Arr;
use YOOtheme\Builder;
use YOOtheme\Config;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Form\Actions\Action;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionRequest;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\Util;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validator;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Cache\CacheInterface;

class FormService
{
    /** @var bool */
    protected $enabled = true;

    /**
     * @var array
     */
    public $actions = [];

    /**
     * @var callable
     */
    protected $loader;

    /**
     * @var FormConfigCache
     */
    protected $oldCache;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var Builder
     */
    protected $builder;

    public function __construct(Config $config, Builder $builder, CacheInterface $cache)
    {
        $this->loader = [
            $config,
            'loadFile'
        ];

        $this->builder = $builder;
        $this->cache = $cache;
        $this->oldCache = new FormConfigCache('form');

        $builder->addTransform('render', new FormTransform($this, $builder));
    }

    public function isFormNode($node): bool
    {
        return ($node->props['yooessentials_form']->state ?? false) && ($node->formid ?? false);
    }

    public function isFormWrapNode($node): bool
    {
        return $node->type === 'yooessentials_form';
    }

    public function loadForm(string $id): Form
    {
        $config = $this->loadConfig($id);

        return new Form($id, $config);
    }

    /**
     * @param  string  $id
     * @return object|void|null
     */
    public function loadFormNode(string $id, array $config)
    {
        // pass through the config so in the first rendering there is the basic config available
        return $this->builder->load(json_encode([
            'id' => $id,
            'type' => 'yooessentials_form',
            'yooessentials_form' => $config
        ]), ['context' => 'render']);
    }

    /**
     * Load the Config for a form
     * @param  string  $formId
     * @return array
     */
    public function loadConfig(string $formId): array
    {
        $key = $this->cacheKey($formId);

        $config = $this->cache->get($key, function () use ($formId) {

            // Read the old config files
            $oldConfig = $this->loadOldConfig($formId);

            // TODO: Clear the old config files
            // $this->oldCache->clear(sprintf('%s.php', $formId));

            return $oldConfig;
        });

        if (!is_array($config)) {
            $this->cache->delete($key);

            return [];
        }

        if (empty($config)) {
            $this->cache->delete($key);

            return $this->loadOldConfig($formId);
        }

        return $config;
    }

    /**
     * Loads the config from the old .php files in cache
     *
     * @param string $formId
     * @return array
     */
    private function loadOldConfig(string $formId): array
    {
        $key = sprintf('%s.php', $formId);
        $cached = $this->oldCache->resolve($key);

        if (!is_file($cached)) {
            return [];
        }

        $config = include $cached;

        // Something weird here happened, let's clear the cache and return an empty array
        if (!is_array($config)) {
            $this->oldCache->clear($key);

            return [];
        }

        return $config;
    }

    /**
     * Save config for a form
     * @param  string  $id
     * @param  array  $config
     */
    public function saveConfig(string $id, array $config): void
    {
        $key = $this->cacheKey($id);
        $value = json_decode(json_encode($config), true);

        if (!is_array($value)) {
            return;
        }

        // Delete old version and set it fresh
        $this->cache->delete($key);
        $this->cache->get($key, function () use ($value) {
            return $value;
        });
    }

    /**
     * Save config for a form in the old cache
     * @param  string  $id
     * @param  array  $config
     */
    public function saveOldConfig(string $id, array $config): void
    {
        $key = sprintf('%s.php', $id);
        $value = json_decode(json_encode($config), true);

        if (!is_array($value)) {
            return;
        }

        $value = Util::compileValue($value);

        $this->oldCache->set($key, "<?php\n\nreturn {$value};\n");
    }

    public function addAction(Action $action): self
    {
        if (!isset($this->actions[$action->name()])) {
            $this->actions[$action->name()] = $action;
        }

        return $this;
    }

    public function actions(): array
    {
        return $this->actions;
    }

    public function getControlType(array $control): ?object
    {
        return $this->builder->types[$control['type']] ?? null;
    }

    public function getControlList($node): array
    {
        return array_reduce($node->children, function ($carry, $node) {
            $type = $this->builder->types[$node->type];

            if (!$type) {
                return $carry;
            }

            $isFormElement = Str::startsWith($node->type, 'yooessentials_form_');

            if ($isFormElement and $type->data['controls'] ?? false) {
                $props = Util\Prop::filterByPrefix((array) $node->props, 'control_');
                $carry[] = [
                    'name' => $props['name'],
                    'type' => $node->type
                ];
            }

            if ($node->children ?? false) {
                $carry = array_merge($carry, $this->getControlList($node));
            }

            return $carry;
        }, []);
    }

    public function validateElements(FormSubmissionRequest $submission): array
    {
        $errors = [];

        foreach ($submission->config()['controls'] ?? [] as $control) {
            $type = $this->getControlType($control);

            if (!$type) {
                continue;
            }

            $validation = $type->data['validation'] ?? null;
            if (!is_callable($validation)) {
                continue;
            }

            $name = $control['name'];
            $props = $control['props'];
            $label = $props['label'] ?? $name;
            $value = $submission->data($name);
            $control['value'] = $value;

            $validator = new Validator();
            $validator->setName($label);

            try {
                $validation($control, $validator, $submission);
                $validator->check($value);
            } catch (ValidationException $exception) {
                if ($message = $props['error_message'] ?? false) {
                    $message = str_replace('{fieldlabel}', $label ?: $name, $message);
                    $exception->updateTemplate($message);
                }

                $errors[$name] = Arr::wrap($exception->getMessage());
            }
        }

        return $errors;
    }

    public function processElementSubmission(FormSubmissionRequest $submission, FormSubmissionResponse $submissionResponse): void
    {
        foreach ($submission->form()->config()['controls'] ?? [] as $control) {
            $type = $this->getControlType($control);

            if ($type && is_callable($type->data['submission'] ?? null)) {
                $type->data['submission']($control, $submission, $submissionResponse);
            }
        }
    }

    private function cacheKey(string $formId): string
    {
        return 'form.config.' . $formId;
    }

    public static function parseTags(string $content, array $data): string
    {
        foreach ($data as $dataField => $value) {
            if (is_null($value)) {
                continue;
            }

            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            // replace breaklines with <br>
            $value = nl2br($value);

            $tag = '{' . $dataField . '}';
            $content = str_replace($tag, $value, $content);
        }

        // remove any left out tag, unless is a valid json
        $content = preg_replace_callback('/{[^}\n]*}/', function ($matches) {
            return json_decode($matches[0]) ? $matches[0] : '';
        }, $content);

        return $content;
    }
}
