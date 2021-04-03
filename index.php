<?php

require('fdscanner.class.php');
$fd = new FDScanner;

print_r($fd->manyReadFile("main_directory"));