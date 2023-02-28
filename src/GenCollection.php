<?php

namespace Ohmangocat\GenBase;


use Illuminate\Database\Eloquent\Collection;


class GenCollection extends Collection
{
    public function toTree(array $data = [], int $parentId = 0, string $id = 'id', string $parentField = 'parent_id', string $children='children'): array
    {
        $data = $data ?: $this->toArray();
        if (empty($data)) return [];

        $tree = [];
        foreach ($data as $value) {
            if ($value[$parentField] == $parentId) {
                $child = $this->toTree($data, $value[$id], $id, $parentField, $children);
                if (!empty($child)) {
                    $value[$children] = $child;
                }
                array_push($tree, $value);
            }
        }

        unset($data);
        return $tree;
    }
}