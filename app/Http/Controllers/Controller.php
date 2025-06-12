<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function parseOutletAndUnique($param1, $param2 = null): array
    {
        if ($param2 === null) {
            return [null, $param1];
        }

        return [$param1, $param2];
    }
}
