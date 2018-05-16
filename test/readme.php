<?php

use Zealot\Filesystem\Csv;
use Zealot\Filesystem\Directory;

$tmpDir = '/tmp';

$files_data = [
    [
        'type' => 'file',
        'name' => 'csvfile_emails.csv',
        'data' => [
            ['email','name'],
            ['sturkin30@gmail.com','sergey'],
            ['sturkin@gmail.com',''],
        ]
    ],
    [
        'type' => 'file',
        'name' => 'csvfile_cities.csv',
        'data' => [
            ['city','size'],
            ['kiev','big'],
            ['dnepr','big'],
            ['niko','middle'],
        ]
    ],
    [
        'type' => 'file',
        'name' => 'csvfile_video.csv',
        'data' => [
            ['author','name'],
            ['sturkin30','first'],
            ['sturkin','second'],
        ]
    ],
    [
        'type' => 'file',
        'name' => '.csvfile_hidden.csv',
        'data' => [
            ['field1','name'],
            ['1','2']
        ]
    ],
    [
        'type' => 'dir',
        'name' => 'tmp',
    ],
];

function createFiles($files_data,$tmpDir) {
    foreach($files_data as $elem) {
        $fileName = $tmpDir.DIRECTORY_SEPARATOR.$elem['name'];
        if($elem['type'] == 'file') {
            $writer = new Csv\Writer($fileName,'w+');
            foreach ($elem['data'] as $line) {
                $writer->addRow($line);
            }
        } elseif ($elem['type'] == 'dir') {
            mkdir($fileName);
        }
    }
}

function deleteFiles($files_data,$tmpDir) {
    foreach($files_data as $elem) {
        $fileName = $tmpDir . DIRECTORY_SEPARATOR . $elem['name'];
        unlink($fileName);
    }
}


createFiles($files_data,$tmpDir);
/**** START ****/
//Lib to find/read/write text/csv files. Note only for unix like systems

//Usage:

//1) Directory class uses to find files. (Note: it isn't recursive)
//Example:

$path = '/tmp/';
$dir = new Directory($path);

//find all files
$filesCollection = $dir->files(); // not required param $limit. not required param $filterOutDotStartElements (set true to skip hidden files)
echo 'all non hidden files in dir: ' . PHP_EOL;
$filesCollection->var_dump();


//find all dirs
$dirsCollection = $dir->directories(); // not required param $limit. not required param $filterOutDotStartElements (set true to skip . and .. dirs)
echo 'all non dot-start dirs in dir: ' . PHP_EOL;
$dirsCollection->var_dump();


//find elements by regex that ends on '.csv'
$filesCollection = $dir->find('\.csv$'); // not required param $limit. not required param $filterOutDotStartElements (set true to skip hidden files)

//$filesCollection is an instance of FileCollection
echo 'all files with ".csv" ending in dir: ' . PHP_EOL;
foreach($filesCollection as $fileInfo) {
    //$file is an instance of FileInfo
    echo $fileInfo->getRealPath() . PHP_EOL;
}

//read file as csv
$file = $filesCollection[0];
$reader = $filesCollection[0]->csvReader();
echo 'Read first ".csv" ending file in dir: ' . PHP_EOL;
//foreach would not return first line, it starts from second line and returns assoc array combined from
//fist line data and line data, content of firs line will be the keys of the line
foreach ($reader as $i => $dataLine) {
    $lineNum = $i+1;
    echo "Line $lineNum" . PHP_EOL;
    var_dump($dataLine);
}
/** Output example:
Read first ".csv" ending file in dir:

Line 2
array(2) {
    ["city"]=>
        string(4) "kiev"
    ["size"]=>
        string(3) "big"
}
Line 3
array(2) {
    ["city"]=>
        string(5) "london"
    ["size"]=>
        string(3) "big"
}
Line 4
array(2) {
    ["city"]=>
        string(4) "NY"
    ["size"]=>
        string(6) "huge"
}

 **/




/*** END ***/
deleteFiles($files_data,$tmpDir);