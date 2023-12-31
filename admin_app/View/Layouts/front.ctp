<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/ico/favicon.png" type="image/x-icon" rel="icon" fullBase="1" />
    <link href="/ico/favicon.png" type="image/x-icon" rel="shortcut icon" fullBase="1" />
    <title>ガンバロード管理画面</title>

    <!-- Bootstrap core CSS -->
    <?= $this->html->css('/css/bootstrap.css', array('fullBase' => true)); ?>

    <!-- Custom styles for this template -->
    <?= $this->html->css('/css/main.css', array('fullBase' => true)); ?>

    <?= $this->html->css('/css/font-awesome.min.css', array('fullBase' => true)); ?>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/Chart.js"></script>
    <script type="text/javascript" src="/js/modernizr.custom.js"></script>  
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/html5shiv.js"></script>
    <script type="text/javascript" src="/js/respond.min.js"></script>
    <![endif]-->
    <?= $this->html->css('ext.css', array('fullBase' => true)); ?>

  </head>

  <body>
		
<?= $this->fetch('content'); ?>
  <p><br></p>

  <!-- ========== FOOTER SECTION ========== -->
  <section id="contact" name="contact"></section>
  <div id="f">
    <div class="container">
      <div class="row">
          
          <div class="col-lg-4">
            <ul class="unav">
              <li><a href="">よくある質問</a></li>
              <li><a href="">お問い合わせ</a></li>
              <li><a href="">求人情報掲載について</a></li>
              <li><a href="">代理店希望</a></li>
              <li><a href="">個人情報保護方針</a></li>
              <li><a href="">免責事項</a></li>
              <li><a href="">利用規約</a></li>
              <li><a href="">サイトマップ</a></li>
            </ul>
          </div>
          
          <div class="col-lg-4">
            <p>
              <a href="index.html#"><i class="icon-facebook"></i></a>
              <a href="index.html#"><i class="icon-twitter"></i></a>
              <a href="index.html#"><i class="icon-envelope"></i></a>
            </p>
            <br>
          </div>
        </div>
    </div><!-- /container -->
  </div><!-- /f -->
  
  <div id="c">
    <div class="container">
      <p>Copyright © All Rights Reserved.  Powered by <a href=""></a></p>
    </div>
  </div>
  
  

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="/js/classie.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/smoothscroll.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
</body>
</html>
