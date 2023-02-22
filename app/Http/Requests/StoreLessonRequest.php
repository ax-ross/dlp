<?php

namespace App\Http\Requests;

use App\Models\Image;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    public array $images;

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'max:65000',
            'attachments' => 'array',
            'attachments.*' => 'file',
            'imagePaths' => 'array',
            'imagePaths.*' => [function(string $attribute, mixed $value, Closure $fail) {
                if (!$this->images[] = Image::findImageByAbsolutePath($value)) {
                    $fail('invalid image path');
                }
            }]
        ];
    }
}
