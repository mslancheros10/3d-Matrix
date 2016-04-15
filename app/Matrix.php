<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrix
{
    private $updatesArray = array();


    public function getUpdatesArray(){
    	return $this->updatesMatrix;
    }

    public function updateMatrix($x,$y,$z,$value){
		$this->updatesArray[$x . "," . $y . "," . $z] = $value;
	}

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
