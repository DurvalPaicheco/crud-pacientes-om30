<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PatientEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return true;
    // }

    /**Dont need it */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => 'required|cpf',
            'name' => 'required',
            'mother_name' => 'required',
            'birthdate' => 'required|date_format:d/m/Y',
            'cns' => 'required|cns',
            'address' => 'required|array',
            'address.street' => 'required',
            'address.number' => 'required',
            'address.neighborhood' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'address.city' => 'required',
            'address.cep' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'O CPF(Cadastro de Pessoas Físicas) é um campo obrigatório',
            'name.required' => 'O nome é um campo obrigatório',
            'picture.required' => 'A foto é um campo obrigatório',
            'mother_name.required' => 'O nome da mãe é um campo obrigatório',
            'birthdate.required' => 'A data de nascimento é um campo obrigatório',
            'cns.required' => 'O CNS(Cartão Nacional de Saúde) é um campo obrigatório',
            'street.required' => 'A rua é um campo obrigatório',
            'number.required' => 'O número é um campo obrigatório',
            'neighborhood.required' => 'O bairro é um campo obrigatório',
            'city.required' => 'A cidade é um campo obrigatório',
            'state.required' => 'O estado é um campo obrigatório',
            'cep.required' => 'O CEP é um campo obrigatório',
            'cpf.cpf' => 'CPF(Cadastro de Pessoas Físicas) inválido',
            'cns.cns' => 'CNS(Cartão Nacional de Saúde) inválido',
            'cns.unique' => 'CNS(Cartão Nacional de Saúde) já cadastrado',
            'cpf.unique' => 'CPF(Cadastro de Pessoas Físicas) já cadastrado',
        ];
    }

   

    

}
