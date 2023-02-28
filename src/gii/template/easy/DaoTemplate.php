<?php


namespace Ohmangocat\GenBase\gii\template\easy;


use Ohmangocat\GenBase\gii\TemplateInterface;

class DaoTemplate implements TemplateInterface
{

    public function getContext(array $args = [])
    {
        $relation = $args['relation'] ?? $args['bizId'];
        $model = $args['bizId'];
        $phpCode= "<?php\n"
            . "namespace biz\\{$relation}\\dao;\n"
            . "\n"
            . "use biz\\{$relation}\\model\\{$model};\n"
            . "use gen\GenDao;\n"
            . "\n"
            . "class {$model}Dao extends GenDao"
            . "\n"
            . "{\n"
            . "    public function setModel(): string\n"
            ."    {\n"
            . '        return ' . $model . "::class;\n"
            ."    }\n"
            ."}\n";
        $filename = $args['rootPath'] . "/dao/{$model}Dao.php";

        return [$filename, $phpCode];
    }
}