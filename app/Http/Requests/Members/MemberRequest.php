<?php

namespace App\Http\Requests\Members;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'last_name_kana' => 'required|string|max:191',
            'first_name_kana' => 'required|string|max:191',
            'email'     => 'required|string|max:191',
            'graduate'  => 'required|string|max:3',

//            'description' => 'required|string|max:1000',
//            'price' => 'required|numeric',
//            'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'last_name_kana' => 'required|string|max:191',
            'first_name_kana' => 'required|string|max:191',
            'email'     => 'required|string|max:191',
            'graduate'  => 'required|string|max:3',
        ];
    }
}
