<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use app\Etudiant;
//$this->assertTrue(true);

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function un_etudiant_peut_etre_inscrit_par_un_formulaire()
    {
        $response=$this->post('/inscription',[
            'nom'=>'mouri',
            'prenom'=>'samy',
            'date_naissance'=>'05/03/2002',
            'adresse'=>'reghaia rouiba',
            'numero'=>'0555223311'
        ]);
        $this->assertCount(Etudiant::count(),Etudiant::all());
        
    }
}
