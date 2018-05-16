<?php
/**
 * Created by PhpStorm.
 * User: sturkin30
 * Date: 18.02.18
 * Time: 16:44
 */

namespace Zealot\Filesystem;

use Zealot\Filesystem\FileInfo;
use Zealot\Filesystem\Exception\Exception;

class FileInfoCollection implements \SeekableIterator, \ArrayAccess, \Countable
{

    protected $position;
    protected $items = [];

    /**
     * @return \Zealot\Filesystem\FileInfo
     */
    public function first(): FileInfo {
        if (count($this->items) > 0) {
            return $this->items[0];
        }
    }


    /**
     * @param \Zealot\Filesystem\FileInfo $item
     */
    public function add(FileInfo $item) {
        $this->items[] = $item;
    }

    /**
     * @param int $position
     * @return null
     */
    public function seek($position) {
        if (!isset($this->items[$position])) {
            return null;
        }

        $this->position = $position;
    }

    /**
     *
     */
    public function rewind() {
        $this->position = 0;
    }

    /**
     * @return \Zealot\Filesystem\FileInfo
     */
    public function current(): FileInfo {
        return $this->items[$this->position];
    }

    /**
     * @return mixed
     */
    public function key() {
        return $this->position;
    }

    /**
     *
     */
    public function next() {
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid() {
        return isset($this->items[$this->position]);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->items);
    }

    public function var_dump() {
        foreach ($this as $file) {
            echo $file->getBasename() . PHP_EOL;
        }
        echo PHP_EOL;
    }


}