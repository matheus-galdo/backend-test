<?php

namespace App\Http\Requests;

use App\Rules\ValidUrlRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRedirectRequest extends FormRequest
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
            'url' => ['url:https', 'starts_with:https', new ValidUrlRule()],
            'status' => ['string', Rule::in(['active', 'inactive'])],
        ];
    }
}
