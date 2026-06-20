<?php
/**
 * @package   Essentials YOOtheme Pro 1.9.3 build 0125.1555
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

namespace ZOOlanders\YOOessentials\Source;

use function YOOtheme\app;
use YOOtheme\Builder\Source;
use YOOtheme\Event;
use YOOtheme\GraphQL\Type\Definition\ObjectType;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Config;
use ZOOlanders\YOOessentials\Feature;
use ZOOlanders\YOOessentials\Source\GraphQL\TypeInterface;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class SourceService
{
    public const SOURCES_CONFIG_KEY = 'source.sources';

    /** @var bool */
    protected $enabled = true;

    /** @var array */
    protected $types = [];

    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function sourceConfigs(): array
    {
        return $this->config->get(self::SOURCES_CONFIG_KEY, []);
    }

    public static function resolve($item, $args, $context, $info): array
    {
        /** @var SourceService $sourceManager */
        $sourceManager = app(SourceService::class);

        try {
            $source = $sourceManager->source($args['source_id'], $args);

            return $source->resolve($args);
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'action' => 'source-query-resolve',
                'args' => $args,
                'error' => $e->getMessage(),
                'exception' => $e
            ]);

            return [];
        }
    }

    public function registerSources(Source $source): void
    {
        foreach ($this->sourceTypes() as $sourceType => $sourceClass) {
            $sources = $this->sources($sourceType);

            // Group the types by type + name to avoid re-registering the same type twice
            // Side advantage is to have better error handling and reporting
            $types = [];
            foreach ($sources as $config) {
                try {
                    $sourceTypeInstance = $this->createSource($sourceType, $config);
                    /** @var TypeInterface $type */
                    foreach ($sourceTypeInstance->types() as $type) {
                        $types[$type->type()][$type->name()] = $type;
                    }
                } catch (\Exception $e) {
                    Event::emit('yooessentials.error', [
                        'addon' => 'source',
                        'provider' => $sourceType,
                        'error' => 'Error creating source with config: ' . json_encode($config),
                        'exception' => $e,
                        'exceptionMessage' => $e->getMessage()
                    ]);
                }
            }

            // Add Object Type
            foreach (($types[TypeInterface::TYPE_OBJECT] ?? []) as $name => $type) {
                try {
                    $source->objectType($name, $type->config());
                } catch (\Exception $e) {
                    Event::emit('yooessentials.error', [
                        'addon' => 'source',
                        'provider' => $sourceType,
                        'error' => 'Error creating ' . $type->type() . ' Type ' . $type->name() . ' with config ' . json_encode($type->config()),
                        'exception' => $e,
                        'exceptionMessage' => $e->getMessage()
                    ]);
                }
            }

            if (Feature::canUse(Feature::SOURCE_INPUT_TYPE)) {
                // Add Input Types
                foreach (($types[TypeInterface::TYPE_INPUT] ?? []) as $type) {
                    try {
                        $source->inputType($type->name(), $type->config());
                    } catch (\Exception $e) {
                        Event::emit('yooessentials.error', [
                            'addon' => 'source',
                            'provider' => $sourceType,
                            'error' => 'Error creating Input ' . $type->type() . ' Type ' . $type->name() . ' with config ' . json_encode($type->config()),
                            'exception' => $e,
                            'exceptionMessage' => $e->getMessage()
                        ]);
                    }
                }
            }

            // Add Query Types
            foreach (($types[TypeInterface::TYPE_QUERY] ?? []) as $type) {
                try {
                    $source->queryType($type->config());
                } catch (\Exception $e) {
                    Event::emit('yooessentials.error', [
                        'addon' => 'source',
                        'provider' => $sourceType,
                        'error' => 'Error creating ' . $type->type() . ' Type ' . $type->name() . ' with config ' . json_encode($type->config()),
                        'exception' => $e,
                        'exceptionMessage' => $e->getMessage()
                    ]);
                }
            }
        }
    }

    public function setSources(array $sources): self
    {
        $this->config->set(self::SOURCES_CONFIG_KEY, $sources);

        return $this;
    }

    public function addSourceType(string $sourceType, string $sourceClass): self
    {
        if (!isset($this->types[$sourceType])) {
            $this->types[$sourceType] = $sourceClass;
        }

        return $this;
    }

    public function source(string $id, array $config = []): SourceInterface
    {
        $source = array_filter($this->sourceConfigs(), function ($source) use ($id) {
            return (string) ($source['id'] ?? '') === $id;
        });

        if (empty($source)) {
            throw new \Exception('Source Not Found: ' . $id . '. Existing sources: ' . json_encode($this->sourceConfigs()));
        }

        $source = array_shift($source);

        return $this->createSource($source['provider'], array_merge($source, $config));
    }

    /**
     * @return array[]|array
     */
    public function sources(?string $name = null): array
    {
        if (!$name) {
            return $this->sourceConfigs();
        }

        return array_filter($this->sourceConfigs(), function (array $source) use ($name) {
            return ($source['sourceType'] ?? $source['provider'] ?? '') === $name;
        });
    }

    /**
     * @return string[]|array
     */
    public function sourceTypes(): array
    {
        return $this->types;
    }

    public function createSource(string $name, array $config = []): ?SourceInterface
    {
        $class = $this->types[$name] ?? null;
        if (!$class) {
            return null;
        }

        /** @var SourceInterface $class */
        $class = app($class);

        return $class->bind($config);
    }

    public function setObjectType(Source $source, string $name, array $config): void
    {
        $type = new ObjectType([
            'name' => $name,
            'resolveField' => [$source, 'resolveField'],
        ]);

        $type->config = $config;
        $source->setType($type);
    }

    public static function encodeField(string $field): string
    {
        // replaces unicode and dashes with lower dash
        $field = preg_replace('/%.{2}|-/', '_', rawurlencode($field));

        // move edge dashes
        $field = preg_replace('/^_|_#/', '', $field);

        // dots => _
        $field = preg_replace('/\./', '_', $field);

        // lowercase
        $field = Str::lower($field);

        // enforce string
        if (is_numeric($field)) {
            $field = "_{$field}";
        }

        // no empty values allowed
        if (empty($field)) {
            $field = '_';
        }

        // enforce starting with string
        if (is_numeric(substr($field, 0, 1))) {
            $field = "_$field";
        }

        return $field;
    }
}
