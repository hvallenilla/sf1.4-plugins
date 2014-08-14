<?php

class VideoNewsForm extends sfForm {
    
    public function configure() {
        $idNews = sfContext::getInstance()->getRequest()->getParameter('id');
        $modulesPaterns = VideosPeer::findVideosForNews($idNews);
        
        $this->widgetSchema['id_news'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['video'] = new sfWidgetFormChoice(array('choices'  => $modulesPaterns,'expanded' => false),array('size' => '10'));
        
        $this->setDefault('id_news', $idNews);
        
        $this->validatorSchema['id_news']  = new sfValidatorString(array('required' => true, 'trim' => true));
        $this->validatorSchema['video']  = new sfValidatorString(array('required' => true, 'trim' => true));

        $this->widgetSchema->setNameFormat('scvideo[%s]');


    }

    
}
?>
