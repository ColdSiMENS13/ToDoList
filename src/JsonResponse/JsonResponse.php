<?php

namespace App\JsonResponse;

use App\Interfaces\Response;

class JsonResponse implements Response
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function toResponse()
    {
        header("Content-Type: application/json");
        print_r(json_encode($this->data, JSON_PRETTY_PRINT));
    }
}