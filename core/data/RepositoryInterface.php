<?php namespace SSOLeica\Core\Data;
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/04/15
 * Time: 10:54 AM
 */

interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));
}