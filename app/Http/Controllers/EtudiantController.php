<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EtudiantRequest;
use App\Etudiant;


class EtudiantController extends Controller
{
    /**********************MY FUNCTIONS********************/
    public function matricule(){
        $rang=Etudiant::count()+1;
        if (($rang>=1) && ($rang<10)) $matricule=date('y').'/000'.$rang;
        else if (($rang>=10) && ($rang<99)) $matricule=date('y').'/00'.$rang;
        else $matricule=date('y').'/0'.$rang;
        return $matricule;
    }
    public function create_email($nom,$prenom) {
        $date=date('y');
        $rang = ((int) $date) - 9+96 ;
        return chr($rang).$prenom[0].'_'.$nom.'@esi.dz';
    }

    public function generer_section($niv){
        switch ($niv) {
            case 3:{
                return chr(mt_rand(1,2)+64); // 1CS A Ou B
            break;
            }
            case 4: {
                $specialite=['Q','T','L']; //2cs SIQ,SIL Ou SIT
                return $specialite[mt_rand(1,3)];
            break;
            }
            case 5 :{
            break; //3CS N'ont pas de section
            }
            default : {
                return chr(mt_rand(1,3)+64);//1,2CP A,B OU C
            break;
            }
        }
    }
    public function generer_groupe($niv,$sect){
        switch ($niv) {
            case 3: {
                if ($sect=='A') return mt_rand(1,4);
                else return mt_rand(1,4)+4;
            break;
            }
            case 4:  {
                return mt_rand(1,2);
            break;
            }
            case 5 : {break;}
            default : {
                if ($sect=='A') return mt_rand(1,3);
                else if ($sect=='B') return mt_rand(1,3)+3;
                else if ($sect=='C') return mt_rand(1,3)+6;
            break;
            }
        }

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
        $infos=$request->input()['0'];
        if (!(Etudiant::where('numero',$infos['num'])->first())) {
            $etudiant = new Etudiant();
            $etudiant->nom=$infos['nom'];
            $etudiant->prenom=$infos['prenom'];
            $etudiant->email=$this->create_email($infos['nom'],$infos['prenom']);
            $etudiant->matricule=$this->matricule();
            $etudiant->date_naissance=date('Y/m/d',strtotime($infos['date_naissance']));
            $etudiant->adresse=$infos['adresse'];
            $etudiant->numero=$infos['num'];
            $etudiant->niv=mt_rand(1,5);
            $etudiant->sect=$this->generer_section($etudiant->niv);
            $etudiant->grp=$this->generer_groupe($etudiant->niv,$etudiant->sect);
            $etudiant->save();
        }
        else return "existe";
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
