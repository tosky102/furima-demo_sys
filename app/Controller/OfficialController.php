<?php
App::uses('FrontAppController','Controller');

class OfficialController extends FrontAppController {

    public $uses = array('Item','FavoriteItem','Member','Browse');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();

        $this->disp_num = $this->Session->read('sesDispNum');
        if ($this->request->is('post') &&
            @$this->request->data['formDispNum']['mode'] == 'changeDispNum') {
            $this->disp_num = $this->request->data['formDispNum']['disp_num'];
            $this->Session->write('sesDispNum',$this->disp_num);
        }
        if(empty($this->disp_num)){
            $this->disp_num = 20;
        }
        $this->set('disp_num',$this->disp_num);

        $this->sort = $this->Session->read('sesSort');
        if ($this->request->is('post') &&
            @$this->request->data['formDispNum']['mode'] == 'sort') {
            $this->sort = $this->request->data['formDispNum']['sort'];
            $this->Session->write('sesSort',$this->sort);
        }
        $this->set('setSort',$this->sort);

        $this->keyword = Hash::get($this->request->query, 'keyword') ? Hash::get($this->request->query, 'keyword') : '';
        $this->category = Hash::get($this->request->query, 'category') ? Hash::get($this->request->query, 'category') : '';
        $this->tag = Hash::get($this->request->query, 'tag') ? Hash::get($this->request->query, 'tag') : '';

        $this->sort = Hash::get($this->request->query, 'sort') ? Hash::get($this->request->query, 'sort') : '';
        $this->pg = Hash::get($this->request->query, 'pg') ? Hash::get($this->request->query, 'pg') : 1;
        $this->display = 20;

    }

    function index(){

        $arrOfficialSeller = $this->Member->getOfficialSellerEntity(5);
        $this->set('arrOfficialSeller',$arrOfficialSeller);

        $arrFrontNewDatas = $this->Item->getFrontOfficialNewDatas(10);
        $this->set('arrNewDatas',$arrFrontNewDatas);

        $arrPickUp = $this->Item->getPickUpOfficialEntity(10);
        $this->set('arrPickUp',$arrPickUp);

//        $cnt = $arrDatas['total'];
//
//        $pgTot = floor(($cnt - 1) / $this->display) + 1;
//
//        if ($this->pg < 3) {
//            $pgStart = 1; $pgEnd = min(5, $pgTot);
//        } else if ($this->pg > $pgTot - 2) {
//            $pgEnd = $pgTot;
//            $pgStart = max(1, $pgTot - 4);
//        } else {
//            $pgStart = $this->pg - 2;
//            $pgEnd = $this->pg + 2;
//        }
//
//        $this->set('sort', $this->sort);
//        $this->set('pg', $this->pg);
//        $this->set('pgStart', $pgStart);
//        $this->set('pgEnd', $pgEnd);
//        $this->set('pgTot', $pgTot);
//        $this->set('display', $this->display);
//
//        // print_r($arrSellerRank);exit;
//        $this->set('arrDatas',$arrDatas);
        $url = '/official/?';
        $this->set('url', $url);

    }

    function seller_rank(){
        $arrDatas = $this->Member->getOfficialSellerRankAll($this->display, $this->pg);
        $cnt = $arrDatas['total'];
        $pgTot = floor(($cnt - 1) / $this->display) + 1;
        if ($this->pg < 3) {
            $pgStart = 1; $pgEnd = min(5, $pgTot);
        } else if ($this->pg > $pgTot - 2) {
            $pgEnd = $pgTot;
            $pgStart = max(1, $pgTot - 4);
        } else {
            $pgStart = $this->pg - 2;
            $pgEnd = $this->pg + 2;
        }

        $this->set('sort', $this->sort);
        $this->set('pg', $this->pg);
        $this->set('pgStart', $pgStart);
        $this->set('pgEnd', $pgEnd);
        $this->set('pgTot', $pgTot);
        $this->set('display', $this->display);

        // print_r($arrSellerRank);exit;
        $this->set('arrDatas',$arrDatas);
        $url = '/official/seller_rank/?';
        $this->set('url', $url);
        $this->render('seller_rank');
    }

    function pickup_rank() {
        $this->loadModel('Item');

        $member_id = $this->user_id;
        $param['member_id'] = $member_id;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($param);

        $arrDatas = $this->Item->getPickUpOfficialAll($this->display,$this->pg);

        $this->set('arrDatas',$arrDatas);

        $cnt = $arrDatas['total'];

        $pgTot = floor(($cnt - 1) / $this->display) + 1;

        if ($this->pg < 3) {
            $pgStart = 1; $pgEnd = min(5, $pgTot);
        } else if ($this->pg > $pgTot - 2) {
            $pgEnd = $pgTot;
            $pgStart = max(1, $pgTot - 4);
        } else {
            $pgStart = $this->pg - 2;
            $pgEnd = $this->pg + 2;
        }

        $this->set('pg', $this->pg);
        $this->set('pgStart', $pgStart);
        $this->set('pgEnd', $pgEnd);
        $this->set('pgTot', $pgTot);
        $this->set('display', $this->display);

        $url = '/official/pickup_rank/?';
        $this->set('url', $url);
        $this->render('pickup_rank');
    }

    function newdata_rank() {
        $this->loadModel('Item');

        $member_id = $this->user_id;
        $param['member_id'] = $member_id;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($param);

        $arrDatas = $this->Item->getFrontOfficialNewDatasAll($this->display,$this->pg);

        $this->set('arrDatas',$arrDatas);

        $cnt = $arrDatas['total'];

        $pgTot = floor(($cnt - 1) / $this->display) + 1;

        if ($this->pg < 3) {
            $pgStart = 1; $pgEnd = min(5, $pgTot);
        } else if ($this->pg > $pgTot - 2) {
            $pgEnd = $pgTot;
            $pgStart = max(1, $pgTot - 4);
        } else {
            $pgStart = $this->pg - 2;
            $pgEnd = $this->pg + 2;
        }

        $this->set('pg', $this->pg);
        $this->set('pgStart', $pgStart);
        $this->set('pgEnd', $pgEnd);
        $this->set('pgTot', $pgTot);
        $this->set('display', $this->display);

        $url = '/official/newdata_rank/?';
        $this->set('url', $url);
        $this->render('newdata_rank');
    }

}

?>
