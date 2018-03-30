<?php
/**
 * Created by PhpStorm.
 * User: sturkin30
 * Date: 17.02.18
 * Time: 11:26
 */

namespace Zealot\Filesystem;

use Zealot\Filesystem\Exception\Exception;

class File implements \Iterator
{
    protected $path;
    protected $file;


    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function getFile() {
        if(empty($this->file)) {
            $this->file =$this->createFileObject($this->path);
        }

        return $this->file;
    }
    protected function createFileObject($path) {
        return new \SplFileObject($path);
    }

    // Start proxy-methods from SplFileObject
    public function current() {
        return $this->getFile()->current();
    }
    public function key() {
        return $this->getFile()->key();
    }
    public function rewind() {
        $this->getFile()->rewind();
    }
    public function next() {
        $this->getFile()->next();
    }
    public function valid() {
        return $this->getFile()->valid();
    }
    // End proxy-methods from SplFileObject

    // Start proxy-methods from SplFileInfo
    public function getBasename($suffix = null)
    {
        return $this->getFile()->getBasename($suffix);
    }

    public function getExtension()
    {
        return $this->getFile()->getExtension();
    }

    public function getATime()
    {
        return $this->getFile()->getATime();
    }

    public function getCTime()
    {
        return $this->getFile()->getCTime();
    }

    public function getFilename()
    {
        return $this->getFile()->getFilename();
    }

    public function getGroup()
    {
        return $this->getFile()->getGroup();
    }

    public function getInode()
    {
        return $this->getFile()->getInode();
    }

    public function getLinkTarget()
    {
        return $this->getFile()->getLinkTarget();
    }

    public function getMTime()
    {
        return $this->getFile()->getMTime();
    }

    public function getOwner()
    {
        return $this->getFile()->getOwner();
    }

    public function getPath()
    {
        return $this->getFile()->getPath();
    }

    public function getPathname()
    {
        return $this->getFile()->getPathname();
    }

    public function getPerms()
    {
        return $this->getFile()->getPerms();
    }

    public function getRealPath()
    {
        return $this->getFile()->getRealPath();
    }

    public function getSize()
    {
        return $this->getFile()->getSize();
    }

    public function getType()
    {
        return $this->getFile()->getType();
    }

    public function isDir()
    {
        return $this->getFile()->isDir();
    }

    public function isExecutable()
    {
        return $this->getFile()->isExecutable();
    }

    public function isFile()
    {
        return $this->getFile()->isFile();
    }

    public function isLink()
    {
        return $this->getFile()->isLink();
    }

    public function isReadable()
    {
        return $this->getFile()->isReadable();
    }

    public function isWritable()
    {
        return $this->getFile()->isWritable();
    }
    // End proxy-methods from SplFileInfo
    
}
