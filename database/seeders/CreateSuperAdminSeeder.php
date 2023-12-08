<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #$superAdminRole = Role::create(['name' => 'SuperAdmin']);
        $superAdmin = User::create([
            'username' => env('SUPERADMIN_USERNAME'),
            'email' => env('SUPERADMIN_EMAIL'),
            'password' => Hash::make(env('SUPERADMIN_PASSWORD')),
            'status' => env('SUPERADMIN_STATUS')
        ]);
        $superAdminUserId = User::where('username',env('SUPERADMIN_USERNAME')) -> first() -> id;
        $superAdminProps = \App\Models\Preference::create([
            'user_id' => $superAdminUserId,
            'is_legacy' => env('SUPERADMIN_IS_LEGACY'),
            'top_to_bottom' => env('SUPERADMIN_TOP_TO_BOTTOM'),
            'language' => env('SUPERADMIN_LANGUAGE'),
            'country' => env('SUPERADMIN_COUNTRY'),
            'timezone' => env('SUPERADMIN_TIMEZONE'),
            'clock_type' => env('SUPERADMIN_CLOCK_TYPE'),
            'email_optin' => env('SUPERADMIN_EMAIL_OPTIN'),
            'menu_color' => env('SUPERADMIN_MENU_COLOR')
        ]);
        #$superAdmin->assignRole($superAdminRole);
    }
}
