<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected function include(string $relationship)
    {
        $includeValues = ($include = \request()->get('include')) ? explode(',', $include): [];

        return in_array($relationship, $includeValues, true);
    }
}
