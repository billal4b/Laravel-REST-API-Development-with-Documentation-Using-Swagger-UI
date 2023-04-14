<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use App\Http\Requests\ApiFormRequest;

class ProductUpdateRequest extends ApiFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        Log::debug("ID:: " . request()->id);
        return [
            'title' => 'required|string',
            'slug'  => 'required|string|unique:products,slug,'. request()->id,
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ];
    }
}
