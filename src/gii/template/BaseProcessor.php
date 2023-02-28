<?php


namespace Ohmangocat\GenBase\gii\template;


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