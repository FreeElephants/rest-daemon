<?php

namespace FreeElephants\RestDaemon\Console\Command\Generator;

use FreeElephants\RestDaemon\Integration\Swagger\RouterGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Code\Generator\ValueGenerator;

class Swagger extends Command
{

    /**
     * @var RouterGenerator
     */
    private $routerGenerator;

    const FILE_TEMPLATE = <<<PHP
<?php

return %s;

PHP;


    public function __construct(RouterGenerator $routerGenerator = null)
    {
        parent::__construct('generate:routers:swagger');
        $this->addArgument('dir');
        $this->addArgument('out');
        $this->addOption('skip-php-tags', 's', InputOption::VALUE_NONE, false);
        $this->routerGenerator = $routerGenerator ?: new RouterGenerator();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->hasArgument('dir')) {
            $dir = $input->getArgument('dir');
        } else {
            $dir = __DIR__;
        }

        $routes = $this->routerGenerator->getRouterConfig($dir);
        $generator = new ValueGenerator($routes, ValueGenerator::TYPE_ARRAY_SHORT);
        $generator->setIndentation('  '); // 2 spaces
        $formattedString = $generator->generate();

        if (!$input->getOption('skip-php-tags')) {
            $formattedString = sprintf(self::FILE_TEMPLATE, $formattedString);
        }

        // TODO trim single quotes in handlers classes names
        if ($outputFile = $input->getArgument('out')) {
            file_put_contents($outputFile, $formattedString);
        } else {
            $output->writeln($formattedString);
        }
    }
}