<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Policies\V1\UserPolicy;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;

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

    /**
     * Display a listing of the resource.
     */
    public function authors()
    {
        $queryBuilder = User::query();

        if ($this->include('tickets')) {
            $queryBuilder->with('tickets');
        }

        return $this->success(data: UserResource::collection(
            $queryBuilder->select('users.*')->join('tickets', 'users.id','tickets.user_id')
                ->distinct()->paginate())->resource
        );
    }

    public function storeAuthor(StoreUserRequest $storeUserRequest)
    {
        $this->isAbleTo('createAuthor', User::class);

        return UserResource::make(User::create(data_get($storeUserRequest->validated(), 'data.attributes')));
    }
}
