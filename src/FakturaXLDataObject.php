<?php

namespace blizni\FXL;

abstract class FakturaXLDataObject
{
    public abstract function getID();

    public abstract static function createFromJson($json);
    public abstract function toArray($includeEmptyFields);

    protected function removeEmptyFields($data)
    {
        return array_filter($data, function($value) { return !is_null($value) && $value !== ''; });
    }
}
