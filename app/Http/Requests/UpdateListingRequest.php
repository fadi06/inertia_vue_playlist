<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'desc' => 'required',
            'tags' => 'nullable|string',
            'email' => 'nullable|email',
            'link' => 'nullable|url',
            'image' => 'nullable|file|max:3072|mimetypes:image/jpeg,image/png',
        ];
    }
}
