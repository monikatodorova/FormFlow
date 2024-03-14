<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UsersRepository;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Bridge\UserRepository;

class UsersService {

    /**
     * Tries to authenticate the user with the provided email and password.
     * If successful, it will return a OAuth 2.0 Token.
     * @param $email
     * @param $password
     * @return Response
     */
    public static function authenticate($email, $password) {
        if(!UsersRepository::login($email, $password)) {
            return new Response([
                'status' => 'error',
                'message' => "Invalid email or password.",
            ], 401);
        }
        return new Response([
            'status' => 'success',
            'token' => UsersRepository::generateAccessToken(UsersRepository::getCurrentUser()),
        ], 200);
    }

    /**
     * Tries to register new user with the given data.
     * @param array $details
     * @return Response
     */
    public static function register(array $details) {
        $user = UsersRepository::createUser([
            'name' => $details['name'],
            'email' => $details['email'],
            'password' => $details['password']
        ]);

        return new Response([
            'status' => 'success',
            'token' => UsersRepository::generateAccessToken($user),
            'user' => $user->makeHidden(['created_at', 'updated_at', 'id']),
        ], 200);
    }

    public static function details() {
        $user = UsersRepository::getCurrentUser();
        if ($user->defaultProject !== null) {
            $user->defaultProject->makeHidden(['id']);
        }
        return new Response([
            'status' => 'success',
            'user' => $user->makeHidden(['created_at', 'updated_at', 'id'])
        ], 200);
    }

    public static function setDefaultProject($projectId) {
        $user = UsersRepository::getCurrentUser();
        $project = ProjectsRepository::getById($projectId);
        UsersRepository::setDefaultProject($user, $project);
        return new Response([
            'status' => 'success',
            'project' => $project,
        ], 200);
    }
}