<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Matrix;

use Response;

use Exception;

class MatrixController extends Controller
{

	/*
	*Guarda la ruta del archivo subido.
	*/
	private $pathFile = "";

	/*
	*Contiene la ruta del archivo a descargar
	*/
	private $resultFile = __DIR__ . '/../../../public/storage/result.txt';

    /**
	 * Función que recibe un request que contien el archivo del cliente mediante un método POST y devuelve un archivo con la respuesta
	 * según lo establecido en el ejercicio de HackerRank: https://www.hackerrank.com/contests/101jan14/challenges/cube-summation
	 *
	 * @param Request
	 *
	 * @return Response
	 */
	public function uploadFile(Request $request)
	{
		try{
			$this->saveFile($request->file('file'));
			$this->createOutputFile($this->processFile());
			$headers = array(
	              'Content-Type: text/plain',
	            );
	        return Response::download($this->resultFile, 'result.txt', $headers);
		}catch(\Exception $e){
			return Response::make('Se presentó un error al procesar el 
				archivo, asegurese que tenga extensión .txt y que
				la estructura sea la correcta.');
		}
		
	}

	/**
	 * Función que recibe un archivo y lo guarda en la carpeta public/storage
	 *
	 * @param UploadedFile
	 *
	 */
	private function saveFile(UploadedFile $file){

		try {
			$nombre = $file->getClientOriginalName();	
			\Storage::disk('local')->put($nombre,  \File::get($file));
			$this->pathFile = \Storage::disk('local')->url($file->getClientOriginalName());
		} catch (\Exception $e) {
			throw new Exception($e);
		}
		
	}

	/**
	 * Función encargada de procesar el archivo y generar una cadena con el resultado de las QUERIES realizadas.
	 *
	 * @return String
	 *
	 */
	private function processFile(){

		try {
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
					$lineTrx =  explode(' ', trim(fgets($_fp)));
					if(strcmp($lineTrx[0],"UPDATE")==0){
						$matrix->updateMatrix((int)$lineTrx[1], (int)$lineTrx[2], (int)$lineTrx[3], (int)$lineTrx[4]);
					}else{
						$output = $output . $matrix->queryMatrix((int)$lineTrx[1], (int)$lineTrx[2], (int)$lineTrx[3],(int)$lineTrx[4],(int)$lineTrx[5],(int)$lineTrx[6]) . "\r\n";
					}
					$i++;
				}
			}
			
			return $output;
		} catch (\Exception $e) {;
			throw new Exception($e->getMessage());
		}finally{
			fclose($_fp);
		}
		

	}

	/**
	 * Función que recibe una cadena y la guarda en un archivo de texto result.txt en public/storage
	 *
	 * @param String
	 *
	 */
	private function createOutputFile($output){

		try {
			$out = fopen($this->resultFile, 'w');
			fputs($out, $output);
		} catch (Exception $e) {
			throw new Exception($e);
		}finally{
			fclose($out);
		}
	}
}
