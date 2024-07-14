<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queryBuilder = User::query();

        if ($this->include('tickets')) {
            $queryBuilder->with('tickets');
        }

        return $this->success(data: UserResource::collection($queryBuilder->paginate())->resource);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($this->include('tickets')) {
            $user->load('tickets');
        }

        return $this->success(data: new UserResource($user));
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
