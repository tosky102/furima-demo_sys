          <h1 class="page-header">求人情報公開設定</h1>

          <h2 class="sub-header">公開設定変更</h2>
<?= $this->Form->create('JobSchedule',array('id' => 'JobScheduleForm', 'url' => '/schedule/edit/'.$arrDataDetail['JobSchedule']['id'],'class' => 'form-horizontal','role'=>'form')); ?>

          <?= $this->Form->input('id',
                array('type'=>'hidden',
                      'default' => $arrDataDetail['JobSchedule']['id']
                      )) ?>

          <?= $this->Form->input('job_data_id',
                array('type'=>'hidden',
                      'default' => $arrDataDetail['JobData']['id']
                      )) ?>

          <div class="form-group">
            <label class="col-sm-3 control-label">タイトル</label>
            <div class="col-sm-9">
<?= $this->Form->input('title',array('label'=>false,'type'=>'textarea','rows' => 2,'class'=>'form-control noScroll','readonly' => 'readonly','default' => $arrDataDetail['JobData']['title'])) ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">公開開始日</label>
            <div class="col-sm-9">
<?= $this->Form->dateTime('start','YMD','NONE',$start_option)?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">公開終了日</label>
            <div class="col-sm-9">
<?= $this->Form->dateTime('end','YMD','NONE',$end_option)?>
            </div>
          </div>

          <hr>
          <div class="form-group">
            <div class="col-sm-3"></div>
              <div class="col-sm-9">公開開始日は当日以降のみ設定が有効なります。<br>前日以前を設定した場合、自動的に当日に設定されます。<br>公開終了日は開始日より最大3週間が設定されます。<br>3週間以上を設定された場合も自動的に3週間目に設定されます。<br>また、一度開始日を設定したら終了日が来るまで再設定出来ませんので、お気を付け下さい。</div>
            </div>
          </div>
          <hr>

          <div class="submitButton"><button class="btn btn-lg btn-primary btnW200" type="submit">設定</button></div>
    
<?php echo $this->Form->end(); ?>
