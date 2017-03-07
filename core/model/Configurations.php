<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SSOLeica\Core\Traits\UpdatedBy;

class Configurations extends Model {

    use UpdatedBy,SoftDeletes;

    protected $table = 'configurations';

}
