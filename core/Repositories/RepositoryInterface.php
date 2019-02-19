<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 10:39 AM
 */

namespace Core\Repositories;


interface RepositoryInterface
{
    public function paginate();
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}