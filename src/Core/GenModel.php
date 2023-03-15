<?php

namespace Ohmangocat\GenBase\Core;

use Illuminate\Support\Str;
use support\Db;
use support\Model;

class GenModel extends Model
{
    const PAGE_SIZE = 15;

    protected $connection = "plugin.ohmangocat.gen-base.mysql";

}