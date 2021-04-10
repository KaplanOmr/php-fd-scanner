<?php

require('fdscanner.class.php');
$fd = new FDScanner;

//Directory List

$fdList = $fd->list();

//Read One File

$fdOneRead = $fd->oneReadFile();

//Read Many File

$fdManyRead = $fd->manyReadFile();

//Search File Name

$fdSearchFile = $fd->searchFileName('file');

//Search File Name Extentions

$fdSearchExtentions = $fd->searchFileNameExtentions('txt');

