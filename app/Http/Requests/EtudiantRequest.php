<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EtudiantRequest extends FormRequest
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
            'nom' => 'required|alpha|max:30',
            'prenom' => 'required|alpha|max:30',
            'date_naissance' => 'required|date|before:today',
            'adresse' => 'required|string',
            'num' => 'required|digits:10|starts_with:"05","06","07"'
        ];
    }

      /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            /******* Contrôles du nom et prénom : *********/
            'nom.required' => ' Le champs nom est obligatoire!',
            'nom.alpha' => ' Le nom ne doit contenir que des lettres !',
            'nom.max' => ' Le nom ne doit pas dépasser 30 lettres',

            'prenom.required' => 'Le champs prénom est obligatoire!',
            'prenom.alpha' => 'Le prénom ne doit contenir que des lettres !',
            'prenom.max' => 'Le prénom ne doit pas dépasser 30 lettres',

            /******Contrôles de la date de naissance :******/
            'date_naissance.required' => 'Le champs date de naissance est obligatoire!',
            'date_naissance.date' => 'Veuillez introduire un format de date correct !',
            'date_naissance.before' => 'La date de naissance ne doit pas dépasser celle d\' aujourd\'hui!',

            /***** Contrôle de l'adresse ******/
            'adresse.required' => 'Le champs adresse est obligatoire!',

            /***** Contrôle du numéro de téléphone ******/
            'num.required' => 'Le champs numéro de téléphone est obligatoire!',        
            'num.digits' => 'Le numéro de téléphone doit contenir 10 chiffres et aucun autre caractère !',
            'num.starts_with' => 'Veuillez introduire un format valide du numéro!',
            
        ];
    }


}
