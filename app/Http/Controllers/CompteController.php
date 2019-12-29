<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class CompteController extends Controller
{
    /**
     * La fonction getType retourne le type du compte dont l'id est égale a l'id passé en parametres
     *
     * @param  mixed $id
     *
     * @return $type le type du compte
     */
    public function getType($id){ //Retourne le type du compte dont l'id = $id
        return User::where('id',$id)->value('type');
    }

    /**
     * La fonction genererId genere un id aléatoirement en donnant un chiffre entre 1 et le nombre des utilisateurs
     *
     * @return $id l'id généré
     */
    public function genererId() {
        return mt_rand(1,User::count());
    }
}
