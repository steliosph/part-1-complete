<?php
class Logger {
    
    private static $_MANAGER_LOG = '/var/www/jobqueue/logs/manager.log';
    private static $_WORKER_LOG = '/var/www/jobqueue/logs/worker.log';
    private static $_TASK_LOG = '/var/www/jobqueue/logs/task.log';
    
    public static function logToManager($content, $append = true) {
        if ($append)
            file_put_contents(self::$_MANAGER_LOG, $content, FILE_APPEND);
        else
            file_put_contents(self::$_MANAGER_LOG, $content);        
    }
    
    public static function logToWorker($content, $append = true) {
        if ($append)
            file_put_contents(self::$_WORKER_LOG, $content, FILE_APPEND);
        else
            file_put_contents(self::$_WORKER_LOG, $content);
    }
    
    public static function logToTask($content, $append = true) {
        if ($append)
            file_put_contents(self::$_TASK_LOG, $content, FILE_APPEND);
        else
            file_put_contents(self::$_TASK_LOG, $content);
    }
}