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
    public function un_etudiant_peut_etre_inscrit_par_un_formulaire()
    {
        $info=[
            'nom'=>'mouri',
            'prenom'=>'samy',
            'date_naissance'=>'05/03/2002',
            'adresse'=>'reghaia rouiba',
            'num'=>'0555223311'
        ];
        $response=$this->post('/inscription',$info);
        $this->assertCount(Etudiant::count(),Etudiant::all());
        //$response->assertStatus(201);
              
    }
}
