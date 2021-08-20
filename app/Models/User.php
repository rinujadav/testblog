<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Admin\ForexCredentials;
use App\Models\Admin\CryptoCredentials;
use App\Models\Admin\Accounts;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = ['registered_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //Get Forex Credentials for a User
    public function forexCredential() {
        return $this->hasOne(ForexCredentials::class);
    }

    //Get Crypto Credentials for a User
    public function cryptoCredential() {
        return $this->hasOne(CryptoCredentials::class);
    }

    //Get Accounts for a User
    public function accounts() {
        return $this->hasMany(Accounts::class);
    }

    //Get Bank Accounts for a User
    public function bank_accounts() {
        return $this->hasMany(BankAccount::class);
    }

    public function getRegisteredAtAttribute() {
        return $this->created_at->diffForHumans();
    }

    //Get All Transactions for a User
    public function transactions() {
        return $this->hasMany(Transactions::class);
    }

    //Get All Documents for a User
    public function documents() {
        return $this->hasMany(Documents::class);
    }

    public function support_tickets() {
        return $this->hasMany(Support::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
    
}