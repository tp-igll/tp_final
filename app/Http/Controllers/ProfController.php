<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Prof;
use App\User;
use App\Etudiant;

class ProfController extends Controller
{
    public function index ($id) { //Affiche la liste d'étudiants du prof dont l'id=$id
        $prof=User::where('id',$id)->first(['email','type']);
        if ($prof['type']!=1) return response(null, Response::HTTP_NOT_FOUND); //l'id n'est pas d'un prof
        $email=$prof['email'];
        $grp_sect=Prof::where('email',$email)->first(['liste_grp','liste_sect']);
        if ($grp_sect['liste_sect']!=null) {
              //Lister les étudiants de sa section
              $liste_sections=strtok($grp_sect['liste_sect'],","); //Forme de liste_sections = section1,section2,...
              $premier=true; 
              $donne_niveau=true; //Savoir si on est au niveau ou section
              while ($liste_sections!==false) {
                  $section=strtok($liste_sections,"/"); // Forme de chaque section = niveau/section
                  while ($section!==false){
                      if ($donne_niveau) {
                          $niv=$section;
                          $donne_niveau=false; 
                      }
                      else { //On est entrain de lire la section
                          $sect=$section; 
                          $donne_niveau=true; 
                      }
                      $section=strtok("/");
                  }
                  if ($premier) {
                      $etudiants1=Etudiant::where([ ['sect',$sect] , ['niv',$niv], ])
                      ->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                      $etudiants_tout1=Etudiant::where([ ['sect',$sect] , ['niv',$niv], ])
                      ->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();             
                      $premier=false;
                  }
                  else {
                      $etudiants_tmp=Etudiant::where([ ['sect',$sect] , ['niv',$niv], ])
                      ->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                      $etudiants_tout_tmp=Etudiant::where([ ['sect',$sect] , ['niv',$niv], ])
                      ->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
                      $etudiants1=array_merge($etudiants1,$etudiants_tmp);
                      $etudiants_tout1=array_merge($etudiants_tout1,$etudiants_tout_tmp);
                  }
                  $liste_sections=strtok(",");
              }
        }

        if ($grp_sect['liste_grp']!=null) {
            //Liste les groupes
            $liste_groupes=strtok($grp_sect['liste_grp'],","); //Forme de liste_groupes=groupe1,groupe2..
            $premier=true; //Indique si on lit le premier dans la liste de groupe
            $donne_niveau=true; //Savoir si on est au niveau ou groupe
            while ($liste_groupes!==false) {
                $groupe=strtok($liste_groupes,"/"); //Forme des groupes = niveau/groupe
                while ($groupe!==false){
                    if ($donne_niveau) {
                        $niv=$groupe;
                        $donne_niveau=false; 
                    }
                    else {
                        $grp=$groupe;
                        $donne_niveau=true;
                    }
                    $groupe=strtok("/");
                }
                
                if ($premier) {
                    $etudiants2=Etudiant::where([ ['grp',$grp] , ['niv',$niv] ])
                    ->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                    $etudiants_tout2=Etudiant::where([ ['grp',$grp] , ['niv',$niv] ])
                    ->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
                    $premier=false;
                }
                else {
                    $etudiants_tmp=Etudiant::where([ ['grp',$grp] , ['niv',$niv] ])
                    ->get(['nom','prenom','grp','email','sect','niv','matricule'])->toArray();
                    $etudiants_tout_tmp=Etudiant::where([ ['grp',$grp] , ['niv',$niv] ])
                    ->get(['nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'])->toArray();
                    $etudiants2=array_merge($etudiants2,$etudiants_tmp);
                    $etudiants_tout2=array_merge($etudiants_tout2,$etudiants_tout_tmp);
                }
                $liste_groupes=strtok(",");
            }
        }
        if (($grp_sect['liste_grp']!=null) && ($grp_sect['liste_sect']!=null)) {
            if (($etudiants2!=null) && ($etudiants1!=null)) {
                $etudiants=array_merge($etudiants1,$etudiants2);
                $etudiants_tout=array_merge($etudiants_tout1,$etudiants_tout2);
            }
            else return response(null, Response::HTTP_NOT_FOUND);       
        }
        else if ($grp_sect['liste_grp']!=null){
            if ($etudiants2!=null){
                $etudiants=$etudiants2;
                $etudiants_tout=$etudiants_tout2;
            }
            else return response(null, Response::HTTP_NOT_FOUND);  //groupe inexistant à l'esi
        }
        else {
            if ($etudiants2!=null) {
                $etudiants=$etudiants1;
                $etudiants_tout=$etudiants_tout1;
            }
            else return response(null, Response::HTTP_NOT_FOUND); //section inexistante à l'esi
        }
        return array('consultation'=>$etudiants,'form'=>$etudiants_tout);
    }
}
