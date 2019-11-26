<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Etudiant;
//$this->assertTrue(true);

class EtudiantTest extends TestCase
{
    /**************Les tests d'inscription************/
    /** @test */
    /**
     * un_etudiant_peut_etre_inscrit_par_un_formulaire
     *
     * @return void
     */
    public function un_etudiant_peut_etre_inscrit_par_un_formulaire()
    {
        $info=[
            'nom'=>'gouttel',
            'prenom'=>'zakaria',
            'date_naissance'=>'05/04/2002',
            'adresse'=>'reghaia rouiba',
            'num'=>'0555223315'
        ];
        $response=$this->post('/inscription',$info);
        $this->assertCount(Etudiant::count(),Etudiant::all());
        $response->assertStatus(201);
    }

    /** @test */
    public function un_etudiant_deja_existant_ne_peut_pas_etre_inscrit()
    {
        $info=[
            'nom'=>'mouri',
            'prenom'=>'samy',
            'date_naissance'=>'05/03/2002',
            'adresse'=>'reghaia rouiba',
            'num'=>'0555223311'
        ];
        $response=$this->post('/inscription',$info);
        $response->assertStatus(226);
    }

    /** @test */
    public function un_etudiant_ne_peut_pas_laisser_des_champs_vides()
    {
        $info=[
            'nom'=>'',
            'prenom'=>'sihem',
            'date_naissance'=>'05/04/2002',
            'adresse'=>'',
            'num'=>'0555223312'
        ];
        $response=$this->post('/inscription',$info);
        $response->assertJson($info);
    }
}
