<?php
/**
 * Created by PhpStorm.
 * User: sturkin30
 * Date: 04.03.18
 * Time: 10:30
 */

namespace Zealot\Filesystem\Csv;


class Writer extends File
{

    public function addRow(array $row){
        $this->getFile()->fputcsv($row,$this->getDelimiter(),$this->getEnclosure(),$this->getEscape());
    }

    public function addRows(array $rows) {
        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }

    protected function createFileObject($path) {
        return new \SplFileObject($path,'w+');
    }

}