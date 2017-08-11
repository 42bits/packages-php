<?php
namespace app\packages\Page;

class Page
{
    private $total;      //总记录
    private $pagesize;    //每页显示多少条
    private $limit;          //limit
    private $page;           //当前页码
    private $pagenum;      //总页码
    public $url;           //地址
    public $jumpUrl;       //输入页数跳转基础url
    public $limitUrl;       //输入分页跳转基础url
    private $bothnum;      //两边保持数字分页的量

    //构造方法初始化
    public function __construct($now_page, $_total, $_pagesize)
    {
        $this->total    = $_total ? $_total : 1;
        $this->pagesize = $_pagesize;
        $this->pagenum  = ceil($this->total / $this->pagesize);
        $this->page     = max($now_page, 1);
        $urlInfo = $this->setUrl();
        $this->url      = $urlInfo['_url'];
        $this->jumpUrl      = $urlInfo['_url'].'&page=';
        $this->limitUrl      = $urlInfo['limitUrl'].'&limit=';
        $this->bothnum  = 2;
    }

    //获取地址
    private function setUrl()
    {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        $baseUrl = \Yii::$app->urlManager->createUrl(['']).$_par['path'] . '?';
        if (isset($_par['query'])) {
            parse_str($_par['query'], $_query);
            unset($_query['page']);
            $_url = $baseUrl . http_build_query($_query);
            unset($_query['limit']);
            $limitUrl = $baseUrl. http_build_query($_query);
        } else {
            $_url = $baseUrl;
            $limitUrl = $baseUrl;

        }

        return ['_url'=>urldecode($_url),'limitUrl'=>$limitUrl];

    }     //数字目录

    private function pageList()
    {
        $_pagelist = '';
        for ($i = $this->bothnum; $i >= 1; $i--) {
            $_page = $this->page - $i;
            if ($_page < 1) {
                continue;
            }
            $_pagelist .= ' <li><a href="' . $this->url . '&page=' . $_page . '">' . $_page . '</a></li> ';
        }
        $_pagelist .= ' <li class="active"><a href="javascript:void(0);">' . $this->page . '</a></li> ';
        for ($i = 1; $i <= $this->bothnum; $i++) {
            $_page = $this->page + $i;
            if ($_page > $this->pagenum) {
                break;
            }
            $_pagelist .= ' <li><a href="' . $this->url . '&page=' . $_page . '">' . $_page . '</a></li> ';
        }

        return $_pagelist;
    }

    //首页
    private function first()
    {
        if ($this->page > $this->bothnum + 1) {
            return ' <li><a href="' . $this->url . '">1</a></li><li><a href="javascript:void(0);">...</a></li>';
        }
        return '';
    }

    //上一页
    private function prev()
    {
        if ($this->page == 1) {
            return '<li><a href="#">&laquo;</a></li>';
        }

        return ' <li><a href="' . $this->url . '&page=' . ($this->page - 1) . '">&laquo;</a></li> ';
    }

    //下一页
    private function next()
    {
        if ($this->page == $this->pagenum) {
            return '<li><a href="#">&raquo;</a></li>';
        }

        return ' <li><a href="' . $this->url . '&page=' . ($this->page + 1) . '">&raquo;</a></li> ';
    }

    //尾页
    private function last()
    {
        if ($this->pagenum - $this->page > $this->bothnum) {
            return '<li><a href="javascript:void(0);">...</a></li><li><a href="' . $this->url . '&page=' . $this->pagenum . '">' . $this->pagenum . '</a></li>';
        }
        return '';
    }

    //总数
    private function total()
    {
        return '<a href="javascript:void(0);">共' . $this->total . '条记录</a>';
    }

    //分页信息
    public function showpage($_show_total = true, $_page_one_show = false)
    {
        if ($this->pagenum == 1 && !$_page_one_show) {
            return '';
        }
        $selectOne = '';$selectTwo = '';$selectThree = '';$selectFour = '';

        $limit = isset($_GET['limit'])?$_GET['limit']:'';

        if($limit==50){
            $selectOne = 'selected';
        }elseif($limit==100){
            $selectTwo = 'selected';
        }elseif($limit==150){
            $selectThree = 'selected';
        }elseif($limit==200){
            $selectFour = 'selected';
        }

        $_page = '<div style="display: inline-block;height: 43px;"><span style="float: left;margin-left: 10px;">';
        $_page .= '<a href="javascript:void(0);">每页条数：</a>';
        $_page .= '<select id="changeLimit" class="pagination" style="width: 50px;height: 30px;margin-right: 10px;">';
        $_page .= '<option value="50" '.$selectOne.'>50</option>';
        $_page .= '<option value="100" '.$selectTwo.' >100</option>';
        $_page .= '<option value="150" '.$selectThree.' >150</option>';
        $_page .= '<option value="200" '.$selectFour.' >200</option>';
        $_page .= '</select></span>';
        $_page .= '<ul style="float: left" class="pagination">';

        if ($this->page != 1) {
            $_page .= $this->prev();
        }

        $_page .= $this->first();
        $_page .= $this->pageList();
        $_page .= $this->last();

        if ($this->pagenum != $this->page) {
            $_page .= $this->next();
        }

        $_page .= '</ul>';
        $_page.= '<span style="float: left;margin-left: 10px;">';
        $_page.= '<input class="pagination page-value" style="width: 50px;padding: 3px 5px;"  type="text" value="">';
        $_page.= '<input limitUrl="'.$this->limitUrl.'"  jumpUrl="'.$this->jumpUrl.'" id="page-search" class="pagination" style="color: #fff;background-color: #2083D6;border-color: #2083D6;padding: 3px 3px;margin: 10px;" type="button" value="GO" >';

        if ($_show_total) {
            $_page .= $this->total();
        }

        $_page.= '</span></div>';

        return $_page;
    }
}