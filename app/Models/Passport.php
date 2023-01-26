<?php
namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Passport extends Model {
	use HasApiTokens, HasFactory, Notifiable;

	protected $guarded = false;

	public function user() {
		return $this->belongsTo(User::class);
	}
}