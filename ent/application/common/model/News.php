<?php
namespace app\common\model;

use app\common\lib\ApiException;
use think\Model;

class News extends Model
{
    public function getLunboNewsByLimit($limit)
    {
        $data = [
            'is_head_figure' => 1,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'asc',
        ];
        $res = $this->where($data)->field($this->getField())->order($order);
        if ($limit)
        {
            $res = $res->limit($limit);
        }
        $res = $res->select();
        return $res;
    }
    public function getPositionNewsByLimit($limit)
    {
        $data = [
            'is_position' => 1,
            'status' => 1,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'asc',
        ];
        $res = $this->where($data)->field($this->getField())->order($order);
        if ($limit)
        {
            $res = $res->limit($limit[0],$limit[1]);
        }
        $res = $res->select();
        return $res;
    }
    public function getNews($data)
    {
        if (!$data['condition'])
        {
            throw new ApiException('查询条件不能为空',500);
        }
        $res = $this->where($data['condition']);
        if (!isset($data['order']))
        {
            $data['order'] = [
                'listorder' => 'desc',
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
    private function getField()
    {
        return [
            'id',
            'catid',
            'image',
            'title',
            'read_count',
            'status',
            'is_position',
            'update_time',
            'create_time'
        ];
    }
}