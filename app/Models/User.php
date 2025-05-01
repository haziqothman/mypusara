<?php
  
  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Casts\Attribute;
  
  class User extends Authenticatable
  {
      use HasFactory, Notifiable;
  
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
          'name',
          'email',
          'password',
          'type',   // Assuming 'type' is the column for user roles
          'address',
          'phone',
          'city',
          'postcode',
          'identification_card',
      ];
  
      /**
       * The attributes that should be hidden for serialization.
       *
       * @var array
       */
      protected $hidden = [
          'password',
          'remember_token',
      ];
  
      /**
       * Get the attributes that should be cast.
       *
       * @return array
       */
      protected function casts(): array
      {
          return [
              'email_verified_at' => 'datetime',
              'password' => 'hashed',
          ];
      }
  
      /**
       * Accessor for the user role.
       *
       * @param  int  $value
       * @return string
       */
      protected function type(): Attribute
        {
            return new Attribute(
                get: fn ($value) => $value == 1 ? 'admin' : 'customer',  // Cast integer to 'admin' or 'customer'
            );
        }

        public function bookings()
        {
            return $this->hasMany(Booking::class);
        }


  }
  
