<?php

namespace Com\Daw2\Models;

use http\Exception\InvalidArgumentException;

class CSVModel {

    public function __construct(private string $filename) {
        if(!file_exists($filename)) {
            throw new InvalidArgumentException("File $filename does not exist");
        }
    }

    public function loadData() : array{
        $csvFile = file($this->filename);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line, ';');
        }
        return $data;
    }
}