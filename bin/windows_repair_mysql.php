<?php

$dbdir = "blis_revamp";
if ($argc > 1) {
    $dbdir = $argv[1];
}

$directory = realpath(dirname(__FILE__)."/../dbdir/$dbdir");
$myisamchk = realpath(dirname(__FILE__)."/../server/mysql/bin/myisamchk.exe");

if (!$directory || !$myisamchk) {
    echo "Error: Could not resolve directory or myisamchk.exe path.\n";
    exit(1);
}

function findMyiFiles($dir) {
    $mysql_files = scandir($dir);
    $files = array();

    foreach ($mysql_files as $file) {
        if ($file[0] == ".") {
            continue;
        }
        if (is_dir("$dir/$file")){
            continue;
        }
        if (strpos(strtolower($file), ".myi") > 0) {
            echo($file."\n");
            $files[] = "$dir/$file";
        }
    }

    return $files;
}

$fyiFiles = findMyiFiles($directory);

foreach ($fyiFiles as $file) {
    $command = sprintf('"%s" --force "%s"', $myisamchk, $file);
    echo "Executing: $command\n";
    exec($command, $output, $return_var);

    foreach ($output as $line) {
        echo $line . "\n";
    }

    if ($return_var !== 0) {
        echo "Error: myisamchk failed on file $file\n";
    }
}