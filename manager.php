#!/usr/bin/php

<?php
include 'loader.php';

declare(ticks = 1);

pcntl_signal(SIGTERM, "sig_handle");
pcntl_signal(SIGINT,  "sig_handle");
pcntl_signal(SIGKILL, "sig_handler");
pcntl_signal(SIGABRT, "sig_handler");
$TERMINATE = false;

function sig_handle ($signal) {
    switch ($signal) {
        case SIGTERM:
        case SIGABRT:
        case SIGKILL:
        case SIGINT:
            global $TERMINATE;
            $TERMINATE = true;
            break;
    }
}

$manager = new Manager();
$loop = true;
while ($loop) {
    if ($TERMINATE) {
        $loop = false;
    } else {
        $manager->checkAndManageWorkers();
        sleep(5);
    }
}

Logger::logToManager("Closing Manager\n");
$manager->killAllChildProccesses();

?>