<?php

namespace BananaBuoy\Views;

abstract class BaseApiView
{
    /**
     * Render the data as JSON
     *
     * @param mixed $data Data to be JSON encoded
     */
    public function render($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

