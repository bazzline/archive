<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-03
 */

namespace Net\Bazzline\Component\ComposerAutoload;

use RuntimeException;

class Loader
{
    /**
     * Provide the relative path to your vendor directory
     * E.G.:
     *  relative full path is: __DIR__ . '/../vendor/autoload.php';
     *  provide: __DIR . '/..'
     *
     * @param string $relativePathToVendor
     */
    public static function load($relativePathToVendor)
    {
        $couldNotLoadAutoload           = true;
        $listOfRelativePathToAutoload   = [
            $relativePathToVendor . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php',
            $relativePathToVendor . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php'
        ];

        foreach ($listOfRelativePathToAutoload as $relativePathToAutoload) {
            if (file_exists($relativePathToAutoload)) {
                require_once $relativePathToAutoload;

                $couldNotLoadAutoload = false;
                break;
            }
        }

        if ($couldNotLoadAutoload) {
            throw new RuntimeException(
                ':: Could not find autoload.php in following paths'
                . PHP_EOL
                . '   '
                . implode(
                    PHP_EOL . '   ',
                    $listOfRelativePathToAutoload
                )
            );
        }
}
