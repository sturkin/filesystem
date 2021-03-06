<?php

namespace Zealot\Filesystem;

use Zealot\Filesystem\Exception\Exception;
use Zealot\Filesystem\FileInfo;
use Zealot\Filesystem\FileInfoCollection;

/**
 * Class Directory
 * @package Src\Zealot\Filesystem
 *
 * @property \DirectoryIterator $content
 */
class Directory
{
    protected $path;
    protected $content;

    /**
     * Directory constructor.
     * @param string $path
     * @throws Exception
     */
    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new Exception('Invalid path to directory');
        }
        if(!is_dir($path)) {
            throw new Exception('Invalid path to directory, it\'s not a directory (file?link?)');
        }

        $this->path = $path;
    }


    /**
     * find all elements in $path
     * @param int $limit
     * @return \Zealot\Filesystem\FileInfoCollection
     */
    public function all($limit = 0) : FileInfoCollection {
        return $this->filterContent(null, $limit);
    }

    /**
     * @param string $pattern - should be valid preg match pattern without delimiters and pattern modifiers
     * @param bool $filterOffHidden
     * @return array of DirectoryIterator
     */
    public function find($pattern = null, $limit = 0, $filterOutDotStartElements = true) : FileInfoCollection {
        return $this->filterContent(function(\SplFileInfo $element) use ($pattern, $filterOutDotStartElements) {
            $res = true;
            $fileName = $element->getFilename();
            if ( $filterOutDotStartElements && $this->isStartsFromDot($fileName) ) $res = false;
            if ( !$this->isMatchPattern($pattern,$fileName) ) $res = false;

            return $res;
        },
            $limit
        );
    }

    /**
     * find all files from $path and return FileInfoCollection
     * @param int $limit
     * @param bool $filterOutDotStartElements if true - skip all elements that starts from . (hidden files and . ..)
     * @return \Zealot\Filesystem\FileInfoCollection
     */
    public function files($limit = 0, $filterOutDotStartElements = false) : FileInfoCollection {
        return $this->filterContent(function(\SplFileInfo $element) use ($filterOutDotStartElements) {
            $res = true;
            $fileName = $element->getFilename();
            if ( $filterOutDotStartElements && $this->isStartsFromDot($fileName) ) $res = false;
            if ( !$element->isFile() ) $res = false;

            return $res;
        },
            $limit
        );
    }

    /**
     * find all dirs from $path and return FileInfoCollection
     * @param int $limit
     * @param bool $filterOutDotStartElements if true - skip all elements that starts from . (hidden files and . ..)
     * @return \Zealot\Filesystem\FileInfoCollection
     */
    public function directories($limit = 0, $filterOutDotStartElements = false) : FileInfoCollection {
        return $this->filterContent(function(\SplFileInfo $element) use ($filterOutDotStartElements) {
            $res = true;
            if ( $filterOutDotStartElements && $this->isStartsFromDot($element->getBasename()) ) $res = false;
            if ( !$element->isDir() ) $res = false;

            return $res;
        },
            $limit
        );
    }

    protected function filterContent(\Closure $callback = null,$limit = 0): FileInfoCollection {
        $content = $this->getContent();
        $collection = new FileInfoCollection();
        foreach ($content as $element) {
            if(empty($callback) || $callback($element)) {
                $collection->add(new FileInfo($element->getPath().DIRECTORY_SEPARATOR.$element->getBasename()));
            }
            if($limit > 0 && count($collection) == $limit) {
                break;
            }
        }

        return $collection;
    }

    protected function getContent(): \DirectoryIterator {
        if(empty($this->content)) {
            $this->scan();
        }

        return $this->content;
    }

    protected function scan() {
        $this->content = new \DirectoryIterator($this->path);
    }

    protected function isMatchPattern($pattern, $fileName) {
        $pattern = "#$pattern#";

        return preg_match($pattern,$fileName);
    }

    protected function isStartsFromDot($fileName) {
        return ($fileName[0] == '.');
    }

}