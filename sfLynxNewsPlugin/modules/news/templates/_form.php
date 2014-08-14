<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php  $appYml = sfConfig::get('app_upload_images_news'); ?>
<script type="text/javascript"> 
    $(document).ready(function() {
          $("#news").validationEngine()
    })
</script>
<form id="news" action="<?php echo url_for('news/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_news='.$form->getObject()->getIdNews() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="center">
  <table width="100%">
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td>
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Voltar na lista'), '@default?module=news&action=index&'.$sf_user->getAttribute('uri_news'), array('class' => 'button')) ?>
                        </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Eliminar'), 'news/delete?id_news='.$form->getObject()->getIdNews(), array('method' => 'delete', 'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                      <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                    <!--
                    <td>
                      <input type="submit" name="back" value="<?php echo __('Save and continue editing') ?>" />
                    </td>-->
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td>
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                           <?php echo link_to(__('Voltar na lista'), '@default?module=news&action=index&'.$sf_user->getAttribute('uri_news'), array('class' => 'button')) ?>
                        </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Eliminar'), 'news/delete?id_news='.$form->getObject()->getIdNews(), array('method' => 'delete', 'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                    <!--
                    <td>
                      <input type="submit" name="back" value="<?php echo __('Save and continue editing') ?>" />
                    </td>
                    -->
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                  <?php if(sfConfig::get('app_newsConfig_categories')): ?>
                    <tr>
                        <td><?php echo $form['category']->renderLabel() ?><br />
                                <?php echo $form['category'] ?>
                                <?php echo $form['category']->renderError() ?>
                        </td>
                    </tr>
                  <?php endif; ?>
                    <tr>
                      <td>
                          <?php $module = 'news'; ?>
                          <table cellpadding="0" cellspacing="0" border="0" width="80%" style="margin-top: 15px; margin-bottom: 15px;">
                              <tr>
                                  <td width="3%" align="left" >
                                      <div id="imageFIELD" style="min-height: 110px; min-width: 170px;">
                                          <?php if($form->getObject()->getImage()):  ?>
                                          <?php echo image_tag('/uploads/'.$module.'/'.$appYml['size_1']['pref_1'].'_'.$form->getObject()->getImage(), 'class="borderImage" width="150" height="110"')?>
                                          <?php else:?>
                                          <?php echo image_tag('no_image.jpg', 'border=0 width="150" height="110" class="borderImage"');?>
                                          <?php endif;?>
                                      </div>
                                  </td>
                                  <td width="67%" valign="bottom" style="padding-left:7px">
                                      <?php echo $form['image']->renderLabel() ?><br />
                                      <?php echo $form['image'] ?>
                                      <?php echo $form['image']->renderError() ?>
                                      <span class="msn_help"><?php echo $form['image']->renderHelp() ?></span>
                                  </td>
                              </tr>
                              <tr>
                                   <td>
                                       <?php if($form->getObject()->getImage()):?>
                                      <div id="deleteImage" style="margin-left: 40px;" >
                                          <?php echo jq_link_to_remote('Deletar Imagem', array(
                                                'update'  =>  'imageFIELD',
                                                'url'     =>  $module.'/deleteImage?id='.$form->getObject()->getIdNews(),
                                                'script'  => true,
                                                'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'),
                                                'before'  => "$('#imageFIELD').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');",
                                                'complete'=> "$('#deleteImage').html('');"
                                            ));
                                            ?>
                                      </div>
                                      <?php endif;?>
                                   </td>
                                   <td>&nbsp;</td>
                              </tr>
                          </table>
                    </td>
                  </tr>
                    <tr>
                      <td>
                          <?php $module = 'news'; ?>
                          <table cellpadding="0" cellspacing="0" border="0" width="80%" style="margin-top: 15px; margin-bottom: 15px;">
                              <tr>
                                  <td width="3%" align="left" >
                                      <div id="imageFIELD" style="min-height: 110px; min-width: 170px;">
                                          <?php if($form->getObject()->getImage()):  ?>
                                          <?php echo image_tag('/uploads/'.$module.'/'.$appYml['size_1']['pref_1'].'_'.$form->getObject()->getImagePrincipal(), 'class="borderImage" width="150" height="110"')?>
                                          <?php else:?>
                                          <?php echo image_tag('no_image.jpg', 'border=0 width="150" height="110" class="borderImage"');?>
                                          <?php endif;?>
                                      </div>
                                  </td>
                                  <td width="67%" valign="bottom" style="padding-left:7px">
                                      <?php echo $form['image_principal']->renderLabel() ?><br />
                                      <?php echo $form['image_principal'] ?>
                                      <?php echo $form['image_principal']->renderError() ?>
                                      <span class="msn_help"><?php echo $form['image_principal']->renderHelp() ?></span>
                                  </td>
                              </tr>
                              <tr>
                                   <td>
                                       <?php if($form->getObject()->getImagePrincipal()):?>
                                      <div id="deleteImage" style="margin-left: 40px;" >
                                          <?php echo jq_link_to_remote('Deletar Imagem', array(
                                                'update'  =>  'imageFIELD',
                                                'url'     =>  $module.'/deleteImagePrincipal?id='.$form->getObject()->getIdNews(),
                                                'script'  => true,
                                                'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'),
                                                'before'  => "$('#imageFIELD').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');",
                                                'complete'=> "$('#deleteImage').html('');"
                                            ));
                                            ?>
                                      </div>
                                      <?php endif;?>
                                   </td>
                                   <td>&nbsp;</td>
                              </tr>
                          </table>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['title']->renderLabel() ?><br />
                        <?php echo $form['title'] ?>
                        <?php echo $form['title']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['sub_title']->renderLabel() ?><br />
                        <?php echo $form['sub_title'] ?>
                        <?php echo $form['sub_title']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['home_title']->renderLabel() ?><br />
                        <?php echo $form['home_title'] ?>
                        <?php echo $form['home_title']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['summary']->renderLabel() ?><br />
                        <?php echo $form['summary'] ?>
                        <?php echo $form['summary']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['body']->renderLabel() ?><br />
                        <?php echo $form['body'] ?>
                        <?php echo $form['body']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['date']->renderLabel() ?><br />
                        <?php echo $form['date']->render() ?>
                        <?php echo $form['date']->renderError(); ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['author']->renderLabel() ?><br />
                        <?php echo $form['author'] ?>
                        <?php echo $form['author']->renderError() ?>
                    </td>
                  </tr>
                  
                  <?php if($sf_user->getAttribute('idProfile') == 1 || $sf_user->getAttribute('idProfile') == 2):?>
                  <tr style="display: none;">
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                  <?php endif; ?>
                  <tr style="display: none;">
                      <td><?php echo $form['home']->renderLabel() ?><br />
                        <?php echo $form['home'] ?>
                        <?php echo $form['home']->renderError() ?>
                    </td>
                  </tr>
                  <tr style="display: none;">
                      <td><?php echo $form['sticky']->renderLabel() ?><br />
                        <?php echo $form['sticky'] ?>
                        <?php echo $form['sticky']->renderError() ?>
                    </td>
                  </tr>
            </table>
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
