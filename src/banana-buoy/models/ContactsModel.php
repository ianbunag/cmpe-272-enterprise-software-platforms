<?php

namespace BananaBuoy\Models;

class ContactsModel
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = __DIR__ . '/contacts.txt';
    }

    public function getContactEmail(): string
    {
        if (!file_exists($this->filePath)) {
            return '';
        }

        $content = file_get_contents($this->filePath);
        return trim($content ?: '');
    }
}

