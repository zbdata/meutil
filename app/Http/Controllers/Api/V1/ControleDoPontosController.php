<?php

namespace App\Http\Controllers\Api\V1;

use App\ControleDoPonto;
use App\Http\Controllers\Controller;
use App\Http\Resources\ControleDoPonto as ControleDoPontoResource;
use App\Http\Requests\Admin\StoreControleDoPontosRequest;
use App\Http\Requests\Admin\UpdateControleDoPontosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use GuzzleHttp\Client;



class ControleDoPontosController extends Controller
{
    public function index()
    {
        //$end = "http://192.168.1.103:86/ponto";
        $end = "http://192.168.56.1:85/api/dot/1815441/20190101/20190131";
        $client = new Client();
        $registros = $client->request('GET', $end);
        $registros = $registros->getBody();

        $registros = json_decode($registros, true);
        $faltas =  new ControleDoPontoResource(ControleDoPonto::with(['matricula'])->get()->toArray());

        $ponto['data'] = [];

        foreach ($registros as $key_reg => $value_reg) {
            array_push($ponto['data'], 
                                ['id' => '',
                                'data' => $value_reg['data'],
                                'falta' => '',
                                'feriado' => '',
                                'entrada' => array_key_exists('entrada', $value_reg) ? $value_reg['entrada'] : '',
                                'saida' => array_key_exists('saida', $value_reg) ? $value_reg['saida'] : '',
                                'created_at' => '',
                                'updated_at' => '',
                                'deleted_at' => NULL,
                                ]);
        };

        foreach ($faltas as $falta) {
            if($falta){
                foreach ($falta as $key_falta=>$value_falta){
                    foreach ($ponto['data'] as $key_ponto => $value_ponto) {
                        if ($value_falta['data'] == $value_ponto['data']){
                            //data_set($ponto['data'], $key_ponto, $value_falta);
                            array_pull($ponto['data'], $key_ponto);
                        }
                    }
                    array_push($ponto['data'], $value_falta);
                }
            }
        };

        $ponto['data'] = array_values($ponto['data']);
        return json_encode($ponto);
        //return new ControleDoPontoResource(ControleDoPonto::with(['matricula'])->get());
    }

    public function show($id)
    {
        if (Gate::denies('controle_do_ponto_view')) {
            return abort(401);
        }

        $controle_do_ponto = ControleDoPonto::with(['matricula'])->findOrFail($id);
        return new ControleDoPontoResource($controle_do_ponto);
    }

    public function store(StoreControleDoPontosRequest $request)
    {
        if (Gate::denies('controle_do_ponto_create')) {
            return abort(401);
        }

        $controle_do_ponto = ControleDoPonto::create($request->all());
        
        

        return (new ControleDoPontoResource($controle_do_ponto))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateControleDoPontosRequest $request, $id)
    {
        if (Gate::denies('controle_do_ponto_edit')) {
            return abort(401);
        }

        $controle_do_ponto = ControleDoPonto::findOrFail($id);
        $controle_do_ponto->update($request->all());
        
        
        

        return (new ControleDoPontoResource($controle_do_ponto))
            ->response()
            ->setStatusCode(202);
    }

    public function destroy($id)
    {
        if (Gate::denies('controle_do_ponto_delete')) {
            return abort(401);
        }

        $controle_do_ponto = ControleDoPonto::findOrFail($id);
        $controle_do_ponto->delete();

        return response(null, 204);
    }
}
