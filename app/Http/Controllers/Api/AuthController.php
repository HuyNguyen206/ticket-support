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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(statusCode: Response::HTTP_NO_CONTENT);
    }
}
