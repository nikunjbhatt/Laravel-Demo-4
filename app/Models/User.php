<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
		'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
		'email_verified_at',
        'remember_token',
    ];

	protected static function booted(): void
	{
		User::observe(UserObserver::class);

		static::created(function (User $user) {
			\Log::debug('User Created: ' . $user->name);
		});

		static::updating(function (User $user) {
			if($user->gender == 'male')
				$user->gender = 'M';
			else
				$user->gender = 'F';
						
			\Log::debug('User Updated: ' . $user->name);
		});
	}

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
			'created_at' => 'date:d-m-Y g:i a'
        ];
    }

	public function posts()
	{
		return $this->hasMany(Post::class);//->chaperone();
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);//->chaperone();
	}

	protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn() => rand(0, 1) ? 'Yes' : 'No',
        );
    }

	//protected $appends = ['is_admin'];
}
