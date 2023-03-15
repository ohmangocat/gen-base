<?php


namespace Ohmangocat\GenBase\Gii;


interface TemplateInterface
{
    /**
     * @param array $args
     * @return string
     */
    public function getContext(array $args = []);
}