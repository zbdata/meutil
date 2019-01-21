<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ControleDoPonto
 *
 * @package App
 * @property string $data
 * @property tinyInteger $falta
 * @property tinyInteger $feriado
 * @property string $matricula
*/
class ControleDoPonto extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['data', 'falta', 'feriado', 'matricula_id'];
    

    public static function storeValidation($request)
    {
        return [
            'data' => 'date_format:' . config('app.date_format') . '|max:191|required',
            'falta' => 'boolean|nullable',
            'feriado' => 'boolean|nullable',
            'matricula_id' => 'integer|exists:users,id|max:4294967295|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'data' => 'date_format:' . config('app.date_format') . '|max:191|required',
            'falta' => 'boolean|nullable',
            'feriado' => 'boolean|nullable',
            'matricula_id' => 'integer|exists:users,id|max:4294967295|required'
        ];
    }

    

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDataAttribute($input)
    {
        if ($input) {
            $this->attributes['data'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        }
    }

    /**
     * Get attribute from date format
     * @param $output
     *
     * @return string
     */
    public function getDataAttribute($output)
    {
        if ($output) {
            return Carbon::createFromFormat('Y-m-d', $output)->format(config('app.date_format'));
        }
    }
    
    public function matricula()
    {
        return $this->belongsTo(User::class, 'matricula_id');
    }
    
    
}
