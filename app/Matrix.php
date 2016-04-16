<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrix
{	
	/**
	*Guarda los diferentes UPDATES realizados de la sigiente manera: "x,y,z" => Valor
	*
	*/
    private $updatesArray = array();

    /**
    *Función encargada de agregar una tupla al arreglo $updatesArray
    *
    *@param $x
    *@param $y
    *@param $z
    *@param $value
    */
    public function updateMatrix($x,$y,$z,$value){
		$this->updatesArray[$x . "," . $y . "," . $z] = $value;
	}

	/**
    *Función de realizar la operación QUERY dentro de la matriz y devuelve el resultado.
    *
    *@param $x1
    *@param $y1
    *@param $z1
    *@param $x2
    *@param $y2
    *@param $z2
    *
    *@return $count
    */
	public function queryMatrix($x1,$y1,$z1,$x2,$y2,$z2){
		$count=0;
		foreach ($this->updatesArray as $key => $value) {
		    $coord = explode(',', $key);
		    $x = (int)$coord[0];
		    $y = (int)$coord[1];
		    $z = (int)$coord[2];

		    if($x>=$x1 and $x<=$x2 and $y>=$y1 and $y<=$y2 and $z>=$z1 and $z<=$z2){
		    	$count += (int)$value;
		    }
		}

		return $count;
	}


}
