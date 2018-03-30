<?php

namespace Src\Zealot\Filesystem\Csv;

use Src\Zealot\Filesystem;

class File extends Filesystem\File {


    protected $delimiter = ',';
    protected $enclosure = '"';
    protected $escape = '\\';

    protected $fileInitialized = false;

    public function __construct($path,$delimiter=',',$enclosure='"',$escape="\\")
    {
        parent::__construct($path);
        $this->setDelimiter($delimiter);
        $this->setEnclosure($enclosure);
        $this->setEscape($escape);
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

    public function isFileInitialized(): bool
    {
        return $this->fileInitialized;
    }
    public function setFileInitialized()
    {
        $this->fileInitialized = true;
    }
    // END GETTERS/SETTERS


    protected function getFile()
    {
        $file = parent::getFile();
        if( !$this->isFileInitialized() ) {
            $this->_initFile($file);
        }

        return $file;
    }

    protected function _initFile(\SplFileObject $file) {
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl($this->getDelimiter(),$this->getEnclosure(),$this->getEscape());
        $this->setFileInitialized();
    }


}