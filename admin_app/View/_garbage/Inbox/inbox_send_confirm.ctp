          <h1 class="page-header">受信トレイ</h1>

          <h2 class="sub-header">メール返信</h2>
<?= $this->Form->create('EmailData',array('id' => 'EmailDataForm', 'url' => '/inbox/inbox_send_confirm/'.$intEmailDataId,'class' => 'form-horizontal','role'=>'form')); ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><?= h($arrInboxMail['EmailData']['subject']) ?></h3>
            <div class="Rfloat">
              宛先人：<?= h($arrInboxMail['EmailData']['to_name']) ?>
            </div><br class="clear">
          </div>
          <div class="panel-body">
            <?= nl2br(h($arrInboxMail['EmailData']['body'])) ?>
          </div>
        </div>
        <a href="/inbox"><button type="button" class="btn btn-primary btn-lg">修　　正</button></a>
        <button type="submit" class="btn btn-primary btn-lg">送信確定</button>
        <a href="/inbox"><button type="button" class="btn btn-primary btn-lg">一覧へ戻る</button></a>
<?php echo $this->Form->end(); ?>
      </div>
