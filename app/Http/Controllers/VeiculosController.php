<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Veiculos;
use Validator;

class VeiculosController extends Controller
{
   

    protected function validar($request){
        $validator = Validator::make($request->all(),[
            'marca'=>'required',
            'modelo'=>'required',
            'ano'=>'required|numeric|min:0',
            'preco'=>'required|numeric|min:0',
        ]);
        return $validator;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $veiculos = Veiculos::all();

        return response()->json(['veiculos'=>$veiculos],200);
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validar($request);
        if($validator->fails()){
            return response()->json(['message'=>'Erro','errors'=>$validator->errors()],400);
        }

        
        $data  = $request->only(['marca','modelo','ano','preco']);

        if($data){
            $veiculos = Veiculos::create($data);
            if($veiculos){
                return response()->json(['data',$veiculos,201]);
            } else{
                return response()->json(['message'=>'Erro ao criar dados',400]);
            }
        } else {
            return response()->json(['message'=>'Dados inválidos',400]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       if($id<0){
           return response()->json(['message'=>'Id menor que zero, Informe um id válido',400]);
       }

       $veiculos = Veiculos::find($id);

       if($veiculos){
           return response()->json(['veiculos'=>$veiculos],200);
       } else {
        return response()->json(['message'=>'O veiculo com id '. $id.' não existe',400]);
       }
    } 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function update(Request $request, $id)
    {
        $validator = $this->validar($request);
        if($validator->fails()){
            return response()->json(['message'=>'Erro','errors'=>$validator->errors()],400);
        }

        
        $data  = $request->only(['marca','modelo','ano','preco']);

        if($data){
            $veiculos = Veiculos::find($id);
            if($veiculos){
                $veiculos->update($data);
                return response()->json(['data',$veiculos,200]);
            } else{
                return response()->json(['message'=>'O veiculo com id '. $id.' não existe',400]);
            }
        } else {
            return response()->json(['message'=>'Dados inválidos',400]);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id < 0){
            return responde()->json(['message'=>'O id é menor que zero, insira um id válido'],400);
        }

        $veiculos = Veiculos::find($id);

        if($veiculos){
            $veiculos->delete();
            return response()->json(['message'=>'O veiculo com id '.$id.' foi removido'],204);
        } else {
            return response()->json(['message'=>'O veiculo com id '. $id.' não existe'],404);
        }
    }
}
