<?php

namespace Zealot\Filesystem\Csv;

use Zealot\Filesystem\Exception\EmptyFileException;
use Zealot\Filesystem;
use Zealot\Filesystem\Csv\Header;

class Reader extends File {


    protected $header;

    public function __construct($path, $delimiter=',',$enclosure='"',$escape="\\")
    {
        parent::__construct($path, 'r', $delimiter, $enclosure, $escape);
    }

    public function var_dump(){
        foreach ($this as $row) {
            var_dump($row);
        }
    }

    public function header() {
        return $this->getHeader()->_toArray();
    }

    public function current()
    {
        $line =  parent::current();
        $line = $this->fillFieldNames($line);
        return $line;
    }

    public function rewind() {
        parent::rewind();
        $this->next();
    }

    // START GETTER/SETTER

    protected function getHeader(): Header
    {
        return $this->header;
    }
    // END GETTER/SETTER


    // START PROTECTED METHODS
    protected function readHeader() {
        $file = $this->getFile();
        $headerArr = $file->fgetcsv($this->delimiter,$this->enclosure,$this->escape);
        if(empty($headerArr)) {
            throw new EmptyFileException('Csv file is empty');
        }

        $header = new Header();
        foreach ($headerArr as $fieldName) {
            $header->addField($fieldName);
        }

        $this->header = $header;
        //$file->rewind();
    }

    protected function fillFieldNames($lineArr) {
        //array_combine
        /*
        $lineFilledArr = [];
        foreach ($lineArr as $fieldId => $value) {
            $fieldName = $this->getHeader()->fieldIdToName($fieldId);
            $lineFilledArr[$fieldName] = $value;
        }

        return $lineFilledArr;
        */

        return array_combine($this->getHeader()->_toArray(),$lineArr);
    }

    protected function _initFile(\SplFileObject $file)
    {
        parent::_initFile($file);
        $this->readHeader();
    }
    // END PROTECTED METHODS

}

