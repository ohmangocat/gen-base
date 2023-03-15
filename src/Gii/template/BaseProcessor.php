<?php

namespace Ohmangocat\GenBase\Gii\template;

abstract class BaseProcessor
{
    protected $defaultSubPaths = [
        'dao' => [],
        'service' => [],
        'model' => [],
    ];
    abstract public function render(array $args = []);
    abstract public function getTemplates();
}