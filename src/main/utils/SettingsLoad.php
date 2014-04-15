<?php 
class SettingsLoad {

    private static $_DEFAULT_MAX_AMOUNT_OF_WORKERS = 2;
    private static $_FILE_AMOUNT_OF_WORKER = 'max_amount_of_workers';
    private static $_DEFAULT_KEEP_ALIVE_WORKER = 10;
    private static $_FILE_KEEP_ALIVE_TIME = 'keep_alive_worker_time';

    private static $_settingsFilename = 'settings';
    
    
    public static function getMaxAmountOfWorker() {
        Logger::logToManager(" - Setting Max Amount of workers ");
        if (!self::fileExists())
            return self::getDefaultAmountOfWorker();
        
        $file = self::openFile();
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if(strpos($line,self::$_FILE_AMOUNT_OF_WORKER) !== false) {
                    $value = str_replace(self::$_FILE_AMOUNT_OF_WORKER."=", "", $line);
                    $value = self::removeNewLines($value);
                    if (is_numeric($value)) {
                        Logger::logToManager(" ($value) \n");
                        self::closeFile($file);
                        return $value;
                    }
                }
            }
        }
        Logger::logToManager(" (".self::getDefaultAmountOfWorker().") - default \n");
        self::closeFile($file);
        return self::getDefaultAmountOfWorker();
    }

    public static function getWorkerKeepAlive() {
        Logger::logToManager(" - Setting keep alive of workers ");
        if (!self::fileExists())
           return self::getDefaultWorkerKeepAlive();
        $file = self::openFile();
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if(strpos($line,self::$_FILE_KEEP_ALIVE_TIME) !== false) {
                    $value = str_replace(self::$_FILE_KEEP_ALIVE_TIME."=", "", $line);
                    $value = self::removeNewLines($value);
                    if (is_numeric($value)) {
                        Logger::logToManager(" ($value) \n");
                        self::closeFile($file);
                        return $value;
                    }
                }                  
            }
        }
        Logger::logToManager(" (".self::getDefaultAmountOfWorker().") - default \n");
        self::closeFile($file);
        return self::getDefaultWorkerKeepAlive();
    }
    
    private static function removeNewLines($value) { 
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private static function fileExists() {
        if(file_exists(self::getFile()))
            return true;
        return false;
    }

    private static function getDefaultAmountOfWorker() {
        return self::$_DEFAULT_MAX_AMOUNT_OF_WORKERS;
    }

    private static function getDefaultWorkerKeepAlive() {
        return self::$_DEFAULT_KEEP_ALIVE_WORKER;
    }
    
    private static function openFile () { 
        return fopen(self::getFile(), "r");
    }

    private static function closeFile($file) { 
        fclose($file);
    }

    private static function getFile() {
        return '/var/www/jobqueue/'.self::$_settingsFilename;
    }
}