<?php

namespace Zealot\Filesystem\Csv;

use Zealot\Filesystem;

class File extends Filesystem\File {


    protected $delimiter = ',';
    protected $enclosure = '"';
    protected $escape = '\\';

    public function __construct($path,$mode = 'r',$delimiter=',',$enclosure='"',$escape="\\")
    {
        parent::__construct($path,$mode);
        $this->setDelimiter($delimiter);
        $this->setEnclosure($enclosure);
        $this->setEscape($escape);

        $this->_initFile($this->getFile());
    }

    public function write($row) {
        $this->getFile()->fputcsv($row,$this->getDelimiter(),$this->getEnclosure(),$this->getEscape());
    }

    // START GETTERS/SETTERS
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }
    public function setDelimiter(string $delimiter)
    {
        $this->delimiter = $delimiter;
    }

    public function getEnclosure(): string
    {
        return $this->enclosure;
    }
    public function setEnclosure(string $enclosure)
    {
        $this->enclosure = $enclosure;
    }

    public function getEscape(): string
    {
        return $this->escape;
    }
    public function setEscape(string $escape)
    {
        $this->escape = $escape;
    }
    // END GETTERS/SETTERS

    protected function _initFile(\SplFileObject $file) {
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl($this->getDelimiter(),$this->getEnclosure(),$this->getEscape());
    }


}