<?php

namespace SSOLeica\Core\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/07/15
 * Time: 11:50 AM
 */

trait UpdatedBy {

    public function getUpdated()
    {
        $updated_by = json_encode(array('id' => Auth::user()->id,
                                        'name'=>Auth::user()->name,
                                        'email'=>Auth::user()->email,
                                        'trabjador_id'=>Auth::user()->trabajador_id,
                                        'updated_at'=> new \DateTime() ));

        //Session::put('updated_by',$updated_by);

        //$updated_by = Session::has('updated_by')? Session::get('updated_by'): json_encode(array("msg"=>"sin usuario"));

        return $updated_by;
    }

} 