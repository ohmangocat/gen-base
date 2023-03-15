<?php

namespace Ohmangocat\GenBase\Command;

use Ohmangocat\GenBase\gii\GiiFactory;
use Ohmangocat\GenBase\Util\ShellColorUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeBizCommand extends Command
{
    protected static $defaultName = "make:biz";
    protected static $defaultDescription = 'Make Biz';
    protected function configure()
    {
        $this
            // 命令的名称 （"php console_command" 后面的部分）
            ->setName('make:biz')
            // 运行 "php console_command list" 时的简短描述
            ->setDescription('Make Biz')
            // 运行命令时使用 "--help" 选项时的完整命令描述
            // 配置一个参数
            ->addArgument('id', InputArgument::REQUIRED, '业务名称')
            ->addArgument('table', null, '表')
            ->addOption('relation', 'r', InputOption::VALUE_OPTIONAL, '关联业务')
            ->addOption('prefix', 'p', InputOption::VALUE_OPTIONAL, '表前缀');

    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bizId = $input->getArgument('id');
        $table = $input->getArgument('table');
        $relation = $input->getOption('relation');
        $prefix = $input->getOption('prefix');
        $output->writeln(sprintf("正在生成Biz: %s", ShellColorUtil::showInfo($bizId)));
        try {
            $gii = GiiFactory::create("easy");
            $gii->render([
                "bizId" => $bizId,
                "tableName" => $table,
                "relation" => $relation,
                "prefix" => $prefix,
            ]);
        } catch (\Exception $e) {
            $output->writeln(ShellColorUtil::showError("生成失败:{$e->getMessage()}"));
        }
        return 1;
    }
}