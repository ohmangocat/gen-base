<?php


namespace Ohmangocat\GenBase\gii;


interface TemplateInterface
{
    /**
     * @param array $args
     * @return string
     */
    public function getContext(array $args = []);
}