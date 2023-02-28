<?php

namespace Ohmangocat\Gen_base\gen\db;

class Table extends \Phinx\Db\Table
{
    /**
     * Add timestamp columns created_at and updated_at to the table.
     *
     * @param string|false|null $deletedAt Alternate name for the deleted_at column
     * @param bool $withTimezone Whether to set the timezone option on the added columns
     * @return $this
     */
    public function addSoftDeletes($deletedAt = 'deleted_at', bool $withTimezone = false)
    {
        $deletedAt = $deletedAt ?? 'deleted_at';

        if (!$deletedAt) {
            throw new \RuntimeException('Cannot set deleted_at column to false');
        }

        if ($deletedAt) {
            $this->addColumn($deletedAt, 'timestamp', [
                'null' => true,
                'default' => null,
                'timezone' => $withTimezone,
            ]);
        }
        return $this;
    }
}