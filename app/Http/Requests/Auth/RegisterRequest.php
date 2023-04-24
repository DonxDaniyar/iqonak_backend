<?php

namespace App\Http\Requests\Auth;

use App\Contracts\Validations\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'middle_name' => ['nullable'],
            'iin' => ['required','string','max:12', 'min:12'],
            'password' => ['required'],
            'phone_number' => ['required', new PhoneNumber, 'unique:users,phone_number']
        ];
    }
}
