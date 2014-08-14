<div id="title_module">
    <div class="frameForm" >
        <h1><?php echo __($moduleParent['parent_name'])?> - <a href="<?php echo url_for('news/index') ?>"><?php echo __('Notícias')  ?></a> - <?php echo __('Nova notícia') ?> </h1>
    </div>
<?php include_partial('form', array('form' => $form)) ?>
</div>

