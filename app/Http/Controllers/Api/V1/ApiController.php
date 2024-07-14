<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class ApiController extends Controller
{
    use ApiResponse;

    protected function include(string $relationship)
    {
        $includeValues = ($include = \request()->get('include')) ? explode(',', $include): [];

        return in_array($relationship, $includeValues, true);
    }

    protected function isAbleTo($action, Model|string $model): Response
    {
        return $this->authorize($action, property_exists($this, 'policyClass') ? [$model, $this->policyClass] : $model);
    }
}
