<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class Month extends Model {

    use UpdatedBy;

    protected $table = 'month';
}
