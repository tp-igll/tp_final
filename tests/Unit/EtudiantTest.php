<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Etudiant;


class EtudiantTest extends TestCase
{
    /**************Les tests d'inscription************/
    private function data() {
        return [
            'nom'=>'mouri',
            'prenom'=>'samy',
            'date_naissance'=>'05/03/2002',
            'adresse'=>'lot reghaia',
            'num'=>'0555223312'
        ];
    }
    /**
     * un_etudiant_peut_etre_inscrit_par_un_formulaire
     *
     * @return void
     */
    /** @test */
    public function un_etudiant_peut_etre_inscrit_par_un_formulaire()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['num'=>'0558293767']));
        $this->assertCount(Etudiant::count(),Etudiant::all());
        $response->assertStatus(226);
    }

    /** @test */
    public function un_etudiant_deja_existant_ne_peut_pas_etre_inscrit()
    {
        $response=$this->post('/inscription',$this->data());
        $response->assertStatus(226);
    }

    /** @test */
    public function nom_ne_doit_contenir_que_des_lettres()
    {
        
        $response=$this->post('/inscription',array_merge($this->data(),['nom'=>'maroua02']));
        $response->assertSessionHasErrors('nom');
    }

    /** @test */
    public function prenom_est_requis ()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['prenom'=>'']));
        $response->assertSessionHasErrors('prenom');
    }

    /** @test */
    public function date_naissance_est_requise()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['date_naissance'=>'']));
        $response->assertSessionHasErrors('date_naissance');
    }
    
    /** @test */
    public function date_naissance_ne_doit_pas_depasser_celle_daujourdhui()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['date_naissance'=>'27/11/2020']));
        $response->assertSessionHasErrors('date_naissance');
    }

    /** @test */
    public function date_naissance_doit_avoir_un_format_correct()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['date_naissance'=>'27/112020']));
        $response->assertSessionHasErrors('date_naissance');
    }

    /** @test */
    public function numero_doit_avoir_un_format_correct()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['num'=>'0953242212']));
        $response->assertSessionHasErrors('num');
    }

    /** @test */
    public function numero_doit_etre_numerique()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['num'=>'0lmzd02']));
        $response->assertSessionHasErrors('num');
    }

    /** @test */
    public function numero_ne_doit_pas_depasser_dix_chiffres()
    {
        $response=$this->post('/inscription',array_merge($this->data(),['num'=>'05532422123']));
        $response->assertSessionHasErrors('num');
    }

    //****** Tests de liste: **********/
    /** @test */
    public function admin_peut_lister_tous_les_etudiants () {
        $id=1; //l'id de l'admin est par défaut 1
        $this->get('liste_other/'.$id)
        ->assertJsonStructure([
            'consultation'=> [
                '*' => [
                    'nom','prenom','grp','email','sect','niv','matricule'
                ],
            ],
            'form' => [
                '*' => [
                    'nom','prenom','grp','email','sect','niv','matricule','date_naissance','adresse','numero'
                ],
                
            ]
        ]);
    }

    /** @test */
    public function ne_peut_pas_lister_avec_id_inexistant () {
        $id=-1; 
        $this->get('liste_other/'.$id)->assertStatus(404);
    }
    
}
