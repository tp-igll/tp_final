<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class CompteController extends Controller
{
    public function getType($id){ //Retourne le type du compte dont l'id = $id
        return User::where('id',$id)->value('type');
    }

    public function genererId() {
        return mt_rand(1,User::count());
    }

    public function authentification(CompteRequest $request) {
        $email=$request->input('login');
        $mdp=$request->input('mdp');
        $real_mdp=User::where('email',$email)->first('password');
        if ($real_mdp==null) return -1;//code d'erreur du cas d'un email inexistant
        else if ($mdp!=$real_mdp) return 0; //code d'erreur du cas d'un mdp incorrect
        else return User::where('email',$email)->value('id');
    }
}
