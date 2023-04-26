<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecordRequest extends FormRequest
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
            'adult_people_in_group' => ['required'],
            'children_people_in_group' => ['nullable'],
            'student_in_group' => ['nullable'],
            'tenure' => ['required'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'visit_purpose_id' => ['required', 'exists:visit_purposes,id'],
            'place_of_direction_id' => ['required', 'exists:place_of_directions,id'],
            'services' => ['required']
        ];
    }
}
