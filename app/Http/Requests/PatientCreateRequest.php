<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PatientCreateRequest extends FormRequest
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
            'cpf' => 'required|cpf|unique:patients',
            'name' => 'required',
            'picture' => 'required',
            'mother_name' => 'required',
            'birthdate' => 'required|date_format:d/m/Y',
            'cns' => 'required|cns|unique:patients',
            'address.street' => 'required',
            'address.number' => 'required',
            'address.neighborhood' => 'required',
            'address.state' => 'required',
            'address.city' => 'required',
            'address.zip_code' => 'required',
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
            'address.street.required' => 'A rua é um campo obrigatório',
            'address.number.required' => 'O número é um campo obrigatório',
            'address.neighborhood.required' => 'O bairro é um campo obrigatório',
            'address.city.required' => 'A cidade é um campo obrigatório',
            'address.state.required' => 'O estado é um campo obrigatório',
            'address.zip_code.required' => 'O CEP é um campo obrigatório',
            'cpf.cpf' => 'CPF(Cadastro de Pessoas Físicas) inválido',
            'cns.cns' => 'CNS(Cartão Nacional de Saúde) inválido',
            'cns.unique' => 'CNS(Cartão Nacional de Saúde) já cadastrado',
            'cpf.unique' => 'CPF(Cadastro de Pessoas Físicas) já cadastrado',
        ];
    }

   

    

}
