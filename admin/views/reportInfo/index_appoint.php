<div class="box-detail-tab box-detail-tab mt15">
            <ul class="c">
                <?php $action=strtolower(Yii::app()->controller->getAction()->id);?>
                <li<?php if($action=='index_appoint'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('reportInfo/Index_appoint');?>">今日审核<?php echo '('.$todayCount.')'?></a>
                </li>
                <li<?php if($action=='index_appoint_wait'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('reportInfo/index_appoint_wait');?>">未审核<?php echo '('.$waitCount.')'?></a>
                </li>
                <li<?php if($action=='index_appoint_finish'){?> class="current"<?php }?>>
                    <a href="<?php echo $this->createUrl('reportInfo/index_appoint_finish');?>">审核列表<?php echo '('.$finishCount.')'?></a>
                </li>
            </ul>
        </div><!--box-detail-tab end-->
<span>操作时间：</span>
                <?php $start_date_search= Yii::app()->request->getParam('start_date');?>
                <input style="width:120px;" class="input-text" type="text" id="start_date"
                       name="start_date" value="<?php echo $start_date_search?$start_date_search:Date('Y-m-d') ?>">
                </label>
<script>
   var $start_date=$('#start_date');
            $start_date.on('click', function(){
                WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
</script>

