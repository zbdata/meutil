<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Carbon\Carbon;
use Hash;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property integer $matricula
 * @property time $almoco
 * @property time $cargahoraria
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    
    protected $fillable = ['name', 'email', 'password', 'remember_token', 'matricula', 'almoco', 'cargahoraria'];
    protected $hidden = ['password', 'remember_token'];

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'email' => 'email|max:191|required|unique:users,email',
            'password' => 'required',
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'remember_token' => 'max:191|nullable',
            'matricula' => 'integer|max:4294967295|required|unique:users,matricula',
            'almoco' => 'date_format:H:i:s|max:191|required',
            'cargahoraria' => 'date_format:H:i:s|max:191|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'email' => 'email|max:191|required|unique:users,email,'.$request->route('user'),
            'password' => '',
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'remember_token' => 'max:191|nullable',
            'matricula' => 'integer|max:4294967295|required|unique:users,matricula,'.$request->route('user'),
            'almoco' => 'date_format:H:i:s|max:191|required',
            'cargahoraria' => 'date_format:H:i:s|max:191|required'
        ];
    }

    
    
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    
    

    public function sendPasswordResetNotification($token)
    {
       $this->notify(new ResetPassword($token));
    }
}
