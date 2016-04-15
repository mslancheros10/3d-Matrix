<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Matrix;

use Response;

class MatrixController extends Controller
{

	private $pathFile = "";

	private $resultFile = __DIR__ . '/../../../public/storage/result.txt';

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function show(Request $request)
	{
		$this->saveFile($request->file('file'));
		$this->createOutputFile($this->processFile());
		$headers = array(
              'Content-Type: text/plain',
            );
        return Response::download($this->resultFile, 'result.txt', $headers);
	}


	private function saveFile(UploadedFile $file){
		$nombre = $file->getClientOriginalName();
		\Storage::disk('local')->put($nombre,  \File::get($file));
		$this->pathFile = \Storage::disk('local')->url($file->getClientOriginalName());
	}

	private function processFile(){
		//$_fp = fopen($this->pathFile, "r");
		$_fp = fopen(__DIR__ . '/../../../public/' . $this->pathFile, "r");
		$cases = 0;
		$output = "";
		while(!feof($_fp)) {
			$cases = $cases > 0 ? $cases : fgets($_fp);
			$matrix = new Matrix();
			$tmp = explode(" ", fgets($_fp));
			$transactions =  (int)$tmp[1];
			$i = 0;
			while($i<$transactions){
				$lineTrx =  explode(" ", fgets($_fp));
				if(strcmp($lineTrx[0],"UPDATE")==0){
					$matrix->updateMatrix((int)$lineTrx[1], (int)$lineTrx[2], (int)$lineTrx[3], (int)$lineTrx[4]);
				}else{
					$output = $output . $matrix->queryMatrix((int)$lineTrx[1], (int)$lineTrx[2], (int)$lineTrx[3],(int)$lineTrx[4],(int)$lineTrx[5],(int)$lineTrx[6]) . "\r\n";
				}
				$i++;
			}
		}
		fclose($_fp);
		return $output;

	}

	private function createOutputFile($output){
		$out = fopen($this->resultFile, 'w');
		fputs($out, $output);
		fclose($out);
	}
}
