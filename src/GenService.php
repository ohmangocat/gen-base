<?php


namespace gen;


class GenService
{
    protected $dao;


    /**
     * 获取列表数据
     * @param array|null $params
     * @return mixed
     */
    public function getList(?array $params = null,)
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = false;
        return $this->dao->getList($params);
    }

    public function getListByRecycle(?array $params = null)
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = true;
        return $this->dao->getList($params);
    }
    /**
     * 获取列表数据(分页)
     * @param array|null $params
     * @return mixed
     */
    public function getPageList(?array $params = null,)
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        return $this->dao->getPageList($params);
    }

    /**
     * 从回收站获取列表数据（带分页）
     * @param array|null $params
     * @return mixed
     */
    public function getPageListByRecycle(?array $params = null)
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = true;
        return $this->dao->getPageList($params);
    }

    public function getTreeList(?array $params = null)
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = false;
        return $this->dao->getTreeList($params);

    }

    /**
     * 数字更新操作
     * @param int $id
     * @param string $field
     * @param int $value
     * @return bool
     */
    public function numberOperation(int $id, string $field, int $value): bool
    {
        return $this->dao->numberOperation($id, $field, $value);
    }


    public function delete(array $ids)
    {
        return !empty($ids) && $this->dao->delete($ids);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array(array($this->dao, $name), $arguments);
    }
}