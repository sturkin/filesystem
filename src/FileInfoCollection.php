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

    public function first(): FileInfo {
        if (count($this->items) > 0) {
            return $this->items[0];
        }
    }


    public function add(FileInfo $item) {
        $this->items[] = $item;
    }

    public function seek($position) {
        if (!isset($this->items[$position])) {
            return null;
        }

        $this->position = $position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current(): FileInfo {
        return $this->items[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->items[$this->position]);
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function count() {
        return count($this->items);
    }


}