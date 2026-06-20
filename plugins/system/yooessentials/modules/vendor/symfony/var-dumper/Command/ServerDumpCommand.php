<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Command\Command;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Completion\CompletionInput;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Completion\CompletionSuggestions;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Exception\InvalidArgumentException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Input\InputInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Input\InputOption;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Output\OutputInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Style\SymfonyStyle;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Data;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command\Descriptor\CliDescriptor;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command\Descriptor\DumpDescriptorInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command\Descriptor\HtmlDescriptor;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Dumper\CliDumper;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Server\DumpServer;
/**
 * Starts a dump server to collect and output dumps on a single place with multiple formats support.
 *
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 *
 * @final
 */
class ServerDumpCommand extends \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Command\Command
{
    protected static $defaultName = 'server:dump';
    protected static $defaultDescription = 'Start a dump server that collects and displays dumps in a single place';
    private $server;
    /** @var DumpDescriptorInterface[] */
    private $descriptors;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Server\DumpServer $server, array $descriptors = [])
    {
        $this->server = $server;
        $this->descriptors = $descriptors + ['cli' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command\Descriptor\CliDescriptor(new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Dumper\CliDumper()), 'html' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Command\Descriptor\HtmlDescriptor(new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Dumper\HtmlDumper())];
        parent::__construct();
    }
    protected function configure()
    {
        $this->addOption('format', null, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, \sprintf('The output format (%s)', \implode(', ', $this->getAvailableFormats())), 'cli')->setDescription(self::$defaultDescription)->setHelp(<<<'EOF'
<info>%command.name%</info> starts a dump server that collects and displays
dumps in a single place for debugging you application:

  <info>php %command.full_name%</info>

You can consult dumped data in HTML format in your browser by providing the <comment>--format=html</comment> option
and redirecting the output to a file:

  <info>php %command.full_name% --format="html" > dump.html</info>

EOF
);
    }
    protected function execute(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Input\InputInterface $input, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $io = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
        $format = $input->getOption('format');
        if (!($descriptor = $this->descriptors[$format] ?? null)) {
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Exception\InvalidArgumentException(\sprintf('Unsupported format "%s".', $format));
        }
        $errorIo = $io->getErrorStyle();
        $errorIo->title('Symfony Var Dumper Server');
        $this->server->start();
        $errorIo->success(\sprintf('Server listening on %s', $this->server->getHost()));
        $errorIo->comment('Quit the server with CONTROL-C.');
        $this->server->listen(function (\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Data $data, array $context, int $clientId) use($descriptor, $io) {
            $descriptor->describe($io, $data, $context, $clientId);
        });
        return 0;
    }
    public function complete(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Completion\CompletionInput $input, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions) : void
    {
        if ($input->mustSuggestOptionValuesFor('format')) {
            $suggestions->suggestValues($this->getAvailableFormats());
        }
    }
    private function getAvailableFormats() : array
    {
        return \array_keys($this->descriptors);
    }
}
