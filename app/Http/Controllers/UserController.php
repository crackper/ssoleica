<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 17/07/15
 * Time: 8:26 AM
 */

namespace SSOLeica\Http\Controllers;


use Illuminate\Support\Facades\Auth;

use SSOLeica\Core\Model\User;

class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('workspace');
    }

    public function getIndex()
    {
        $users = User::all();

        foreach($users as $user){
            $user['rol'] = $user->roles()->first();
        }

        //$user = Auth::user()->hasRole('role-name');


        dd($users);
    }
} 