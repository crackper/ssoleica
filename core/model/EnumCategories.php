<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;
use SSOLeica\Core\Traits\UpdatedBy;

class EnumCategories extends Model {

    use UpdatedBy;

    protected $table = 'enum_categories';

    public function categoria()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey = 'id',$localKey='enum_value_id');
    }

    public function save(array $options = array())
    {
        $this->attributes['updated_by'] = $this->getUpdated();

        return parent::save($options);
    }

}
