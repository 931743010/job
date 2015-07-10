<?php
namespace Jobs\Controller;
use Common\Controller\AdminbaseController;
use Common\Model\CateModel;

class AdminJobsController extends AdminbaseController {
	
	protected $jobs;
	
	function _initialize() {
		parent::_initialize();
		$this->jobs = D("Common/Jobs");
	}
	
	function index(){
        $where = '1=1 ';
        if(isset($_GET['status'])){
            $status = intval($_GET['status']);
            if($status!=-1) {
                $where .= " and j.status= {$status}";
            }
            $this->assign("status",$status);
        }
        if(isset($_GET['catid'])){
            $catid = intval($_GET['catid']);
            if($catid!=-1) {
                $where .= " and j.catid={$catid}";
            }
            $this->assign("catid",$catid);

        }
        if(isset($_GET['keyword']) && $_GET['keyword']!=''){
            $keyword = I('get.keyword');
            if($keyword!='') {
                $where .= " and j.job_name like '%{$keyword}%'";
            }
            $this->assign("keyword",$keyword);

        }
        $count = $this->jobs->alias('j')->where($where)->count();
        $Page = page($count,10);
        $prefix = C("DB_PREFIX");
        $sql = "select j.*,c.name as category,n.nature_name from {$prefix}jobs j left JOIN {$prefix}cate c on c.id = j.catid LEFT  JOIN {$prefix}nature n on j.work_nature = n.id WHERE {$where} order by j.refreshtime desc ";
        $limit = " limit ".$Page->firstRow.','.$Page->listRows;
        $sql.=$limit;

        $data = $this->jobs->query($sql);
        $this->assign("Page",$Page->show('Admin'));
        $this->assign("jobs",$data);
        $cate = new CateModel();
        $cateData = $cate->getSelectList(0);
        $this->assign("cate",$cateData);

        $this->display();
	}
    //删除职位
    function delete(){
        if(!isset($_GET['id'])){
            $this->error("职位不存在");
            exit();
        }
        $id = intval($_GET['id']);
        $this->jobs->delete($id);
        $this->success("删除成功");
    }
	

	
}