<?php

namespace Ohmangocat\GenBase\Core;

use Ohmangocat\GenBase\Traits\DaoTrait;

abstract class GenDao
{
    use DaoTrait;
    abstract  protected function setModel();
}