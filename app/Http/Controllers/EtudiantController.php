<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EtudiantRequest;
use App\Etudiant;
use Symfony\Component\HttpFoundation\Response;


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
            case "1CS":{
                return chr(mt_rand(1,2)+64); // 1CS A Ou B
            break;
            }
            case "2CS": {
                $specialite=['SIQ','SIT','SIL']; //2cs SIQ,SIL Ou SIT
                return $specialite[mt_rand(0,2)];
            break;
            }
            case "3CS" :{
                $specialite=['SIQ','SIT','SIL']; //2cs SIQ,SIL Ou SIT
                return $specialite[mt_rand(0,2)];
            break;
            }
            default : {
                return chr(mt_rand(1,3)+64);//1,2CP A,B OU C
            break;
            }
        }
    }
    public function generer_groupe($niv,$sect){
        switch ($niv) {
            case "1CS": {
                if ($sect=='A') return mt_rand(1,4);
                else return mt_rand(1,4)+4;
            break;
            }
            case "2CS":  {
                return mt_rand(1,2);
            break;
            }
            case "3CS": {
                return mt_rand(1,2);
            break;
            }
            default : {
                if ($sect=='A') return mt_rand(1,3);
                else if ($sect=='B') return mt_rand(1,3)+3;
                else if ($sect=='C') return mt_rand(1,3)+6;
            break;
            }
        }

    }
    public function generer_niveau(){
        $niv=['1CP','2CP','1CS','2CS','3CS'];
        return $niv[mt_rand(0,4)];
    }
    /************** CRUD FUNCTIONS***************************/
    public function index() { //Récupère tous les étudiants dans un tableau $etudiants
        $etudiants = Etudiant::all(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
        $etudiants_tout=Etudiant::all(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
        return array('consultation'=>$etudiants,'form'=>$etudiants_tout);
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
            $etudiant->date_naissance=date('Y/d/m',strtotime($infos['date_naissance']));
            $etudiant->adresse=$infos['adresse'];
            $etudiant->numero=$infos['num'];
            $etudiant->niv=$this->generer_niveau();
            $etudiant->sect=$this->generer_section($etudiant->niv);
            $etudiant->grp=$this->generer_groupe($etudiant->niv,$etudiant->sect);
            $etudiant->save();
            return response(null, Response::HTTP_CREATED);
        }
        else return response(null, Response::HTTP_IM_USED); //Existe déjà
    }


    public function update($numero, EtudiantRequest $request) { //Modifie étudiant dont l'id = $id
        $id=Etudiant::where('numero',$numero)->value('id');
        $etudiant = Etudiant::find($id);
        $etudiant->update($request->all());
        return response(null, Response::HTTP_MODIFIED);
    }


    public function destroy ($numero) {//Supprime un étudiant
        $id=Etudiant::where('numero',$numero)->value('id');
        $etudiant = Etudiant::destroy($id);
        return response(null, Response::HTTP_OK);
    }
}

