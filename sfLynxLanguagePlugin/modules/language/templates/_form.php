<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#language").validationEngine()
})
</script>

<form id="language" action="<?php echo url_for('language/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_language='.$form->getObject()->getIdLanguage() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

 <?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div id="frameForm" align="center">
  <table width="100%">
      <tr>
        <td colspan="2">
            &nbsp;<?php echo __('Fields marked with') ?> <span class="required">*</span> <?php echo __('are required')?>
        </td>
      </tr>
      <tr>
        <td>
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td colspan="2">
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Back to list'), '@default?module=language&action=index&'.$sf_user->getAttribute('uri_language'), array('class' => 'button')) ?>
                        </div>
                    </td>
                    <?php if (!$form->getObject()->isNew() && !$form->getObject()->getPrincipal()): ?>
                    <td>
                        <div class="button">
                                                            <?php echo link_to(__('Delete'), 'language/delete?id_language='.$form->getObject()->getIdLanguage(), array('method' => 'delete', 'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'), 'class' => 'button')) ?>
                                                    </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Save') ?>" />
                    </td>
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td colspan="2">
                                  <?php echo $form->renderHiddenFields(false) ?>
                        <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                               <?php echo link_to(__('Back to list'), '@default?module=language&action=index&'.$sf_user->getAttribute('uri_language'), array('class' => 'button')) ?>
                                            </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew() && !$form->getObject()->getPrincipal()): ?>
                    <td>
                        <div class="button">
                                            <?php echo link_to(__('Delete'), 'language/delete?id_language='.$form->getObject()->getIdLanguage(), array('method' => 'delete', 'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'), 'class' => 'button')) ?>
                                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Save') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                                          <tr>
                      <td><?php echo $form['language']->renderLabel() ?><br />
                        <?php echo $form['language'] ?>
                        <?php echo $form['language']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['country']->renderLabel() ?><br />
                        <?php echo $form['country'] ?>
                        <?php echo $form['country']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['principal']->renderLabel() ?><br />
                        <?php echo $form['principal'] ?>
                        <?php echo $form['principal']->renderError() ?>
                    </td>
                  </tr>
                              <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                                        </table>                
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
