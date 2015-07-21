<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/07/15
 * Time: 10:09 AM
 */

namespace Database\Seeds;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class UserTableSeeder extends \Illuminate\Database\Seeder{

    public function run(){
        DB::table('users')->delete();

        $users = array(
            ['id'=> 1,'name'=>'Samuel Mestanza','email' => 'samuel.mestanza@hotmail.com','password' => Hash::make( '1234567' ),'active'=>true,'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'name'=>'APR','email' => 'apr@hotmail.com','password' => Hash::make( '1234567' ),'active'=>true,'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3,'name'=>'JOperaciones','email' => 'joperciones@hotmail.com','password' => Hash::make( '1234567' ),'active'=>true,'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4,'name'=>'Gerente','email' => 'gerente@hotmail.com','password' => Hash::make( '1234567' ),'active'=>true,'created_at' => new DateTime, 'updated_at' => new DateTime]
        );

        DB::table('users')->insert($users);

        //----------------------------------------

        DB::table('roles')->delete();

        $roles = array(
            ['id'=> 1,'name'=>'admin','display_name'=>'Administrador','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'name'=>'apr','display_name' => 'APR','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 3,'name'=>'joperaciones','display_name' => 'Jefe de Operaciones','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 4,'name'=>'gerente','display_name' => 'Gerente','created_at' => new DateTime, 'updated_at' => new DateTime]
        );

        DB::table('roles')->insert($roles);

        //----------------------------------------

        DB::table('role_user')->delete();

        $role_user = array(
            ['user_id'=> 1,'role_id'=>1],
            ['user_id'=> 2,'role_id'=>2],
            ['user_id'=> 3,'role_id'=>3],
            ['user_id'=> 4,'role_id'=>4]
        );

        DB::table('role_user')->insert($role_user);

        //------------------------------------------

        DB::table('permissions')->delete();

        $permissions = array(
            ['id'=> 1,'name'=>'upload_file','display_name'=>'Subir Archivos','created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id'=> 2,'name'=>'create_folder','display_name'=>'Crear Carpeta','created_at' => new DateTime, 'updated_at' => new DateTime]
        );

        DB::table('permissions')->insert($permissions);

        //-------------------------------------------

        DB::table('permission_role')->delete();

        $permission_role = array(
            ['permission_id'=> 1,'role_id'=>1],
            ['permission_id'=> 2,'role_id'=>1],
            ['permission_id'=> 1,'role_id'=>2],
            ['permission_id'=> 1,'role_id'=>3],
        );

        DB::table('permission_role')->insert($permission_role);

    }
} 