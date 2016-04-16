<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Matrix;

class MatrixTest extends TestCase
{
    
    /** @test */
    public function firstTest()
    {	
        $matrix = new Matrix();
        $matrix->updateMatrix(2, 2, 2, 4);
        $this->assertTrue($matrix->queryMatrix(1, 1, 1, 3, 3, 3)== 4);
        $matrix->updateMatrix(1, 1, 1, 23);
        $this->assertTrue($matrix->queryMatrix(2, 2, 2, 4, 4, 4)== 4);
        $this->assertTrue($matrix->queryMatrix(1, 1, 1, 3, 3, 3)== 27);
    }

    /** @test */
    public function secondTest()
    {	
        $matrix = new Matrix();
        $matrix->updateMatrix(2, 2, 2, 1);
        $this->assertTrue($matrix->queryMatrix(1, 1, 1, 1, 1, 1)== 0);
        $this->assertTrue($matrix->queryMatrix(1, 1, 1, 2, 2, 2)== 1);
        $this->assertTrue($matrix->queryMatrix(2, 2, 2, 2, 2, 2)== 1);
    }
}
