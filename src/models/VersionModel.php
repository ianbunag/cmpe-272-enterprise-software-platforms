<?php

namespace Models;

class VersionModel
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = __DIR__ . '/../../VERSION';
    }

    public function gerVersion(): string
    {
        if (!file_exists($this->filePath)) {
            return "0.0." . time();
        }

        return trim(file_get_contents($this->filePath));
    }
}

