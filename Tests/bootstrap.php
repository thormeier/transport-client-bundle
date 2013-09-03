<?php
// Bootstrap file for functional tests

$loaderPath = AutoloaderFinder::findAutoloader();

echo <<<EOM
Testing with autoloader from

    $loaderPath


EOM;

if ($loaderPath === false) {
    echo <<<EOM
You must set up the project dependencies by running

    composer install

EOM;

    exit(1);
}

require_once($loaderPath);

/**
 * Helper class to fint the autoloader
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class AutoloaderFinder
{
    /**
     * Find autoloader path from vendor
     *
     * @return boolean
     */
    public static function findAutoloader()
    {
        $ps = array(
                __DIR__.'/../../../../vendor/autoload.php',
                __DIR__.'/../vendor/autoload.php',
        );

        foreach ($ps as $path) {
            if (file_exists($path)) {
                return realpath($path);
            }
        }

        return false;
    }
}

