<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Form\Actions;

use function YOOtheme\app;
use YOOtheme\Event;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Access\AccessTransform;
use ZOOlanders\YOOessentials\Dynamic\DynamicResolver;
use ZOOlanders\YOOessentials\Form\FormService;
use ZOOlanders\YOOessentials\Form\Http\FormSubmissionResponse;
use ZOOlanders\YOOessentials\HasLocalConfig;

class ActionInstance
{
    use HasLocalConfig;

    /** @var string */
    private $id;

    /** @var Action */
    private $action;

    /** @var array */
    private $configSource;

    /** @var AccessTransform */
    private $accessTransform;

    public function __construct(Action $action, array $config, ?string $id = null)
    {
        // todo: move to UI with a 'ai_' prefix
        $this->id = $id ?? uniqid();

        $this->action = $action;
        $this->configSource = $config;
        $this->accessTransform = app(AccessTransform::class);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function action(): Action
    {
        return $this->action;
    }

    public function shouldRun(): bool
    {
        $status = $this->config('status') ?? '';

        if ($status === 'disabled') {
            return false;
        }

        return call_user_func($this->accessTransform, (object) $this->configSource);
    }

    public function __invoke(FormSubmissionResponse $response, callable $next): FormSubmissionResponse
    {
        $this->config = $this->resolveConfig($response->submission()->data());

        if (!$this->shouldRun()) {
            return $next($response->withDatalog([
                "skipped-action:{$this->action()->name()}_{$this->id()}" => $this->config()
            ]));
        }

        // This is not ideal, the invocation should have `Response` and `Config` in the __invoke method,
        // and not have to take care of Local configuration
        // However this would be a breaking change, so this is the only way I can see to make this work.
        $config = array_merge(['action_id' => $this->id()], $this->config());

        try {
            return $this->action()->setConfig($config)($response, $next);
        } catch (\Exception $e) {
            $actionName = (new \ReflectionClass($this->action()))->getShortName();

            throw new \RuntimeException("$actionName Error: " . $e->getMessage());
        }
    }

    public function resolveConfig(array $data = []): array
    {
        $config = $this->configSource;
        $config = self::resolveConfigDynamicFields($config, $data);
        $config = self::resolveConfigPlaceholders($config, $data);

        return $config['props'];
    }

    private static function resolveConfigPlaceholders(array $config, array $data): array
    {
        foreach ($config as $name => &$field) {
            // skip dynamic configuration
            if ($name === 'source_extended') {
                continue;
            }

            if (is_string($field)) {
                $field = FormService::parseTags($field, $data);
            }

            if (is_object($field) || is_array($field)) {
                $field = self::resolveConfigPlaceholders((array) $field, $data);
            }
        }

        return $config;
    }

    private static function resolveConfigDynamicFields(array $config, array $data): array
    {
        // map data keys to camelCase as expected by gql
        foreach ($data as $name => $val) {
            unset($data[$name]);
            $data[Str::camelCase($name)] = $val;
        }

        if (isset($config['source_extended'])) {
            $resolved = (array) self::resolveDynamicContent($config, ['submissionData' => $data]);
            unset($resolved['source_extended']);

            $config = $resolved;
        }

        // resolve nested
        foreach ($config as $name => &$field) {
            if (is_object($field) || is_array($field)) {
                $field = self::resolveConfigDynamicFields((array) $field, $data);
            }
        }

        return $config;
    }

    private static function resolveDynamicContent($node, array $params = []): object
    {
        $node = self::prepareNode($node);

        /** @var DynamicResolver $dynamicResolver */
        $dynamicResolver = app(DynamicResolver::class);

        Event::on('yooessentials.source.query', function ($node) use ($params) {
            $query = 'yooessentials_form_query';

            if (isset($params['submissionData']) && ($node->source->query->name ?? '') === $query) {
                return [
                    'data' => [$query => $params['submissionData']]
                ];
            }
        });

        return $dynamicResolver->resolveProps($node, $params);
    }

    private static function prepareNode($node): object
    {
        $node = (object) json_decode(json_encode($node), false);
        $node->props = (array) ($node->props ?? []);

        return $node;
    }
}
