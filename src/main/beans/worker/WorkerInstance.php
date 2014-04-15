<?php
class WorkerInstance {
    
    private $_pid;
    private $_logFile;
    private $_instanceCount;

    function __construct ($instanceCount) {
        $this->setInstanceCount($instanceCount);
        $this->spawnNewWorker();
        $this->createNextCountWorkerLogFilename();
    }

    private function spawnNewWorker () {
        $pid = exec('php /var/www/jobqueue/worker.php > /dev/null 2>&1 & echo $!;', $output);
        Logger::logToWorker(date('l jS \of F Y h:i:s A') . " - New Worker Created [pid:$pid][worker:" . $this->getInstanceCount() . "] \n");
        $this->setPid($pid);
    }

    private function createNextCountWorkerLogFilename () {
        // We could have individial log files
        $logFile = "/var/log/worker.$this->_instanceCount.log";
        // Also it needs to create the file as well
        $this->setLogFile($logFile);
    }

    private function setPid ($pid) {
        $this->_pid = $pid;
    }

    public function getPid () {
        return $this->_pid;
    }

    private function setLogFile ($logFile) {
        $this->_logFile = $logFile;
    }

    public function getLogFile () {
        return $this->_logFile;
    }

    private function setInstanceCount ($instanceCount) {
        $this->_instanceCount = $instanceCount;
    }

    public function getInstanceCount () {
        return $this->_instanceCount;
    }
    
    public function killInstance () {
        $isKilled = posix_kill( $this->getPid() , PCNTL.SIGKILL );
        // Give the proccess some time to terminate
        if($isKilled)
            Logger::logToWorker(date('l jS \of F Y h:i:s A') . " - Worker Killed [pid:".$this->getPid()."][worker:" . $this->getInstanceCount() . "] \n");
        else {
            Logger::logToWorker(date('l jS \of F Y h:i:s A') . " - Worker FORCED TO BE Killed [pid:".$this->getPid()."][worker:" . $this->getInstanceCount() . "] \n");
            exec("skill -9 ".$this->getPid());
            // Could add another check to warn user if the proccess was killed
        }
    }
}