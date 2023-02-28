<?php


namespace Ohmangocat\Gen_base\gen\gii;


interface TemplateInterface
{
    /**
     * @param array $args
     * @return string
     */
    public function getContext(array $args = []);
}