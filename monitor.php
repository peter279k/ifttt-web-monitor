<?php

$settingFile = './settings.txt';
if (file_exists($settingFile) === false) {
    echo $settingFile , " is not found.\n";
    exit(1);
}

$settings = file_get_contents($settingFile);

