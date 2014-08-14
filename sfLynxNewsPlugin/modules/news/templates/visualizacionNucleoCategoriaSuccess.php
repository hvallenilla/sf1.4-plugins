<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __('Visualização das notícia') ?>: <?php echo $news->getTitle()?> </h1>
    </div>
    <table width="100%" border="0">
        <tr valign="top">
            <td width="40%">
                <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
                    <thead>
                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <th>
                                <?php echo __('Nome núcleo') ?>
                            </th>
                            <th>
                                <?php echo __('Status') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($nucleos): ?>
                        <?php $i=0; ?>
                        <?php foreach ($nucleos as $nucleo): ?>
                        <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
                        <tr class="<?php echo $class;?>"  valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
                            <td class="borderBottomDarkGray" width="28" align="center">
                            &nbsp;
                            </td>
                            <td class="borderBottomDarkGray">
                                <div class="displayTitle">
                                    <div id="title">
                                        <?php if($sf_user->getAttribute('idProfile')!=$nucleo->getIdProfile() and $nucleo->getIdProfile()!=1 ): ?>
                                        <a href="javascript:void(0);" class="titulo"><?php echo $nucleo->getNameProfile() ?></a>
                                        <?php else:?>
                                        <?php echo $nucleo->getNameProfile() ?>
                                        <?php endif;?>
                                    </div>
                                    <div class="row-actions">
                                        <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                            <?php echo jq_link_to_remote(__('Exibido na categoria'), array(
                                                'update'  =>  'list_permissions',
                                                'url'     =>  'news/categoriasXNucleo?id_nucleo='.$nucleo->getIdProfile().'&id_news='.$sf_request->getParameter('id_news'),
                                                'script'  => true,
                                                'before' => "$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="borderBottomDarkGray" id="status_<?php echo $nucleo->getIdProfile()?>">
                                <?php $status = SfNewsAccessPeer::getActiveNucleoInNews($nucleo->getIdProfile(), $sf_request->getParameter('id_news')); ?>
                                <?php //echo $nucleo->getIdProfile().'-'.$sf_request->getParameter('id_news') ; ?>
                                <?php echo jq_link_to_remote(image_tag($status.'.png','alt="" title="" border=0'), array(
                                    'update'  =>  'status_'.$nucleo->getIdProfile(),
                                    'url'     =>  'news/changeStatusAccess?id_nucleo='.$nucleo->getIdProfile().'&status='.$status.'&id_news='.$sf_request->getParameter('id_news'),
                                    'script'  => true,
                                    'before'  => "$('#status_".$nucleo->getIdProfile()."').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
                                    'complete'=> "$('#list_permissions').html('<div class=ppalText>".__(sfConfig::get('mod_lxprofile_msn_ppal_permissions'))."</div>');"
                                ));
                                ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </td>
            <td width="10">&nbsp;</td>
            <td align="center" >
                <div id="list_permissions">
                    <div class="ppalText"><?php echo __(sfConfig::get('mod_lxprofile_msn_ppal_permissions')) ?></div>
                </div>
            </td>
        </tr>
    
</div>