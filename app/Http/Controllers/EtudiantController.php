<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Etudiant;
use Carbon\Carbon;

class EtudiantController extends Controller
{
    /**********************MY FUNCTIONS********************/
    public function matricule(){
        $date=Carbon::now()->toDateTimeString('y');
        $matricule=$date.'/'.$Etudiant::count();
    }
    public function create_email($nom,$prenom) {
        $date=Carbon::now()->toDateTimeString('y');
        $rang = ((int) $date) - 9+96 ;
        return chr($rang).$prenom[1].'_'.$nom.'@esi.dz';
    }

    /************** CRUD FUNCTIONS***************************/
    public function index() { //Récupère tous les étudiants dans un tableau $etudiants
        $etudiants = Etudiant::all(['nom','prenom','grp','email','date_naissance','adresse','matricule'])->toArray();
        return $etudiants;
    }

    public function create() {
        return view('app');
    }

    public function store(EtudiantRequest $request) { //INSCRIT UN ETUDIANT DANS LA BDD
        $etudiant = new Etudiant();
        $etudiant->nom=$request->input('nom');
        $etudiant->prenom=$request->input('prenom');
        $etudiant->email=create_email($request->input('nom'),$request->input('prenom'));
        $etudiant->matricule=matricule();
        $etudiant->date_naissance=$request->input('date_naissance')->toDateTimeString('Y/m/d');
        $etudiant->adresse=$request->input('adresse');
        $etudiant->numero=$request->input('num');
        $etudiant->save();
        return view('res',$etudiant);
        //return response($etudiant->jsonSerialize(), Response::HTTP_CREATED);
      }

    // edit etudiant
    public function edit($id)
    {
        $etudiant = Etudiant::find($id);
        return response(null, Response::HTTP_OK);
    }

    public function update($id, Request $request) { //Modifie étudiant dont l'id = $id
        $etudiant = Etudiant::find($id);
        $etudiant->update($request->all());
        return response(null, Response::HTTP_OK);
    }

    public function destroy ($id) {//Supprime un étudiant
        $etudiant = Etudiant::find($id);
        $etudiant->delete();

        return response(null, Response::HTTP_OK);
    }
}
