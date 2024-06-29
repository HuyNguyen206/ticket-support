<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class ApiController extends Controller
{
    use ApiResponse;

    protected function include(string $relationship)
    {
        $includeValues = ($include = \request()->get('include')) ? explode(',', $include): [];

        return in_array($relationship, $includeValues, true);
    }
}
