<?php
App::uses('FrontAppController','Controller');

class ItemsController extends FrontAppController {

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
        $this->search();
    }
    function sale_rank(){

        $this->sort = 'sale';

        $member_id = $this->user_id;
        $param['member_id'] = $member_id;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($param);
        //$arrData = $this->Item->getPagingEntity($disp_num,$pgnum);

        // 商品ランキング
        $arrDatas = $this->Item->getSaleRankAll($this->display,$this->pg);

        $this->set('arrDatas',$arrDatas);

        $strH2[0] = '';
        $strH2[1] = '商品ランキング一覧';
        $this->set('strH2', $strH2);

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

        $this->set('tag', $this->tag);
        $this->set('category', $this->category);
        $this->set('keyword', $this->keyword);

        $url = '/item/sale_rank/?';
        $this->set('url', $url);
        $this->render('index');

    }
    function seller_rank(){

//        $member_id = $this->user_id;
//        $pgnum = Hash::get($this->request->query, 'pg');
//        $param['member_id'] = $member_id;
//        $this->Item->setWhereSortVal($sort);
//        $this->Item->setWhereVal($param);
//        $this->set('pgnum', $pgnum);

//        $arrSellerRank = $this->Member->getSellerRankAll($this->display,$pg);
        $arrDatas = $this->Member->getSellerRankAll($this->display, $this->pg);

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
        $url = '/item/seller_rank/?';
        $this->set('url', $url);
        $this->render('seller_rank');

    }
    function newData_rank(){
        $this->loadModel('Item');

        $this->sort = 'new';

        $member_id = $this->user_id;
        $param['member_id'] = $member_id;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($param);
        $arrDatas = $this->Item->getFrontNewDatasAll($this->display,$this->pg);

        $this->set('arrDatas',$arrDatas);

        $strH2[0] = '';
        $strH2[1] = '新着商品一覧';
        $this->set('strH2', $strH2);

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

        $this->set('tag', $this->tag);
        $this->set('category', $this->category);
        $this->set('keyword', $this->keyword);

        $url = '/item/newdata_rank/?';
        $this->set('url', $url);
        $this->render('index');

    }
    function pickup_rank(){
        $this->loadModel('Item');

        $this->sort = 'pickup';

        $member_id = $this->user_id;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['member_id'] = $member_id;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($param);

        $arrDatas = $this->Item->getPickUpAll($this->display,$this->pg, 10);

        $this->set('arrDatas',$arrDatas);

        $strH2[0] = '';
        $strH2[1] = 'PICKUP一覧';
        $this->set('strH2', $strH2);

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

        $this->set('tag', $this->tag);
        $this->set('category', $this->category);
        $this->set('keyword', $this->keyword);

        $url = '/item/pickup_rank/?';
        $this->set('url', $url);
        $this->render('index');

    }
    function category($category = null){
        $arrCategory = Configure::read('arrCategory');
        $this->set('arrCategory', $arrCategory);

        if(!empty($category)){

            // ページ番号取得

            $where['category_level'] = 'parent';
            $arrCategory = Configure::read('arrCategory');
            foreach($arrCategory as $parent => $row){
                if(isset($row[$category])){
                    $where['category_level'] = 'child';
                }
            }

            $where['category'] = $category;
            $where['selling'] = 1;
            $where['save_flg'] = 1;
            $this->Item->setWhereSortVal($this->sort);
            $this->Item->setWhereVal($where);
            $arrDatas = $this->Item->getPagingEntity($this->display,$this->pg);

            $this->set('arrDatas', $arrDatas);

            $this->set('strCategory', $category);

            $s_category = str_replace("-", " ＞ ", $category);

            $strH2[0] = $s_category;
            $strH2[1] = 'の検索結果';
            $this->set('strH2', $strH2);

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

            $this->set('tag', $this->tag);
            $this->set('category', $category);
            $this->set('keyword', $this->keyword);

            $url = '/item/category/'.$category.'/';
            $this->set('url', $url);
            $this->render('index');
        }

        // カテゴリ
        if(empty($category)){

            $arrDatas = $this->Item->getEntityByCategory();
            $this->set('arrDatas', $arrDatas);

            $this->render('category_index');
        }

    }

    function tag($tag = null){
        $arrTags = $this->Item->geTagList();

        if(!empty($tag)){

            $where['tag'] = $tag;
            $this->Item->setWhereSortVal($this->sort);
            $this->Item->setWhereVal($where);
            $arrDatas = $this->Item->getPagingEntity($this->display,$this->pg);
            $this->set('arrDatas', $arrDatas);

            $this->set('strCategory', $tag);

            $strH2[0] = $tag;
            $strH2[1] = 'の検索結果';
            $this->set('strH2', $strH2);

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

            $this->set('tag', $tag);
            $this->set('category', $this->category);
            $this->set('keyword', $this->keyword);

            $url = '/item/tag/'.$tag.'/';
            $this->set('url', $url);
            $this->render('index');
        }

        // カテゴリ
        if(empty($tag)){

            $this->set('arrDatas', $arrTags);

            $this->render('tag_index');
        }

    }

    function detail($id){
        $this->loadModel('Review');
        $this->loadModel('Config');
        // item/detail
        $member_id = $this->user_id;
        $arrMember = $this->Member->getDetail($member_id);
        if(!$this->Config->isDetailViewableWithoutLogin() && empty($arrMember)){
            $this->Session->setFlash("商品の閲覧にはログインが必要です。");
            $this->redirect('/mypage/login');
        }
        $this->set('arrMemberInfo',$arrMember);
        //
        $arrData = $this->Item->getDetail($id);
        if(empty($arrData)){
            $this->redirect('/');
        }
        $this->set('arrData',$arrData);

        // この商品を買った人はこんな商品も買っています
        $category = $arrData['Item']['category'];
        $arrLikeData = $this->Item->getEntityLikeCategory($category, 9);
        $this->set('arrLikeData',$arrLikeData);

        // この出品者の人気商品
        $member_id = $arrData['Item']['member_id'];
        $arrSaleRanking = $this->Item->getEntityBySaleCount($member_id, 9);
        $this->set('arrSaleRanking',$arrSaleRanking);

        // 商品ランキング
        $arrSaleRank = $this->Item->getSaleRankEntity(9);
        $this->set('arrSaleRank',$arrSaleRank);

        // 最近閲覧した商品
        $arrBrowse = $this->Browse->getEntityBySes($this->Session->id(),$this->user_id);
        $this->set('arrBrowse', $arrBrowse);

        // 閲覧情報
        $session_id = $this->Session->id();
        $this->Browse->addData($this->user_id,$id,$session_id);

        // レビュー表示
        $arrReview = $this->Review->getEntityByItemId($id);
        $this->set('arrReview', $arrReview);

        // レビュー投稿
//        $arrData = $this->Item->getDetail($data['Review']['item_id']);
//        $this->set('arrData',$arrData);

        // アイテムレビュー
        $reviews = $this->Review->findAllByItemId($id);
        $ratingAve = $this->Utility->calculateReviewAve($reviews);
        $this->set('ratingAve', $ratingAve);

        // レビュー可能かどうか？
        $this->loadModel('OrderItem');

//        $canWriteReview = $this->OrderItem->canWriteReview($this->user_id, $id) && !$this->Review->isReviewCompleted($this->user_id, $id);
        $canWriteReview = $this->OrderItem->canWriteReview($this->user_id, $id);

        $this->set('canWriteReview', $canWriteReview);

        $favorited = $this->FavoriteItem->find('count',array('conditions' => array('item_id' => $id,'member_id' => $this->user_id)));
        $this->set('favorited', $favorited > 0);

        $purchased = $this->Item->getDownloadFileInfo($id,$this->user_id);
        $this->set('purchased', $purchased);

        if ($this->request->is('post') || $this->request->is('put')) {
//            var_dump($canWriteReview); exit;
            if ($canWriteReview) {
                $data = $this->request->data;

                $data['Review']['member_id'] = @$this->user_id;
                if ($this->Review->saveData($data)) {
                    $redirect_url = '/item/detail/' . $data['Review']['item_id'];
                    $this->redirect($redirect_url);
                } else {
                    $this->Session->setFlash('レビューに失敗しました。', null, array(), 'auth');
                }
            } else {
                $this->Session->setFlash('購入者以外は投稿できません。');
            }
        }

        $authPass = $this->Session->read('password_'.$id);
        if(!empty($arrData['Item']['password']) && !$authPass){
            $this->render('password');
        }

    }

    public function password() {

        $data = $this->request->data;
        $arrData = $this->Item->getDetail($data['Item']['id']);
        $this->set('arrData',$arrData);

        // この商品を買った人はこんな商品も買っています
        $category = $arrData['Item']['category'];
        $arrLikeData = $this->Item->getEntityLikeCategory($category);
        $this->set('arrLikeData',$arrLikeData);

        // この出品者の人気商品
        $member_id = $arrData['Item']['member_id'];
        $arrSaleRanking = $this->Item->getEntityBySaleCount($member_id);
        $this->set('arrSaleRanking',$arrSaleRanking);

        // 最近閲覧した商品
        $arrBrowse = $this->Browse->getEntityBySes($this->Session->id(),$this->user_id);
        $this->set('arrBrowse', $arrBrowse);

        if ($this->request->is('post') || $this->request->is('put')) {
            if($this->Item->authPassword($data)) {
                $this->Session->write('password_'.$data['Item']['id'],true);
                $redirect_url = '/item/detail/'.$data['Item']['id'];
                $this->redirect($redirect_url);
            } else {
                $this->Session->setFlash('パスワードが違います',null,array(),'auth');
            }
        }

    }

    public function review_regist() {

        $this->loadModel('Review');

        $data = $this->request->data;
        $arrData = $this->Item->getDetail($data['Review']['item_id']);
        $this->set('arrData',$arrData);

        if ($this->request->is('post') || $this->request->is('put')) {
            $data['Review']['member_id']= @$this->user_id;
            if($this->Review->saveData($data)) {
                $redirect_url = '/item/detail/'.$data['Review']['item_id'];
                $this->redirect($redirect_url);
            } else {
                $this->Session->setFlash('パスワードが違います',null,array(),'auth');
            }
        }

    }

    function search(){

        $where['keywords'] = $this->keyword;
        $where['category'] = $this->category;
        $where['tag'] = $this->tag;

        $where['selling'] = 1;
        $where['save_flg'] = 1;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($where);
        $arrDatas = $this->Item->getPagingEntity($this->display,$this->pg);
        $this->set('arrDatas', $arrDatas);

        $strH2[0] = '';
        $strH2[1] = '検索結果';
        $this->set('strH2', $strH2);

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

        $this->set('tag', $this->tag);
        $this->set('category', $this->category);
        $this->set('keyword', $this->keyword);

        $this->set('is_search', 1);

//        $url = '/item/search/?keyword='.$keyword;
//        $this->set('url', $url);
        $this->render('index');

    }

    function member($member_id){

        $keyword = null;
        $where['member_id'] = $member_id;
        $where['selling'] = 1;
        $where['save_flg'] = 1;
        $this->Item->setWhereSortVal($this->sort);
        $this->Item->setWhereVal($where);
        $arrDatas = $this->Item->getPagingEntity($this->display,$this->pg);
        $this->set('arrDatas', $arrDatas);

        $arrMember = $this->Member->getDetail($member_id);
        // 20170730 mod
        $strH2[0] = $arrMember['Member']['company'].' '.$arrMember['Member']['name'].'さん';
        $strH2[1] = 'の検索結果';
        $this->set('strH2', $strH2);

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

        $this->set('tag', $this->tag);
        $this->set('category', $this->category);
        $this->set('keyword', $this->keyword);

        $url = '/item/member/'.$member_id.'/';
        $this->set('url', $url);
        $this->render('index');

    }

/**
 * お気に入り
 * */
    public function favorite($id) {

        $session_key = null;
        $user_id = @$this->user_id;
        if(empty($user_id)){
            $this->Session->write('redirect_url','/item/favorite/'.$id);
            $this->redirect('/mypage/login');
        }
        $session_key = @$this->Session->id();
        $data['item_id'] = $id;
        $data['member_id'] = $user_id;
        $data['session_key'] = $session_key;
        $cnt1 = $this->FavoriteItem->find('count',array('conditions' => array('item_id' => $id,'session_key' => $session_key)));
        $cnt2 = $this->FavoriteItem->find('count',array('conditions' => array('item_id' => $id,'member_id' => $user_id)));
        $res ='favorite_failure';
        if($cnt1 == 0 && $cnt2 == 0){
            $this->FavoriteItem->save($data);
            $res ='favorite_success';
        }
        $this->redirect('/item/detail/'.$id.'?favres='.$res);
    }

/**
 * ダウンロード
 * */
    function download($item_id){

        $this->autoRender = false;

        $arrData = $this->Item->getDownloadFileInfo($item_id,$this->user_id);
        if(empty($arrData)){
            $this->redirect('/');
        }

        $file_name = $arrData['Item']['file_name'];
        $file_path = $arrData['Item']['file_path'];

        // TODO ファイルが存在しない場合の処理
        if(empty($file_path)){
            $this->redirect('/');
        }

        $this->response->file($file_path);
        $this->response->download($file_name);

    }
}

?>
