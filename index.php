<?php
$dir = dirname(__FILE__);
$a = getFileList($dir);
foreach ($a as $key => $val) {
    echo "***********" . $key . "************\n";
    $f = file_get_contents($val);
    echo $f;
    echo "\n\n";
}

function getFileList($dir) {
    $files = scandir($dir);
    $files = array_filter($files, function ($file) { // 注(1)
        return !in_array($file, array('.', '..'));
    });

    $list = array();
    foreach ($files as $file) {
        $fullpath = rtrim($dir, '/') . '/' . $file; // 注(2)
        if (! fnmatch("*.txt", $fullpath)) {
            continue;
        }
        if (is_file($fullpath)) {
            $list[$file] = $fullpath;
        }
        if (is_dir($fullpath)) {
            $list = array_merge($list, getFileList($fullpath));
        }
    }

    return $list;
}
