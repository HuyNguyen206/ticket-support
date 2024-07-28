<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Permissions\V1\Abilities;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Login
     *
     * Authenticates the user and return the user's API token
     * @unauthenticated
     * @group Authentication
     * @response 200 {
     *     {
     * "message": "Authentication successful",
     * "data": {
     * "access_token": "17|gM5R2a6TTVjFZenMSMCTqWoU93qSNlzINwpz7R4Na96ddd1e"
     * },
     * "status": 200
     * }
     * }
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data, true)) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::firstWhere('email', $data['email']);
        return $this->success('Authentication successful', [
            'access_token' => $user
                ->createToken("token_{$data['email']}", Abilities::getAbilities($user), now()->addMonth())->plainTextToken
        ]);
    }

    /**
     * Logout
     *
     *  Log out the user and delete user's API token
     * @group Authentication
     *
     * @response 204 {}
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(statusCode: Response::HTTP_NO_CONTENT);
    }
}
