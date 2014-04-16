<?php 
class Manager {

    private $_maxWorkers;
    private $_workerCount = 0;
    private $_workerList = array();

    public function __construct() {
        Logger::logToManager("Initializing Manager\n");
        $this->setMaxWorkers();
        $this->spawnInitialWorkers();
    }
    
    private function setMaxWorkers() { 
        $this->_maxWorkers = SettingsLoad::getMaxAmountOfWorker();
    }

    private function spawnInitialWorkers() {
        for ($count=1; $count <= $this->_maxWorkers; $count++) {
            $this->spawnNewWorker(); 
        }
    }

    private function spawnNewWorker() { 
        try {
            $workerInstance = new WorkerInstance($this->_workerCount);
            $this->incrementActiveWorkers();
            $this->addWorkerInstanceToActiveWorkerList($workerInstance);
        } catch (Exception $e) {
            // TODO A custom error handler would be ideal in order to log all the errors to a seperate log file, and email us when this occurs
            Logger::logToManager("Error encounterer : $e");
        }
    }

    private function incrementActiveWorkers() {
        $this->_workerCount = $this->_workerCount + 1;
    }

    private function addWorkerInstanceToActiveWorkerList($workerInstance) { 
        array_push($this->_workerList, $workerInstance);
    }

    public function checkAndManageWorkers() {
        $this->checkIfProccessIsRunning();  
    }

    private function checkIfProccessIsRunning() {
        foreach ($this->_workerList as $workerInstance) {
            if (!file_exists("/proc/".$workerInstance->getPid())) {
                Logger::logToWorker(date('l jS \of F Y h:i:s A') . " - Worker [pid:".$workerInstance->getPid()."][worker:" . $workerInstance->getInstanceCount() . "] has stopped - restarting worker \n");
                $this->removePidFromActiveList($workerInstance);
                $this->spawnNewWorker();
            }
        }
    }

    private function removePidFromActiveList($workerInstance) { 
        if (($key = array_search($workerInstance, $this->_workerList)) !== false)
            unset($this->_workerList[$key]);
    } 

    
    public function killAllChildProccesses() { 
        foreach ($this->_workerList as $workerInstance) {
            $workerInstance->killInstance();
        }
    }
}
