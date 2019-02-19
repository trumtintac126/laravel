<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2/19/2019
 * Time: 11:19 AM
 */

namespace Core\Services;


interface ServiceInterface
{
    public function paginate();
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}