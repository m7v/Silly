<?php

$core_dir = realpath(dirname(__FILE__). '/core');
$files = scandir($core_dir);
array_shift($files);
array_shift($files);

foreach ($files as $file) {
    require_once 'core/'. $file;
}
