<?php namespace SSOLeica\Core\Model;

use Illuminate\Database\Eloquent\Model;

class EnumCategories extends Model {

    protected $table = 'enum_categories';

    public function categoria()
    {
        return $this->hasOne('SSOLeica\Core\Model\EnumTables',$foreignKey = 'id',$localKey='enum_value_id');
    }

}
