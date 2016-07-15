<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class Configurations extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'configurations';

}
