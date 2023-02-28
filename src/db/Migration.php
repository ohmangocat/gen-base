<?php

namespace Ohmangocat\GenBase\db;

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\MigrationInterface;

class Migration extends AbstractMigration
{
    public function table(string $tableName, array $options = []): Table
    {
        $table = new Table($tableName, $options, $this->getAdapter());
        $this->tables[] = $table;
        return $table;
    }
}