<?php


namespace gen;


use Illuminate\Database\Eloquent\SoftDeletes;
use support\Model;

class GenModel extends Model
{
    use SoftDeletes;
    public const PAGE_SIZE = 15;

    public function newCollection(array $models = [])
    {
        return new GenCollection($models);
    }
}