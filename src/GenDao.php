<?php


namespace Ohmangocat\GenBase;


use biz\gabor\model\TrainLevel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use support\Container;

abstract class GenDao
{
    abstract  protected function setModel();

    /**
     * @return GenModel
     */
    public function getModel(): GenModel
    {
        return Container::make($this->setModel(), []);
    }

    public function save($data)
    {
        return $this->getModel()::create($data);
    }

    public function delete($ids)
    {
        return $this->getModel()::destroy($ids);
    }

    public function getList(?array $params)
    {
        return $this->listQuerySetting($params)->get()->toArray();
    }

    public function getPageList(?array $params, string $pageName = 'page')
    {
        $paginate = $this->listQuerySetting($params)->paginate(
            $params['pageSize'] ?? $this->getModel()::PAGE_SIZE, ['*'], $pageName, $params[$pageName] ?? 1
        );
        return $this->setPaginate($paginate);
    }

    public function getTreeList(
        ?array $params = null,
        string $id = 'id',
        string $parentField = 'parent_id',
        string $children='children'
    )
    {
        $params['_genadmin_tree'] = true;
        $params['_genadmin_tree_pid'] = $parentField;
        $data = $this->listQuerySetting($params)->get();
        return $data->toTree($data, $data[0]->{$parentField} ?? 0, $id, $parentField, $children);
    }

    public function setPaginate(LengthAwarePaginator $paginate): array
    {
        return [
            'items' => $paginate->items(),
            'pageInfo' => [
                'total' => $paginate->total(),
                'currentPage' => $paginate->currentPage(),
                'totalPage' => $paginate->lastPage()
            ]
        ];
    }

    /**
     * @param array|null $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function listQuerySetting(?array $params)
    {
        $query = (($params['recycle'] ?? false) === true) ? $this->getModel()::onlyTrashed() : $this->getModel()::query();
        if ($params['select'] ?? false) {
            $query->select($this->filterQueryAttributes($params['select']));
        }
        $query = $this->handleOrder($query, $params);
        return $query;
    }

    /**
     * ???????????????
     * @param Builder $query
     * @param array|null $params
     * @return Builder
     */
    public function handleOrder(Builder $query,?array &$params): Builder
    {
        if (isset($params['_genadmin_tree'])) {
            $query->orderBy($params['_genadmin_tree_pid']);
        }
        if($params['orderBy'] ?? false) {
            if (is_array($params['orderBy'])) {
                foreach ($params['orderBy'] as $key => $order) {
                    $query->orderBy($order, $params['orderType'][$key] ?? 'asc');
                }
            } else {
                $query->orderBy($params['orderBy'], $params['orderType']?? 'asc');
            }
        }
        return $query;
    }

    /**
     * @param array $fields
     * @param bool $removePk
     * @return array|string[]
     */
    public function filterQueryAttributes(array $fields, bool $removePk = false): array
    {
        $attrs = $this->getModel()->getFillable();
        foreach ($fields as $key => $field) {
            if (!in_array(trim($field), $attrs) && mb_strpos(str_replace('AS', 'as', $field), 'as') === false) {
                unset($fields[$key]);
            } else {
                $fields[$key] = trim($field);
            }
        }
        if ($removePk && in_array($this->getModel()->getKeyName(), $fields)) {
            unset($fields[array_search($this->getModel()->getKeyName(), $fields)]);
        }
        return ( count($fields) < 1 ) ? ['*'] : $fields;
    }

    /**
     * ???????????????????????????????????????
     * @param array $data
     * @param bool $removePk
     */
    protected function filterExecuteAttributes(array &$data, bool $removePk = false): void
    {
        $attrs = $this->getModel()->getFillable();
        foreach ($data as $name => $val) {
            if (!in_array($name, $attrs)) {
                unset($data[$name]);
            }
        }
        if ($removePk && isset($data[$this->getModel()->getKeyName()])) {
            unset($data[$this->getModel()->getKeyName()]);
        }
    }

    /**
     * ??????????????????
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $this->filterExecuteAttributes($data, true);
        return $this->getModel()::find($id)->update($data) > 0;
    }
    /**
     * ??????????????????
     * @param int $id
     * @param string $field
     * @param int $value
     * @return bool
     */
    public function numberOperation(int $id, string $field, int $value): bool
    {
        return $this->update($id, [ $field => $value]);
    }
}