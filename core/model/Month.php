<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class Month extends Model {

    use UpdatedBy;

    protected $table = 'month';

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();

        return parent::save($options);
    }

}
