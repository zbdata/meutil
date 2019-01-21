<?php
namespace App\Http\Requests\Admin;

use App\ControleDoPonto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateControleDoPontosRequest extends FormRequest
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
        return ControleDoPonto::updateValidation($this);
    }
}
