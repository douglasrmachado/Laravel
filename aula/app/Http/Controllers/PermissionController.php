<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\PermissionRepository;

use App\Repositories\RoleRepositories;

use App\Repositories\ResourceRepository;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct() {
        $this->repository = new PermissionRepository();
    }

    public function index () {

        $data = $this->repository->selectAllWith(['role', 'resource']);

        return $data;
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        
        $objRole = (new RoleRepository() )->findById($request->role_id);

        $objResource = (new ResourceRepository())->findById($request->resource_id);

        if(isset($objRole) && isset($objResource)) {

            $obj = new Permission();
            
            $obj->permission = $request->permissao;

            $obj->role()->associate($objRole);

            $obj->resource()->associate($objResource);
            
            $this->repository->save($obj);
            
            return "<h1>Store - OK!</h1>";

        }

        return "<h1>Store - Not found Role or Resource!</h1>";
    }

    public function show(string $id) {
            
        $data = $this->repository->findByCompositeIdWith(
            
            Permission::getKeys(),
            explode("__", $id),
            ['role', 'resource']
        );
            
        return $data;
            
    }    

    public function edit(string $id) {

        //
    }

    public function update(Request $request, string $id) {
        
        $obj = $this->repository->findByCompositeId(

            Permission::getKeys(),

            explode("__", $id)
        );

        $objRole = (new RoleRepository())->findById($request->role_id);
        
        $objResource = (new ResourceRepository())->findById($request->resource_id);

        if(isset($obj) && isset($objRole) && isset($objResource)) {

        
        if($this->repository->updateCompositeId(

            Permission::getKeys(),
            
            explode("__", $id),

            "permissions",

            [

                "permission" => $request->permissao

            ]
        
        ))
        {
            
            return "<h1>Update - OK!</h1>";
        
        }
    
    }
        
        return "<h1>Update - Not found Eixo!</h1>";
        
    }

    public function destroy(string $id) {

        if($this->repository->deleteCompositeId (
            
            Permission::getKeys(),

            explode("__", $id),

            "permissions"

        ))
            
        {
        
            return "<h1>Delete - OK!</h1>";
            
        }

        return "<h1>Delete - Not found Eixo!</h1>";
    }

}
