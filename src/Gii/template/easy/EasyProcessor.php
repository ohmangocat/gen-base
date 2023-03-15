<?php


namespace Ohmangocat\GenBase\Gii\template\easy;


use Ohmangocat\GenBase\gii\template\BaseProcessor;
use Ohmangocat\GenBase\gii\TemplateInterface;

class EasyProcessor extends BaseProcessor
{

    public function getTemplates()
    {
        return [
            'dao' => DaoTemplate::class,
            'model' => ModelTemplate::class,
            'service' => ServiceTemplate::class,
        ];
    }

    public function render(array $args = [])
    {
        $args['bizId'] = ucwords($args['bizId']);
        $path = BASE_PATH . DIRECTORY_SEPARATOR . 'biz' . DIRECTORY_SEPARATOR .( $args['relation'] ?? $args['bizId']);
        $args['rootPath'] = $path;
        empty($args['tableName']) && $args['tableName'] = $this->parseTableName($args['bizId'], $args['prefix'] ?? '');
        try {
            if ($args['relation']) {
                if (!is_dir($path)) {
                    $this->renderPath($path);
                }
            } else {
                if (is_dir($path)) throw new \Exception("the {$args['bizId']} biz already exist!");
                else $this->renderPath($path);
            }

            foreach ($this->getTemplates() as $template) {
                if (class_exists($template)) {
                    /** @var TemplateInterface $obj */
                    $obj = new $template();
                    list($filename, $content) = $obj->getContext($args);
                    if (!empty($filename)) {
                        file_put_contents($filename, $content);
                    }
                }
            }
            return $path;
        } catch (\Exception $e) {
//            shell_exec("rm -rf {$path}/*");
            throw $e;
        }
    }


    protected function renderPath($root)
    {
        mkdir($root, 0777, true);
        foreach ($this->defaultSubPaths as $path => $subPath) {
            mkdir($root . DIRECTORY_SEPARATOR . $path);
            foreach ($subPath as $value) {
                mkdir($root . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $value, 0777, true);
            }
        }
    }

    protected function parseTableName($bizId, $prefix = '')
    {
        $words = preg_split("/[\s]/", $bizId);
        if ($prefix && !empty(envHelper("database.prefix"))) {
            $prefix = envHelper("database.prefix");
        }

        return $prefix . strtolower(implode('_', $words));
    }

}