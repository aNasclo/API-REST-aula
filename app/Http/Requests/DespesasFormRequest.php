<?php

namespace App\Http\Requests;

use App\Http\Requests\ErrosTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Validation\Rule;

class DespesasFormRequest extends FormRequest
{
    use ErrosTrait;
    
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => ['required', 'min:2'],
            'valor' => ['required', 'numeric', 'min:1'],
            'data' => ['required', 'date_format:d/m/Y'],
            'categorias' => ['nullable', 'in:Alimentação,Saúde,Moradia,Transporte,Educação,Lazer,Imprevistos,Outras'],
        ];
    }

        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
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
            'categorias.in' => 'O campo categorias só pode ser preenchido com Alimentação,Saúde,Moradia,Transporte,Educação,Lazer,Imprevistos ou Outras '
        ];
    }
}



// function ($attribute, $value, $fail) {
//     // Verifica se a data é válida
//     if (!strtotime($value)) {
//         $fail('O campo data deve ser uma data válida no formato DD/MM/YYYY.');
//     }
// }
// ],