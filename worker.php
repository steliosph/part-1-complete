#!/usr/bin/php

<?php
include 'loader.php';

$Task = new Task();
if (BeanUtils::isBeanInvalid($Task)) {
    Logger::logToTask("Could not initialize Task as it doesnt implement TaskInterface");
    return;
}

$keepAlivePeriod = SettingsLoad::getWorkerKeepAlive();

while (true) {
    $Task->keepAlive();
    sleep($keepAlivePeriod);
}

?>
