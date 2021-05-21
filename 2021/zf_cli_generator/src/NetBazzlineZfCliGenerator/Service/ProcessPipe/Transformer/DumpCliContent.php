<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11
 * @see https://github.com/stevleibelt/examples/blob/master/php/filesystem/makePathsRelativeToEachOther.php
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;
use Symfony\Component\Filesystem\Filesystem;

class DumpCliContent implements ExecutableInterface
{
    const INPUT_KEY_PATH_TO_APPLICATION     = 'path_to_application';
    const INPUT_KEY_PATH_TO_AUTOLOAD        = 'path_to_autoload';
    const INPUT_KEY_PATH_TO_CLI             = 'path_to_cli';
    const INPUT_KEY_PATH_TO_CONFIGURATION   = 'path_to_configuration';
    const INPUT_KEY_PREFIX_CLI              = 'prefix_cli';

    /** @var Filesystem */
    private $filesystem;

    /** @var int */
    private $timestamp;

    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null)
    {
        $this->validateInput($input);

        $date                   = date('Y-m-d H:i:s');
        $filesystem             = $this->filesystem;
        $pathToApplication      = $input[self::INPUT_KEY_PATH_TO_APPLICATION];
        $pathToAutoload         = $input[self::INPUT_KEY_PATH_TO_AUTOLOAD];
        $pathToConfiguration    = $input[self::INPUT_KEY_PATH_TO_CONFIGURATION];
        $pathToCli              = dirname($input[self::INPUT_KEY_PATH_TO_CLI]);
        $prefix                 = $input[self::INPUT_KEY_PREFIX_CLI];

        $pathFromCliToAutoload      = DIRECTORY_SEPARATOR . $filesystem->makePathRelative($pathToAutoload, $pathToCli);
        $pathFromCliToApplication   = DIRECTORY_SEPARATOR . $filesystem->makePathRelative($pathToApplication, $pathToCli);
        $pathFromCliToConfiguration = DIRECTORY_SEPARATOR . $filesystem->makePathRelative($pathToConfiguration, $pathToCli);

        //@todo a bug in symfony filesystem?
        $pathFromCliToAutoload      = substr($pathFromCliToAutoload, 0, -1);
        $pathFromCliToApplication   = substr($pathFromCliToApplication, 0, -1);
        $pathFromCliToConfiguration = substr($pathFromCliToConfiguration, 0, -1);

        $output = <<<EOC
#!/usr/bin/env php
<?php
/**
 * @author Net\Bazzline Zf Cli Generator
 * @since $date
 */

use Net\Bazzline\Component\Cli\Readline\ManagerFactory;

require_once __DIR__ . '$pathFromCliToAutoload';

try {
    \$factory           = new ManagerFactory();
    \$manager           = \$factory->create();
    \$callApplication   = function() {
        \$line       = readline_info('line_buffer');
        \$command    = '/usr/bin/env php ' .
            __DIR__ . '$pathFromCliToApplication ' .
            \$line;

        passthru(\$command);
    };
    \$configuration     = require_once(__DIR__ . '$pathFromCliToConfiguration');

    \$manager->setConfiguration(\$configuration);
    \$manager->setPrompt('$prefix');
    \$manager->run();
} catch (Exception \$exception) {
    echo '----------------' . PHP_EOL;
    echo \$exception->getMessage() . PHP_EOL;
    return 1;
}
EOC;

        return $output;
    }

    /**
     * @param mixed $input
     * @throws ExecutableException
     */
    private function validateInput(&$input)
    {
        if (!is_array($input)) {
            throw new ExecutableException(
                'input must be an array'
            );
        }

        if (empty($input)) {
            throw new ExecutableException(
                'empty input provided'
            );
        }

        $keys = array(
            self::INPUT_KEY_PATH_TO_APPLICATION,
            self::INPUT_KEY_PATH_TO_AUTOLOAD,
            self::INPUT_KEY_PATH_TO_CONFIGURATION,
            self::INPUT_KEY_PATH_TO_CLI,
            self::INPUT_KEY_PREFIX_CLI
        );

        foreach ($keys as $key) {
            if (!isset($input[$key])) {
                throw new ExecutableException(
                    'input must contain mandatory key "' . $key . '"'
                );
            }
        }

        //validate paths
        $paths = array(
            self::INPUT_KEY_PATH_TO_APPLICATION,
            self::INPUT_KEY_PATH_TO_AUTOLOAD,
            self::INPUT_KEY_PATH_TO_CLI,
            self::INPUT_KEY_PATH_TO_CONFIGURATION
        );

        foreach ($paths as $path) {
            $realPath = realpath($input[$path]);

            if ($realPath === false) {
                throw new ExecutableException(
                    'provided path is not a real path / does not exist "' . $input[$path] . '"'
                );
            } else {
                $input[$path] = $realPath;
            }
        }
    }
}
