<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComercialController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function performance()
    {
        return view('welcome');
    }

    public function getSubjects(Request $request,UserRepository $consultors)
    {
        if (count($request->all()) == 1 && $request->has('type') ){
            return response()->json($consultors->allConsultors(),200);
        }

        $validate = Validator::make($request->all(),[
            'users'=>'required|array|min:1',
            'periodoInicio'=>'required|date|before_or_equal:periodoFin',
            'periodoFin'=>'required|date|after_or_equal:periodoInicio',
            'type'=>'required|string',
        ]);

        if($validate->fails()){
            return response()->json([
                'message'=>'Error en los parametros enviados',
                'errors'=>$validate->errors()
            ],422);
        }

        $datos = (object)$request->all();

        $tablaDatos = [];
        $tablaPizza = [];
        $tablaBar = [];

        foreach ($datos->users as $user)
        {
         $data= $consultors->getReceitas([$user]);
         $data= $data->whereBetween('periodo',[Carbon::parse($datos->periodoInicio)->format('Y-m'),Carbon::parse($datos->periodoFin)->format('Y-m')]);
         $receta_liquida_total = $data->sum('receta_liquida');
         $periodos = [];
         foreach ($data as $item){
             $periodos[] = [
                 'periodo' => Carbon::parse($item->periodo)->format('F Y'),
                 'receita_liquida' => $item->receta_liquida,
             ];
             $tablaDatos[$item->no_usuario][] = [
                 'Período' => Carbon::parse($item->periodo)->format('F Y'),
                 'Receita Líquida' => $item->receta_liquida,
                 'Custo Fixo' => $item->costo_fijo,
                 'Comissão' => $item->comision,
                 'Lucro' => $item->lucro
             ];
         }
            $tablaPizza[] = [
                'name'=>$user,
                'receita_liquida'=>$receta_liquida_total
            ];
            if (count($data) > 0){
                $tablaBar[] = [
                    'name'=>$user,
                    'periodos'=>$periodos,
                    'promedio'=>round($receta_liquida_total / count($periodos), 2),
                ];
            }

        }

        $receta_liquida_total = collect($tablaPizza)->sum('receita_liquida');
        if ($data->count() > 0){

            foreach ($tablaPizza as $key=>$item)
            {
                $tablaPizza[$key]['receita_liquida'] = round(($item['receita_liquida']/$receta_liquida_total)*100,2);
            }
        }

        return response()->json([
            'data'=>$data,
            'tablaDatos'=>$tablaDatos,
            'tablaPizza'=>$tablaPizza,
            'tablaBar'=>$tablaBar,
        ]);
    }

}
