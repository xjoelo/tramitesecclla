<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
        return [
            'dni' => 'required|integer|digits:8',
            'nombres' => 'required',
            'apellidoPaterno' => 'required',
            'apellidoMaterno' => 'required',
            'iniciales' => 'required|max:10',
            'fechaNacimiento' => 'date',
            'celular' => 'required|integer|digits:9',
            'email' => 'email',
            'idDependencia' => 'required|integer',
            'username' => 'alpha|unique:users,username,'.$this->id,
            'password' => 'required|min:6',
            'isPublico' => 'required',
            'idRol' => 'required|integer'
        ];

    }

    public function attributes()
    {
        return [
            'idSucursal' => 'Sucursal',
            'idRol' => 'Rol',
            'password' => 'Contraseña',
            'username' => 'Usuario',
            'iniciales' => 'Iniciales(siglas)',
            'fechaNacimiento' => 'Fecha de Nacimiento',
            'idDependencia' => 'required|integer',
            'isPublico' => 'Atiende al público'
        
        ];
    }
}
