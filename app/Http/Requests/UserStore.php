<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
            'username' => 'alpha|unique:users,username',
            'email' => 'email:rfc,dns',
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
            'idRol' => 'required|integer',
            'cargo' => 'required'
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
            'idDependencia' => 'Area',
            'isPublico' => 'Atiende al público'
        ];
    }
}
