<?php

namespace FreeElephants\RestDaemon\Console\Command\Generator;

use FreeElephants\RestDaemon\Integration\Swagger\RouterGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

    const CLASS_NAME_PATTERN = '/=> (\'.*::class\'),/';

    public function __construct(RouterGenerator $routerGenerator = null)
    {
        parent::__construct('generate:routes:swagger');
        $this->addArgument('dir', InputArgument::OPTIONAL, 'Directory with swagger annotated sources for scanning',
            getcwd() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR);
        $this->addArgument('out', InputArgument::OPTIONAL, 'Output filename for writing. Use stdout by default');
        $this->addOption('skip-php-tags', 's', InputOption::VALUE_NONE,
            'Skip open php tag and does not wrap structure to `return`');
        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Rewrite existing file');
        $this->addOption('indent', 'i', InputOption::VALUE_OPTIONAL,
            'Number of spaces for indents in generated structure', 4);
        $this->addOption('wrap-classes-with-quotes', 'w', InputOption::VALUE_NONE,
            'Wrap class names with single quotes: generate `\'Vendor\\\\Example::class\'` instead `Vendor\Example::class` entries');
        $this->routerGenerator = $routerGenerator ?: new RouterGenerator();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getArgument('dir');
        if(!is_dir($dir)) {
            $message = sprintf('Directory `%s` not is directory', $dir);
            throw new \InvalidArgumentException($message);
        }
        $routes = $this->routerGenerator->getRouterConfig($dir);
        $generator = new ValueGenerator($routes, ValueGenerator::TYPE_ARRAY_SHORT);
        $indentations = $input->getOption('indent');
        if(!is_integer($indentations) || $indentations < 1) {
            $message = sprintf('Indent size must be positive integer');
            throw new \RuntimeException($message);
        }
        $generator->setIndentation(str_repeat(' ', $indentations));
        $formattedString = $generator->generate();

        if (!$input->getOption('wrap-classes-with-quotes')) {
            $formattedString = $this->openQoutesInHandlersClassNames($formattedString);
        }

        if (!$input->getOption('skip-php-tags')) {
            $formattedString = sprintf(self::FILE_TEMPLATE, $formattedString);
        }

        if ($outputFile = $input->getArgument('out')) {
            if (file_exists($outputFile) && !$input->getOption('force')) {
                $message = sprintf('File %s already exists. Use `--force` option for override it', $outputFile);
                throw new \RuntimeException($message);
            } else {
                file_put_contents($outputFile, $formattedString);
            }
        } else {
            $output->writeln($formattedString);
        }
    }

    private function openQoutesInHandlersClassNames(string $formattedString): string
    {
        preg_match_all(self::CLASS_NAME_PATTERN, $formattedString, $matches);
        if (count($matches[1])) {
            foreach ($matches[1] as $rawClassName) {
                $classNameWithoutQuotes = str_replace('\'', '', $rawClassName);
                $className = str_replace('\\\\', '\\', $classNameWithoutQuotes);
                $fqClassName = '\\' . $className;
                $formattedString = str_replace($rawClassName, $fqClassName, $formattedString);
            }
        }

        return $formattedString;
    }
}