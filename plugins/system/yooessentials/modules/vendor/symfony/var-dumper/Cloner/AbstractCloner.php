<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\ClonerInterface
{
    public static $defaultCasters = ['__PHP_Incomplete_Class' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\Caster', 'castPhpIncompleteClass'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\CutStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\CutArrayStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castCutArray'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ConstStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\EnumStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castEnum'], 'Fiber' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\FiberCaster', 'castFiber'], 'Closure' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClosure'], 'Generator' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castZendExtension'], 'ZOOlanders\\YOOessentials\\Vendor\\Doctrine\\Common\\Persistence\\ObjectManager' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Doctrine\\Common\\Proxy\\Proxy' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castCommonProxy'], 'ZOOlanders\\YOOessentials\\Vendor\\Doctrine\\ORM\\Proxy\\Proxy' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castOrmProxy'], 'ZOOlanders\\YOOessentials\\Vendor\\Doctrine\\ORM\\PersistentCollection' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castPersistentCollection'], 'ZOOlanders\\YOOessentials\\Vendor\\Doctrine\\Persistence\\ObjectManager' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'DOMException' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castException'], 'DOMStringList' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNameList' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMImplementation' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNode' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocument'], 'DOMNodeList' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMCharacterData' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castAttr'], 'DOMElement' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castElement'], 'DOMText' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castText'], 'DOMTypeinfo' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castTypeinfo'], 'DOMDomError' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDomError'], 'DOMLocator' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLocator'], 'DOMDocumentType' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNotation'], 'DOMEntity' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castXPath'], 'XMLReader' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castErrorException'], 'Exception' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castException'], 'Error' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castError'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Bridge\\Monolog\\Logger' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\AmpHttpClient' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\CurlHttpClient' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\NativeHttpClient' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\Response\\AmpResponse' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\Response\\CurlResponse' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpClient\\Response\\NativeResponse' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\HttpFoundation\\Request' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castRequest'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\Uid\\Ulid' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castUlid'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\Uid\\Uuid' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castUuid'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Exception\\ThrowingCasterException' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castThrowingCasterException'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\TraceStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castTraceStub'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\FrameStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castFrameStub'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Cloner\\AbstractCloner' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\ErrorHandler\\Exception\\SilencedErrorContext' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castSilencedErrorContext'], 'ZOOlanders\\YOOessentials\\Vendor\\Imagine\\Image\\ImageInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ImagineCaster', 'castImage'], 'ZOOlanders\\YOOessentials\\Vendor\\Ramsey\\Uuid\\UuidInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\UuidCaster', 'castRamseyUuid'], 'ZOOlanders\\YOOessentials\\Vendor\\ProxyManager\\Proxy\\ProxyInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\PHPUnit\\Framework\\MockObject\\MockObject' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\PHPUnit\\Framework\\MockObject\\Stub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Prophecy\\Prophecy\\ProphecySubjectInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ZOOlanders\\YOOessentials\\Vendor\\Mockery\\MockInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'PDO' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdo'], 'PDOStatement' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileInfo'], 'SplFileObject' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileObject'], 'SplHeap' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'SplObjectStorage' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'OuterIterator' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castOuterIterator'], 'WeakReference' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castWeakReference'], 'Redis' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedis'], 'RedisArray' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castDateTime'], 'DateInterval' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castInterval'], 'DateTimeZone' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castTimeZone'], 'DatePeriod' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castPeriod'], 'GMP' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\GmpCaster', 'castGmp'], 'MessageFormatter' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\MemcachedCaster', 'castMemcached'], 'ZOOlanders\\YOOessentials\\Vendor\\Ds\\Collection' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castCollection'], 'ZOOlanders\\YOOessentials\\Vendor\\Ds\\Map' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castMap'], 'ZOOlanders\\YOOessentials\\Vendor\\Ds\\Pair' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPair'], 'ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DsPairStub' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPairStub'], 'mysqli_driver' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\MysqliCaster', 'castMysqliDriver'], 'CurlHandle' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':curl' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':dba' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], ':dba persistent' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], 'GdImage' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':gd' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':mysql link' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castMysqlLink'], ':pgsql large object' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLargeObject'], ':pgsql link' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql link persistent' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql result' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castResult'], ':process' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castProcess'], ':stream' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], 'OpenSSLCertificate' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':OpenSSL X.509' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':persistent stream' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], ':stream-context' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], ':xml' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], 'RdKafka' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castRdKafka'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Conf' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castConf'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\KafkaConsumer' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castKafkaConsumer'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Metadata\\Broker' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castBrokerMetadata'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Metadata\\Collection' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castCollectionMetadata'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Metadata\\Partition' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castPartitionMetadata'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Metadata\\Topic' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicMetadata'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Message' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castMessage'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\Topic' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopic'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\TopicPartition' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicPartition'], 'ZOOlanders\\YOOessentials\\Vendor\\RdKafka\\TopicConf' => ['ZOOlanders\\YOOessentials\\Vendor\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicConf']];
    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $minDepth = 1;
    /**
     * @var array<string, list<callable>>
     */
    private $casters = [];
    /**
     * @var callable|null
     */
    private $prevErrorHandler;
    private $classInfo = [];
    private $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(array $casters = null)
    {
        if (null === $casters) {
            $casters = static::$defaultCasters;
        }
        $this->addCasters($casters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters(array $casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     */
    public function setMaxItems(int $maxItems)
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     */
    public function setMaxString(int $maxString)
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     */
    public function setMinDepth(int $minDepth)
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param mixed $var    Any PHP variable
     * @param int   $filter A bit field of Caster::EXCLUDE_* constants
     *
     * @return Data
     */
    public function cloneVar($var, int $filter = 0)
    {
        $this->prevErrorHandler = \set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = \gc_enabled()) {
            \gc_disable();
        }
        try {
            return new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Data($this->doClone($var));
        } finally {
            if ($gc) {
                \gc_enable();
            }
            \restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array
     */
    protected abstract function doClone($var);
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array
     */
    protected function castObject(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (\PHP_VERSION_ID < 80000 ? "\x00" === ($class[15] ?? null) : \str_contains($class, "@anonymous\x00")) {
            $stub->class = \get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            [$i, $parents, $hasDebugInfo, $fileInfo] = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = \method_exists($class, '__debugInfo');
            foreach (\class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (\class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array
     */
    protected function castResource(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}
