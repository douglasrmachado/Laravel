<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CursoRepository;

use App\Models\Curso;

use App\Repositories\EixoRepository;

use App\Repositories\NivelRepository;


class CursoController extends Controller
{
    protected $repository;

    public function __construct() {
        $this->repository = new CursoRepository();
    }


    public function index () {

        $data = $this->repository->selectAllWith(['eixo', 'nivel']);

        return $data;
    }

    public function create() {
        //
    }

    public function store(Request $request) {

        $objEixo = (new EixoRepository() ) -> findById($request->eixo_id);
        
        $objNivel = (new NivelRepository() ) -> findById($request->nivel_id);

        if(isset($objEixo) && isset($objNivel)) {
        
            $obj = new Curso();
            
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');

            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            
            $obj->total_horas = $request->horas;

            $obj->eixo() ->associate($objEixo);

            $obj->nivel() ->associate($objNivel);

            $this->repository->save($obj);
            
        
        return "<h1>Store - OK!</h1>";

        }

        return "<h1>Store - Not found Eixo or Nivel!</h1>";
    
    }

    public function show(string $id) {
            
        $data = $this->repository->findById($id);
            
        return $data;
            
    }    

    public function update(Request $request, string $id) {
        
        $objEixo = (new EixoRepository() ) -> findById($request->eixo_id);
        
        $objNivel = (new NivelRepository() ) -> findById($request->nivel_id);

            if(isset($obj) && (isset($objEixo) && isset($objNivel))) {
            
            
            $obj->nome = mb_strtoupper($request->nome, 'UTF-8');

            $obj->sigla = mb_strtoupper($request->sigla, 'UTF-8');
            
            $obj->total_horas = $request->horas;

            $obj->eixo() ->associate($objEixo);

            $obj->nivel() ->associate($objNivel);

            $this->repository->save($obj);
            
            return "<h1>Update - OK!</h1>";

        }

        return "<h1>Update - Not found Curso or Eixo or Nivel!</h1>";
    
    }

    public function destroy(string $id) {

        if($this->repository->delete($id)) {
            
            return "<h1>Delete - OK!</h1>";
            
        }
            
        return "<h1>Delete - Not found Curso!</h1>";
            
    }

}

