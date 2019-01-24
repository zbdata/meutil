<?php

namespace App\Http\Controllers\Api\V1;

use App\ControleDoPonto;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\ControleDoPonto as ControleDoPontoResource;
use App\Http\Requests\Admin\StoreControleDoPontosRequest;
use App\Http\Requests\Admin\UpdateControleDoPontosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use GuzzleHttp\Client;
use Carbon\Carbon;



class ControleDoPontosController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();
        $matricula = $user['matricula'];

        $end = "http://192.168.0.3:86/ponto";
        //$end = "http://10.209.63.76:85/api/dot/$matricula/20190101/20190131";
        $client = new Client();
        $registros = $client->request('GET', $end);
        $registros = $registros->getBody();
        $user = auth('api')->user();

        $registros = json_decode($registros, true);
        $faltas = new ControleDoPontoResource(ControleDoPonto::with(['matricula'])->where('matricula_id', $user['id'])->get());

        $ponto['data'] = [];

        foreach ($registros as $key_reg => $value_reg) {

            $saldo = $this->horas_trabalhadas_dia($value_reg['entrada'], 
                                                        array_key_exists('saida', $value_reg) ? $value_reg['saida'] : '00:00:00', 
                                                        $user['almoco'],
                                                        $user['cargahoraria']);

            array_push($ponto['data'], 
                                ['id' => '',
                                'data' => $value_reg['data'],
                                'falta' => '',
                                'feriado' => '',
                                'entrada' => array_key_exists('entrada', $value_reg) ? $value_reg['entrada'] : '',
                                'saida' => array_key_exists('saida', $value_reg) ? $value_reg['saida'] : '00:00:00',
                                'no_dia' => $saldo['no_dia'] ?  $saldo['no_dia'] : '00:00:00',
                                'saldo_dia' => $saldo['saldo_dia'] ? $saldo['saldo_dia'] : '00:00:00'
                                ]);
        };

        foreach ($faltas as $falta) {
            if($falta){
                foreach ($falta as $key_falta=>$value_falta){
                    foreach ($ponto['data'] as $key_ponto => $value_ponto) {
                        if ($value_falta['data'] == $value_ponto['data']){
                            array_pull($ponto['data'], $key_ponto);
                        }
                    }
                    array_push($ponto['data'], $value_falta);
                }
            }
        };
        array_push($ponto['data'], ['saldo'=>'15']);
        
        $ponto['data'] = array_values($ponto['data']);
        return json_encode($ponto);
        //return new ControleDoPontoResource(ControleDoPonto::with(['matricula'])->get());
    }

    public function horas_trabalhadas_dia($entrada, $saida, $almoco, $carga_horaria){
        if($saida != '00:00:00'){
            // Faz o cálculo das horas
            $total = (strtotime($saida) - strtotime($entrada));
            $almoco = strtotime($almoco);
            $carga_horaria = strtotime($carga_horaria);

            // Encontra as horas trabalhadas
            $hours      = floor($total / 60 / 60);
            $hora_almoco = floor($almoco / 60 / 60);
            $hora_carga = floor($carga_horaria / 60 / 60);

            // Encontra os minutos trabalhados
            $minutes    = round(($total - ($hours * 60 * 60)) / 60);
            // Formata a hora e minuto para ficar no formato de 2 números, exemplo 00
            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
            $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
            // Exibe no formato "hora:minuto"
            $total = $hours.':'.$minutes;

            $saldo = Carbon::parse($total)->subHour($hora_almoco);
            $saldo_dia = Carbon::parse($saldo)->subHour($hora_carga);
            
            $saldo = ['no_dia'=> Carbon::parse($saldo)->toTimeString(),
                        'saldo_dia'=> Carbon::parse($saldo_dia)->toTimeString()];
        }else{
            $saldo = ['no_dia'=> '00:00:00',
                        'saldo_dia'=> '00:00:00'];
        }
        return $saldo;
    }

    public function horas_mes($ponto){


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
