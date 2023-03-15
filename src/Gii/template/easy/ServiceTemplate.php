<?php


namespace Ohmangocat\GenBase\Gii\template\easy;


use Ohmangocat\GenBase\Gii\TemplateInterface;

class ServiceTemplate implements TemplateInterface
{

    public function getContext(array $args = [])
    {
        $relation = $args['relation'] ?? $args['bizId'];
        $service = $args['bizId'];
        $className = "{$service}Service";
        $daoName = "{$service}Dao";
        $daoAlias = '$dao';
        $phpCode= "<?php\n"
                . "namespace biz\\{$relation}\\service;\n"
                . "\n"
                . "use biz\\{$relation}\\dao\\{$daoName};\n"
                . "use Ohmangocat\GenBase\Core\GenService;\n"
                . "\n"
                . "class {$className} extends GenService"
                . "\n"
                . "{\n"
                . '    public function __construct('. $daoName ." $daoAlias)\n"
                ."    {\n"
                . '        $this->dao = ' . $daoAlias .";\n"
                ."    }\n"
                ."}\n";
        $filename = $args['rootPath'] . "/service/{$className}.php";

        return [$filename, $phpCode];
    }
}