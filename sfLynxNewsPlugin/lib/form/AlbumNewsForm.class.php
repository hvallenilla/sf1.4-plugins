<?php

class AlbumNewsForm extends sfForm {
    
    public function configure() {
        $idNews = sfContext::getInstance()->getRequest()->getParameter('id');
        $modulesPaterns = SfAlbumPeer::findAlbunesForNews($idNews);
        
        $this->widgetSchema['id_news'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['album'] = new sfWidgetFormChoice(array('choices'  => $modulesPaterns,'expanded' => false),array('size' => '10'));
        
        $this->setDefault('id_news', $idNews);
        
        $this->validatorSchema['id_news']  = new sfValidatorString(array('required' => true, 'trim' => true));
        $this->validatorSchema['album']  = new sfValidatorString(array('required' => true, 'trim' => true));

        $this->widgetSchema->setNameFormat('wdalbum[%s]');


    }

    
}
?>
