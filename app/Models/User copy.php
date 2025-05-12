<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Notifications\ResetPassword;

// class User extends AuthUser

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'gender',
        'dob',
        'password',
        'facebook_id',
        'google_id',
        'github_id',
        'avatar',
        'profile_photo_path',
        'brand_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

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
        ];
    }

    public function isAdmin()
    {

        if ($this->getRoleNames()->count() == 0 || ($this->getRoleNames()->count() == 1 && array_intersect(['customer'], $this->getRoleNames()->toArray()))) return false;
        return true;
    }

    public function isActive()
    {
        return $this->status == 'active' ? true : false;
    }
    public  function adminlte_profile_url()
    {
        return route('profile.show');
    }

    public function adminlte_image()
    {
        return auth()->user()->profile_photo_url;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, request()->reset_url));
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function hasInWishlist($product_id)
    {
        return $this->wishlists()->where('product_id', $product_id)->exists();
    }

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class);
    }
}
