<?php


namespace Ohmangocat\GenBase\Gii\template\easy;


use Ohmangocat\GenBase\Gii\TemplateInterface;

class ModelTemplate implements TemplateInterface
{

    public function getContext(array $args = [])
    {
        $relation = $args['relation'] ?? $args['bizId'];
        $model = $args['bizId'];
        $tableName = $args['tableName'];
        $phpCode = "<?php\n"
            . "\n"
            . "namespace biz\\{$relation}\\model;\n"
            . "\n"
            . "use Ohmangocat\GenBase\Core\GenModel;\n"
            . "\n"
            . "class {$model} extends GenModel\n"
            . "{\n"
            . "    protected " . '$table = ' . "'{$tableName}';\n"
            . "}\n";
        $filename = $args['rootPath'] . "/model/{$model}.php";
        return [$filename, $phpCode];
    }
}