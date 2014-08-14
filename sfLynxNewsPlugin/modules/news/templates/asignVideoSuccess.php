<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<script type="text/javascript"> 
$(document).ready(function() {
      $("#news_video").validationEngine()
})
</script>
<div id="title_module">
    <div class="frameForm">
        <h1><?php echo 'Notícia'?>: <?php echo $namesection ?> </h1>
        <h1><?php echo __('Asignar Videos') ?> </h1>
        
    </div>
    <form id="news_video" action="<?php echo url_for('news/saveAsingVideo?id='.$sf_request->getParameter('id')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

<div class="frameForm" align="center">
    <table width="100%" >
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com ') ?> <span class="required">*</span> <?php echo __('são obrigatórios')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
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
                            <?php if($sf_request->getParameter('back')):?>
                                    <?php echo link_to(__('Voltar'), '@default?module=news&action=editContenido&id='.$sf_request->getParameter('id').'&language='.$sf_request->getParameter('language').'', array('class' => 'button')) ?>
                                <?php else:?>
                                    <?php echo link_to(__('Voltar na lista'), '@default?module=news&action=index&'.$sf_user->getAttribute('uri_news'), array('class' => 'button')) ?>
                                <?php endif;?>
                            </div>
                        </td>            

                        <td>
                        <input type="submit" value="<?php echo __('Salvar') ?>" />
                        </td>
                    </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td width="30%">                
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                  <tr>
                      <td>
                        <?php echo $form['video']->renderLabel() ?><br />
                        <?php echo $form['video']->render(); ?>                          
                        <?php echo $form['video']->renderError() ?>
                    </td>
                  </tr>                  
                  
                </table>
            </td>
            <td valign="top">
                <b>Videos actuales para a notícia: <?php echo $namesection ?> </b><br /><br />
                <?php if($videosActuales): ?>
                    
                    <?php foreach ($videosActuales as $val): ?>
                        <?php echo $val['video'] ?> 
                        <?php echo link_to(__('Delete'),'news/deleteSectionVideo?id='.$val['id_news_video'], array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        <br />
                    <?php endforeach; ?>
                <?php else: ?>
                     Não há galerias anexados a notícia
                <?php endif;?>
            </td>
        </tr>
    </tbody>
  </table>
    </div>
</form>
</div>