<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',60)->nullable(false);
            $table->string('login',60)->nullable(true)->default(null);
            $table->string('email',70)->unique();
            $table->string('role',40)->nullable(true);
            $table->string('supplier',40)->default(null)->nullable(true);
            $table->integer('id_store')->default(null)->nullable(true);
            $table->string('store',120)->default(null)->nullable(true);
            $table->string('zone',80)->default(null)->nullable(true);
            $table->string('phone',180)->default(null)->nullable(true);
            $table->enum('access_online_store_orders', array('yes','no'))->default('no')->nullable(false);
            $table->enum('sms_received', array('yes','no'))->default('no')->nullable(false);
            $table->enum('sms_validate', array('yes','no'))->default('no')->nullable(false);
            $table->string('restaurant_stats',120)->default(null)->nullable(true);
            $table->string('zone_stats',120)->default(null)->nullable(true);
            $table->string('device_token',120)->default(null)->nullable(true);
            $table->enum('alarm_notification', array('yes','no'))->default('yes')->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',60);
            $table->rememberToken();
            $table->timestamps();
        });
        
        $user = User::firstOrCreate(
            ['email' => 'admin@mail.mail'], // Unique constraint to avoid duplicates
            [
                'name' => 'Admin',
                'email' => 'admin@mail.mail',
                'login' => 'admin@mail.mail',
                'role' => 'admin',
                'password' => '$2y$10$pW9BGx/ECW/L2Um9627nAOdgNSUChBzvVumlHp3xAEoW0seyZpTbq'
            ]
        );
        
       
        
//        Hans mdp : 123456789


        DB::table('users')->insert(
            array(
                
                array(
                    'name' => 'Guest',
                    'email' => 'guest@mail.mail',
                    'login' => 'guest@mail.mail',
                    'role' => 'customer',
                    'password' => '$2y$10$3otDECKhRrLfXeBL48U6ceYj/ieMIoWOkxD6SM3iJvK.pZKVOmqJ2'
                )
            )

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
