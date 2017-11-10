<?php
namespace app\common\model;

use think\Model;

class Version extends Model
{
    public function getVersion($data = [])
    {
        if (!isset($data['condition']))
        {
            $data['condition'] = [];
        }
            $res = $this->where($data['condition']);
        if (!isset($data['order']))
        {
            $data['order'] = [
                'id' => 'desc'
            ];
        }
        if ($data['order'])
        {
            if (!is_array($data['order']))
            {
                throw new ApiException('排序条件格式错误',500);
            }
            $res = $res->order($data['order']);
        }
        if (isset($data['limit']))
        {
            if (is_array($data['limit']))
            {
                $res = $res->limit($data['limit'][0],$data['limit'][1]);
            }
            elseif (is_numeric($data['limit']))
            {
                $res = $res->limit($data['limit']);
            }
            else
            {
                throw new ApiException('分页条件格式错误',500);
            }
        }
        if (isset($data['field']))
        {
            if (!is_array($data['field']))
            {
                throw new ApiException('字段查询格式错误',500);
            }
            $res = $res->field($data['field']);
        }
        return $res->select();
    }
}