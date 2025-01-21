<?php

namespace catalyst\StarterKitRestApi\Http\Requests\Auth;

use catalyst\StarterKitRestApiHttp\Http\Requests\BaseRequest;
use catalyst\StarterKitRestApiHttp\Http\Requests\BaseRequestValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],

        ];
    }
}
