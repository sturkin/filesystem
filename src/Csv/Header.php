<?php

namespace Src\Zealot\Filesystem\Csv;


class Header
{
    protected $fields = [];
    protected $fieldsFlipped = [];


    public function addField($fieldName) {
        $this->fields[] = $fieldName;
        $this->fieldsFlipped[$fieldName] = count($this->fields)-1;
    }

    public function fieldIdToName($fieldId) {
        $index = (isset($this->fields[$fieldId])) ? $this->fields[$fieldId] : $fieldId;

        return $index;
    }


    public function fieldNameToId($fieldName) {
        $index = (isset($this->fieldsFlipped[$fieldName])) ? $this->fieldsFlipped[$fieldName] : $fieldName;

        return $index;
    }

    public function _toArray() {
        return $this->fields;
    }

}