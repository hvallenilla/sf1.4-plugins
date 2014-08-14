<?php

class ArchivoNewsForm extends sfForm {
    
    public function configure() {
        $buscador = "";
        $idNews = sfContext::getInstance()->getRequest()->getParameter('id');
        $buscador = sfContext::getInstance()->getRequest()->getParameter('buscador');
        $modulesPaterns = SfArchivosSeccionPeer::findFilesNews($idNews, $buscador);
        
        $this->widgetSchema['id_news'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['archivo'] = new sfWidgetFormChoice(array('choices'  => $modulesPaterns,'expanded' => false),array('size' => '10'));
        
        $this->setDefault('id_news', $idNews);
        
        $this->validatorSchema['id_news']  = new sfValidatorString(array('required' => true, 'trim' => true));
        $this->validatorSchema['archivo']  = new sfValidatorString(array('required' => true, 'trim' => true));

        $this->widgetSchema->setNameFormat('wdarchivo[%s]');


    }

    

}
?>
