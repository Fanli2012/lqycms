<?php

namespace App\Http\Logic;

use App\Common\ReturnData;
use App\Http\Model\Log;
use App\Http\Requests\LogRequest;
use Validator;

class LogLogic extends BaseLogic
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return new Log();
    }

    public function getValidate($data, $scene_name)
    {
        //数据验证
        $validate = new LogRequest();
        return Validator::make($data, $validate->getSceneRules($scene_name), $validate->getSceneRulesMessages());
    }

    //列表
    public function getList($where = array(), $order = '', $field = '*', $offset = '', $limit = '')
    {
        $res = $this->getModel()->getList($where, $order, $field, $offset, $limit);

        if ($res['count'] > 0) {
            foreach ($res['list'] as $k => $v) {
                $res['list'][$k] = $this->getDataView($v);
            }
        }

        return $res;
    }

    //分页html
    public function getPaginate($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getPaginate($where, $order, $field, $limit);

        if ($res->count() > 0) {
            foreach ($res as $k => $v) {
                $res[$k] = $this->getDataView($v);
            }
        }

        return $res;
    }

    //全部列表
    public function getAll($where = array(), $order = '', $field = '*', $limit = '')
    {
        $res = $this->getModel()->getAll($where, $order, $field, $limit);

        if ($res) {
            foreach ($res as $k => $v) {
                $res[$k] = $this->getDataView($v);
            }
        }

        return $res;
    }

    //详情
    public function getOne($where = array(), $field = '*')
    {
        $res = $this->getModel()->getOne($where, $field);
        if (!$res) {
            return false;
        }

        $res = $this->getDataView($res);

        return $res;
    }

    //添加
    public function add($data = array(), $type = 0)
    {
        if (empty($data)) {
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }

        $validator = $this->getValidate($data, 'add');
        if ($validator->fails()) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());
        }

        $res = $this->getModel()->add($data, $type);
        if ($res) {
            return ReturnData::create(ReturnData::SUCCESS, $res);
        }

        return ReturnData::create(ReturnData::FAIL);
    }

    //修改
    public function edit($data, $where = array())
    {
        if (empty($data)) {
            return ReturnData::create(ReturnData::SUCCESS);
        }

        $validator = $this->getValidate($data, 'edit');
        if ($validator->fails()) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());
        }

        $res = $this->getModel()->edit($data, $where);
        if ($res) {
            return ReturnData::create(ReturnData::SUCCESS, $res);
        }

        return ReturnData::create(ReturnData::FAIL);
    }

    //删除
    public function del($where)
    {
        if (empty($where)) {
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }

        $validator = $this->getValidate($where, 'del');
        if ($validator->fails()) {
            return ReturnData::create(ReturnData::PARAMS_ERROR, null, $validator->errors()->first());
        }

        $res = $this->getModel()->del($where);
        if ($res) {
            return ReturnData::create(ReturnData::SUCCESS, $res);
        }

        return ReturnData::create(ReturnData::FAIL);
    }

    /**
     * 数据获取器
     * @param array $data 要转化的数据
     * @return array
     */
    private function getDataView($data = array())
    {
        return getDataAttr($this->getModel(), $data);
    }
}