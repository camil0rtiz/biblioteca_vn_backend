<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class agregarLibroRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo_libro' => 'required|string',
            'isbn_libro' =>'required|string',
            'dewey_libro' =>'required|string',
            'resena_libro' =>'required|string',
            'numero_pagi_libro' => 'required|numeric',
            'categoria_libro' => 'required|string',
            'fecha_publi_libro' => 'required|date',
            'estado_libro' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            // 'unique' => 'El campo :attribute ya existe',
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser de tipo string',
            'numeric' => 'El campo :attribute debe ser de tipo number',
            'date' => 'El campo :attribute debe ser del tipo date',
            // 'max' => 'El campo :attribute debe contener como máximo 45 caracteres',
            // 'min' => 'El campo :attribute debe contener como mínimo 8 caracteres'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(['error' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST)
        );
    }
}
