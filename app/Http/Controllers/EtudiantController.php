<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EtudiantRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Etudiant;
use App\User;
use App\Prof;


class EtudiantController extends Controller
{
    /**
     * La fonction matricule génère un matricule pour un étudiant lors de l'inscription
     *
     * @return $matricule
     */
    public function matricule(){
        $rang=Etudiant::count()+1;
        if (($rang>=1) && ($rang<10)) $matricule=date('y').'/000'.$rang;
        else if (($rang>=10) && ($rang<99)) $matricule=date('y').'/00'.$rang;
        else $matricule=date('y').'/0'.$rang;
        return $matricule;
    }

    /**
     * La fonction create_email crée un e-mail pour un étudiant lors de l'inscription 
     * @param $nom le nom de l'étudiant
     * @param $prenom prénom de l'étudiant
     * @return $email l'émail de l'étudiant
     */

    public function create_email($nom,$prenom) {
        $date=date('y');
        $rang = ((int) $date) - 9+96 ;
        return chr($rang).$prenom[0].'_'.$nom.'@esi.dz';
    }

    /**
     * La fonction generer_section génère aléatoirement une section pour un étudiant selon son niveau
     *
     * @param  $niv Le niveau de l'étudiant
     *
     * @return $section la section de l'étudiant
     */
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
    /**
     *La fonction generer_groupe affecte aléatoirement un étudiant à son groupe suivant son niveau et sa section 
     *
     * @param  $niv Le niveau de l'étudiant
     * @param  $sect La section de l'étudiant
     *
     * @return $groupe Le groupe de l'étudiant
     */
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
    /**
     *La fonction generer_niveau génère un niveau a un étudiant d'une manière aléatoire
     *
     * @return $niveau Le niveau de l'étudiant
     */
    public function generer_niveau(){
        $niv=['1CP','2CP','1CS','2CS','3CS'];
        return $niv[mt_rand(0,4)];
    }
    /************** CRUD FUNCTIONS***************************/
    /**
     * La fonction index récupère tous les étudiants dans un tableau 
     *
     * @return $etudiants Tableau qui contient la liste d'étudiants
     */
    public function index($id) { //Récupère tous les étudiants dans un tableau $etudiants
        $type=User::where('id',$id)->value('type');
        if (is_null($type)) return response("id inexistant",Response::HTTP_NOT_FOUND);
        else  {
            switch ($type) {
                case 0: {//Cas d'admin
                    $etudiants = Etudiant::all(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                    $etudiants_tout=Etudiant::all(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
                break;
                } 
                case 1: {//Cas d'un prof
                    $email=User::where('id',$id)->value('email');
                    $grp_sect=Prof::where('email',$email)->first(['liste_grp','liste_sect']);
                    $etudiants=Etudiant::where([
                       ['sect',$grp_sect['liste_sect']],
                       ['grp',$grp_sect['liste_grp']],
                    ])->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                    if (!($etudiants)) return response(null,Response::HTTP_NOT_FOUND);
                    $etudiants_tout=Etudiant::where([
                        ['sect',$grp_sect['liste_sect']],
                        ['grp',$grp_sect['liste_grp']],
                     ])->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();           
                break;
                }
                case 2: {//Cas d'un étudiant
                    $email=User::where('id',$id)->value('email');
                    if (!($email)) return response(null,Response::HTTP_NOT_FOUND);
                    else {
                        $groupe=Etudiant::where('email',$email)->value('grp');
                        $sect=Prof::where('email',$email)->value('sect');
                        $etudiants=Etudiant::where([
                           ['sect',$sect],
                           ['grp',$groupe],
                        ])->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                        $etudiants_tout=Etudiant::where([
                            ['sect',$sect],
                            ['grp',$groupe],
                         ])->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
                    }
                break;
                }
            }
            return array('consultation'=>$etudiants,'form'=>$etudiants_tout);
        }
        
    }

    public function create() {
        return view('app');
    }

    /**
     * La fonction store inscrit un étudiant dans la base de données
     *
     * @param  $request Les données (informations) de l'étudiant
     *
     * 
     */
    public function store(EtudiantRequest $request) { //INSCRIT UN ETUDIANT DANS LA BDD
        $validator = Validator::make($request->all(),$request->rules(),$request->messages());
        if ($validator->fails()) return response()->json($validator->errors());
        else {
            if (!(Etudiant::where('numero',$request->input('num'))->first())) {
                $etudiant = new Etudiant();
                $etudiant->nom=$request->input('nom');
                $etudiant->prenom=$request->input('prenom');
                $etudiant->email=$this->create_email($request->input('nom'),$request->input('prenom'));
                $etudiant->matricule=$this->matricule();
                $etudiant->date_naissance=date('Y/d/m',strtotime($request->input('date_naissance')));
                $etudiant->adresse=$request->input('adresse');
                $etudiant->numero=$request->input('num');
                $etudiant->niv=$this->generer_niveau();
                $etudiant->sect=$this->generer_section($etudiant->niv);
                $etudiant->grp=$this->generer_groupe($etudiant->niv,$etudiant->sect);
                $etudiant->save();
                return response(null, Response::HTTP_CREATED); //Status_code = 201
                //return $validator->errors();
            }
            else return response(null, Response::HTTP_IM_USED); //Existe déjà //Status_code = 226
        }   
    }
    

    /**
     * La fonction update permet de modifier les données d'un étudiant
     *
     * @param  $numero Le numero de l'étudiant
     * @param  $request Les nouvelles données de l'étudiant
     *
     * 
     */
    public function update($numero, EtudiantRequest $request) { //Modifie étudiant dont l'id = $id
        $id=Etudiant::where('numero',$numero)->value('id');
        $etudiant = Etudiant::find($id);
        $etudiant->update($request->all());
        return response(null, Response::HTTP_MODIFIED);
    }


    /**
     * La fonction destroy permet de supprimer un étudiants de la base de données
     *
     * @param   $numero Le numéro de l'étudiant
     *
     * 
     */
    public function destroy ($numero) {//Supprime un étudiant
        $id=Etudiant::where('numero',$numero)->value('id');
        $etudiant = Etudiant::destroy($id);
        return response(null, Response::HTTP_OK);
    }
}

