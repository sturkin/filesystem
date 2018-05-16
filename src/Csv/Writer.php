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

    public function __construct($path, $mode = 'w+', $delimiter=',',$enclosure='"',$escape="\\")
    {
        parent::__construct($path, $mode, $delimiter, $enclosure, $escape);
    }

    public function addRow(array $row){
        $this->getFile()->fputcsv($row,$this->getDelimiter(),$this->getEnclosure(),$this->getEscape());
    }

    public function addRows(array $rows) {
        foreach ($rows as $row) {
            $this->addRow($row);
        }
    }
}