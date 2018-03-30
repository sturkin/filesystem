<?php
/**
 * Created by PhpStorm.
 * User: sturkin30
 * Date: 17.02.18
 * Time: 15:45
 */

namespace Zealot\Filesystem;

use Zealot\Filesystem\File;
use Zealot\Filesystem\Csv;

class FileInfo extends \SplFileInfo
{

    public function open(): File
    {
        return new File($this->getRealPath());
    }

    public function csvFile(): Csv\File
    {
        return new Csv\File($this->getRealPath());
    }

    public function csvReader(): Csv\Reader
    {
        return new Csv\Reader($this->getRealPath());
    }


}