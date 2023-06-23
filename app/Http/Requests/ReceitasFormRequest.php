<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceitasFormRequest extends FormRequest
{
    use ErrosTrait;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'min:2'],
            'valor' => ['required', 'numeric', 'min:1'],
            'data' => ['required', 'date_format:d/m/Y'],
        ];
    }

    public function messages(): array
    {
        return [
            'descricao.required' => 'O campo descrição é obrigatório.',
            'descricao.min' => 'O campo descrição deve ter no mínimo :min caracteres.',
            'valor.required' => 'O campo valor é obrigatório.',
            'valor.numeric' => 'O campo valor deve ser um número.',
            'valor.min' => 'O campo valor deve ser no mínimo :min.',
            'data.required' => 'O campo data é obrigatório.',
            'data.date_format' => 'O campo data deve estar no formato DD/MM/YYYY.',
        ];
    }
}
