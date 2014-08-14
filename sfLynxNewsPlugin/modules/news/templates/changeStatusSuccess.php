<?php if($field == 'status'): ?>
<?php echo jq_link_to_remote(image_tag($SfNews->getStatus().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$SfNews->getIdNews(),
    'url'     =>  'news/changeStatus?id_news='.$SfNews->getIdNews().'&status='.$SfNews->getStatus().'&field=status',
    'script'  => true,
    'before'  => "$('#status_".$SfNews->getIdNews()."').html('". image_tag('preload.gif','title="" alt=""')."');"
)); ?>
<?php endif; ?>

<?php if($field == 'home'): ?>
<?php echo jq_link_to_remote(image_tag($SfNews->getHome().'.png','alt="" title="" border=0'), array(
    'update'  =>  'home_'.$SfNews->getIdNews(),
    'url'     =>  'news/changeStatus?id_news='.$SfNews->getIdNews().'&home='.$SfNews->getHome().'&field=home',
    'script'  => true,
    'before'  => "$('#home_".$SfNews->getIdNews()."').html('". image_tag('preload.gif','title="" alt=""')."');"
)); ?>
<?php endif; ?>

<?php if($field == 'sticky'): ?>
<?php echo jq_link_to_remote(image_tag($SfNews->getSticky().'.png','alt="" title="" border=0'), array(
    'update'  =>  'sticky_'.$SfNews->getIdNews(),
    'url'     =>  'news/changeStatus?id_news='.$SfNews->getIdNews().'&sticky='.$SfNews->getSticky().'&field=sticky',
    'script'  => true,
    'before'  => "$('#sticky_".$SfNews->getIdNews()."').html('". image_tag('preload.gif','title="" alt=""')."');"
)); ?>
<?php endif; ?>