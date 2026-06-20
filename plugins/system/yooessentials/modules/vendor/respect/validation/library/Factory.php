<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\Respect\Validation;

use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ComponentException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\InvalidClassException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\Formatter;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\ParameterStringifier;
use ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\Stringifier\KeepOriginalStringName;
use function lcfirst;
use function sprintf;
use function trim;
use function ucfirst;
/**
 * Factory of objects.
 *
 * @author Augusto Pascutti <augusto@phpsp.org.br>
 * @author Henrique Moody <henriquemoody@gmail.com>
 */
final class Factory
{
    /**
     * Default instance of the Factory.
     *
     * @var Factory
     */
    private static $defaultInstance;
    /**
     * @var string[]
     */
    private $rulesNamespaces = ['ZOOlanders\\YOOessentials\\Vendor\\Respect\\Validation\\Rules'];
    /**
     * @var string[]
     */
    private $exceptionsNamespaces = ['ZOOlanders\\YOOessentials\\Vendor\\Respect\\Validation\\Exceptions'];
    /**
     * @var callable
     */
    private $translator = 'strval';
    /**
     * @var ParameterStringifier
     */
    private $parameterStringifier;
    public function __construct()
    {
        $this->parameterStringifier = new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\Stringifier\KeepOriginalStringName();
    }
    public function withRuleNamespace(string $rulesNamespace) : self
    {
        $clone = clone $this;
        $clone->rulesNamespaces[] = \trim($rulesNamespace, '\\');
        return $clone;
    }
    public function withExceptionNamespace(string $exceptionsNamespace) : self
    {
        $clone = clone $this;
        $clone->exceptionsNamespaces[] = \trim($exceptionsNamespace, '\\');
        return $clone;
    }
    public function withTranslator(callable $translator) : self
    {
        $clone = clone $this;
        $clone->translator = $translator;
        return $clone;
    }
    public function withParameterStringifier(\ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\ParameterStringifier $parameterStringifier) : self
    {
        $clone = clone $this;
        $clone->parameterStringifier = $parameterStringifier;
        return $clone;
    }
    /**
     * Define the default instance of the Factory.
     */
    public static function setDefaultInstance(self $defaultInstance) : void
    {
        self::$defaultInstance = $defaultInstance;
    }
    /**
     * Returns the default instance of the Factory.
     */
    public static function getDefaultInstance() : self
    {
        if (self::$defaultInstance === null) {
            self::$defaultInstance = new self();
        }
        return self::$defaultInstance;
    }
    /**
     * Creates a rule.
     *
     * @param mixed[] $arguments
     *
     * @throws ComponentException
     */
    public function rule(string $ruleName, array $arguments = []) : \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validatable
    {
        foreach ($this->rulesNamespaces as $namespace) {
            try {
                /** @var class-string<Validatable> $name */
                $name = $namespace . '\\' . \ucfirst($ruleName);
                /** @var Validatable $rule */
                $rule = $this->createReflectionClass($name, \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validatable::class)->newInstanceArgs($arguments);
                return $rule;
            } catch (\ReflectionException $exception) {
                continue;
            }
        }
        throw new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ComponentException(\sprintf('"%s" is not a valid rule name', $ruleName));
    }
    /**
     * Creates an exception.
     *
     * @param mixed $input
     * @param mixed[] $extraParams
     *
     * @throws ComponentException
     */
    public function exception(\ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validatable $validatable, $input, array $extraParams = []) : \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException
    {
        $formatter = new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\Formatter($this->translator, $this->parameterStringifier);
        $reflection = new \ReflectionObject($validatable);
        $ruleName = $reflection->getShortName();
        $params = ['input' => $input] + $extraParams + $this->extractPropertiesValues($validatable, $reflection);
        $id = \lcfirst($ruleName);
        if ($validatable->getName() !== null) {
            $id = $params['name'] = $validatable->getName();
        }
        foreach ($this->exceptionsNamespaces as $namespace) {
            try {
                /** @var class-string<ValidationException> $exceptionName */
                $exceptionName = $namespace . '\\' . $ruleName . 'Exception';
                return $this->createValidationException($exceptionName, $id, $input, $params, $formatter);
            } catch (\ReflectionException $exception) {
                continue;
            }
        }
        return new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException($input, $id, $params, $formatter);
    }
    /**
     * Creates a reflection based on class name.
     *
     * @param class-string $name
     * @param class-string $parentName
     *
     * @throws InvalidClassException
     * @throws ReflectionException
     */
    private function createReflectionClass(string $name, string $parentName) : \ReflectionClass
    {
        $reflection = new \ReflectionClass($name);
        if (!$reflection->isSubclassOf($parentName) && $parentName !== $name) {
            throw new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\InvalidClassException(\sprintf('"%s" must be an instance of "%s"', $name, $parentName));
        }
        if (!$reflection->isInstantiable()) {
            throw new \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\InvalidClassException(\sprintf('"%s" must be instantiable', $name));
        }
        return $reflection;
    }
    /**
     * Creates a Validation exception.
     *
     * @param class-string<ValidationException> $exceptionName
     *
     * @param mixed $input
     * @param mixed[] $params
     *
     * @throws InvalidClassException
     * @throws ReflectionException
     */
    private function createValidationException(string $exceptionName, string $id, $input, array $params, \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Message\Formatter $formatter) : \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException
    {
        /** @var ValidationException $exception */
        $exception = $this->createReflectionClass($exceptionName, \ZOOlanders\YOOessentials\Vendor\Respect\Validation\Exceptions\ValidationException::class)->newInstance($input, $id, $params, $formatter);
        if (isset($params['template'])) {
            $exception->updateTemplate($params['template']);
        }
        return $exception;
    }
    /**
     * @return mixed[]
     */
    private function extractPropertiesValues(\ZOOlanders\YOOessentials\Vendor\Respect\Validation\Validatable $validatable, \ReflectionClass $reflection) : array
    {
        $values = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(\true);
            $propertyValue = $property->getValue($validatable);
            if ($propertyValue === null) {
                continue;
            }
            $values[$property->getName()] = $propertyValue;
        }
        $parentReflection = $reflection->getParentClass();
        if ($parentReflection !== \false) {
            return $values + $this->extractPropertiesValues($validatable, $parentReflection);
        }
        return $values;
    }
}
