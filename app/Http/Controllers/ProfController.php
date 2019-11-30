<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prof;
use App\User;
use App\Etudiant;

class ProfController extends Controller
{
    public function index ($id) { //Affiche la liste d'étudiants du prof dont l'id=$id
        $email=User::where('id',$id)->value('email');
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
                      array_merge($etudiants1,$etudiants_tmp);
                      array_merge($etudiants_tout1,$etudiants_tout_tmp);
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
                    array_merge($etudiants2,$etudiants_tmp);
                    array_merge($etudiants_tout2,$etudiants_tout_tmp);
                }
                $liste_groupes=strtok(",");
            }
        }
        if (($grp_sect['liste_grp']!=null) && ($grp_sect['liste_sect']!=null)) {
            
            array_merge($etudiants1,$etudiants2);
            $etudiants=$etudiants1;return $etudiants;
            array_merge($etudiants_tout1,$etudiants_tout2);
            $etudiants_tout=$etudiants_tout1;
        }
        else if ($grp_sect['liste_grp']!=null){
            $etudiants=$etudiants2;
            $etudiants_tout=$etudiants_tout2;
        }
        else {
            $etudiants=$etudiants1;
            $etudiants_tout=$etudiants_tout1;
        }
        return array('consultation'=>$etudiants,'form'=>$etudiants_tout);
    }
}
