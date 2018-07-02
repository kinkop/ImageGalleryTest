<?php
/**
 * Created by PhpStorm.
 * User: kinkop
 * Date: 1/7/2018 AD
 * Time: 19:05
 */

namespace ImageGallery\Repositories;


interface RepositoryInterface
{
    public function create($attributes = []);
    public function update($id, $attributes = []);
    public function firstOrCreate($attributes = []);
    public function updateOrCreate($conditions = [], $attributes = []);
    public function find($id);
    public function findOrFail($id);
    public function where($conditions = []);
    public function all();
    public function delete($id);
}