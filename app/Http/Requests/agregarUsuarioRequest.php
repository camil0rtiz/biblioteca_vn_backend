<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class agregarUsuarioRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rut_usuario' => 'required|unique:users,rut_usuario|string|max:11',
            'nombre_usuario'=>'required|string|max:45',
            'apellido_pate_usuario'=>'required|string|max:45',
            'apellido_mate_usuario'=>'required|string|max:45',
            'email' => 'required|string|unique:users,email|email|max:45',
            'password' => 'required|string|min:8',
            'numero_casa_usuario' => 'required|numeric',
            'calle_usuario' => 'required|string',
            'fecha_naci_usuario' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'unique' => 'El campo :attribute ya existe',
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser de tipo string',
            'email' => 'El formato del email es incorrecto',
            'numeric' => 'El campo :attribute debe ser de tipo number',
            'date' => 'El campo :attribute debe ser del tipo date',
            'max' => 'El campo :attribute debe contener como máximo 45 caracteres',
            'min' => 'El campo :attribute debe contener como mínimo 8 caracteres'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST)
        );
    }
}
