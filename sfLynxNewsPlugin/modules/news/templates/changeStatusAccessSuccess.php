<?php echo jq_link_to_remote(image_tag($status.'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$sf_request->getParameter('id_nucleo'),
    'url'     =>  'news/changeStatusAccess?id_nucleo='.$sf_request->getParameter('id_nucleo').'&status='.$status.'&id_news='.$sf_request->getParameter('id_news'),
    'script'  => true,
    'before'  => "$('#status_".$sf_request->getParameter('id_nucleo')."').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
    'complete'=> "$('#list_permissions').html('<div class=ppalText>".__(sfConfig::get('mod_news_msn_ppal_permissions'))."</div>');"
));
?>
