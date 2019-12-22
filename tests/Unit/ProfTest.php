<?php

namespace Tests\Unit;

//use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    /** @test */
    public function prof_peut__lister_ses_etudiants () {
        $id=2; //id d'un prof déjà existant dans la bdd (Mr. Dib)
        $this->get('liste_prof/'.$id)
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
    public function prof_ne_peut_pas_lister_avec_groupe_inexistant () {
        $id=4; 
        $this->get('liste_prof/'.$id)->assertStatus(404);
    }

    /** @test */
    public function utilisateur_doit_etre_prof () {
        $id=1; 
        $this->get('liste_prof/'.$id)->assertStatus(404);
    }
}
