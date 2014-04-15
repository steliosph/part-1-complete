<?php
final class Autoloader {

    public static function load ($className) {
        $root_directory = $_SERVER['DOCUMENT_ROOT'] . '/';
        $dirs = array(
                'logs',
                'src/main/beans/manager/',
                'src/main/beans/worker/',
                'src/main/beans/task/',
                'src/main/utils/',
        );
        self::loop($dirs, $root_directory, $className);
    }

    private static function loop ($array, $root_directory, $className) {
        $fileNameFormats = array(
                '%s.php'
        );
        
        foreach ($array as $directory) {
            foreach ($fileNameFormats as $fileNameFormat) {
                $path = __DIR__ . '/' . $directory . sprintf($fileNameFormat, $className);
                // $path = $root_directory . $directory .
                // sprintf($fileNameFormat, $className);
                if (file_exists($path)) {
                    include $path;
                    return true;
                }
            }
        }
        return false;
    }
}

spl_autoload_register(array(
        'Autoloader',
        'load'
));
