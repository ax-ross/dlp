<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailRegisterRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;
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
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'role' => ['required', Rule::in(['teacher', 'student'])],
            'invitation_code' => [Rule::requiredIf(fn () => $this->input('role') === 'student'), Rule::excludeIf(fn () => $this->input('role') === 'teacher')],
        ];
    }
}
