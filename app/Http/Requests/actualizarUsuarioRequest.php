<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class actualizarUsuarioRequest extends FormRequest
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
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'numero_casa_usuario' => 'required|numeric',
            'calle_usuario' => 'required|string',
            'fecha_naci_usuario' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser de tipo string',
            'email' => 'El formato del email es incorrecto',
            'numeric' => 'El campo :attribute debe ser de tipo number',
            'date' => 'El campo :attribute debe ser del tipo date',
            'max' => 'El campo :attribute debe contener como máximo 45 caracteres'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST)
        );
    }
}
