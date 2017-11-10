<?php
namespace app\index\controller;

class Lists extends Base
{
    public function index()
    {
        //显示全部分类
        $categories = model('Category')->getCategoryByParentId(0);
        //把所有一级分类的id存放到一个数组中
        $category_ids = [];
        foreach ($categories as $cat)
        {
            $category_ids[] = $cat->id;
        }
        $id = input('id',0,'intval');
        if (!model('Category')->get($id) && $id != 0)
        {
            $this->error('id不合法查不到分类');
        }
        //记录一二级分类id
        $cat_id = 0;
        if (in_array($id,$category_ids))
        {
            //一级分类
            $cat_id = $id;
        }
        elseif($id)
        {
            $se_cat = model('Category')->get($id);
            $cat_id = $se_cat->parent_id;
        }
        else
        {

        }
        $se_categories = [];
        if ($cat_id)
        {
            $se_categories = model('Category')->getCategoryByParentId($cat_id);
        }

        return $this->fetch('',[
            'title'=> '🙃😒😒😒😒'.$this->city->name.'团购',
            'categories' => $categories,
            'cat_id' => $cat_id,
            'se_categories' => $se_categories,
            'se_cat_id' => $id,
        ]);
    }
}