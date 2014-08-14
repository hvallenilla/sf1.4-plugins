<?php

/**
 * language actions.
 *
 * @package    lynx4
 * @subpackage language
 * @author     Your name here
 */
class languageActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' language - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  SfLanguagePeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {

				case 'desc':
					$c->addDescendingOrderByColumn(SfLanguagePeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(SfLanguagePeer::$this->getRequestParameter('sort'));
					$this->by = "desc";
					$this->by_page = "asc";
					break;
			}
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
                //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
                		                                    $criterio = $c->getNewCriterion(SfLanguagePeer::ID_LANGUAGE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(SfLanguagePeer::LANGUAGE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SfLanguagePeer::COUNTRY, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SfLanguagePeer::PRINCIPAL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SfLanguagePeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('SfLanguage',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->SfLanguages = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_language','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SfLanguages->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
     //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' language - Lynx Cms');
    $this->form = new SfLanguageForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' language - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("language/new");
    }
    

    $this->form = new SfLanguageForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' language - Lynx Cms');
    $this->forward404Unless($SfLanguage = SfLanguagePeer::retrieveByPk($request->getParameter('id_language')), sprintf('Object SfLanguage does not exist (%s).', $request->getParameter('id_language')));
    $this->form = new SfLanguageForm($SfLanguage);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($SfLanguage = SfLanguagePeer::retrieveByPk($request->getParameter('id_language')), sprintf('Object SfLanguage does not exist (%s).', $request->getParameter('id_language')));
    $this->form = new SfLanguageForm($SfLanguage);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($SfLanguage = SfLanguagePeer::retrieveByPk($request->getParameter('id_language')), sprintf('Object SfLanguage does not exist (%s).', $request->getParameter('id_language')));
    if($SfLanguage->getPrincipal())
    {
        $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__(sfConfig::get('mod_language_msn_error_language_principal')));
        return $this->redirect($request->getReferer());
    }
    $SfLanguage->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('language/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($SfLanguage = SfLanguagePeer::retrieveByPk($val), sprintf('Object SfLanguage does not exist (%s).', $request->getParameter('id_language')));
                    if(!$SfLanguage->getPrincipal()){
                        $SfLanguage->delete();
                    }
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('language/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $SfLanguage = $form->save();
      if($form->getValue('principal')){
        SfLanguagePeer::desactiveAllLanguages();  /** Desactiva todos los idiomas**/
        SfLanguagePeer::setPrincipalLanguage($SfLanguage->getIdLanguage()); /* Activo el idioma */
      }
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_language')){
        return $this->redirect('@default?module=language&action=index&'.$this->getUser()->getAttribute('uri_language'));
      }else{
        return $this->redirect('language/index');
      }
    }
  }
}
