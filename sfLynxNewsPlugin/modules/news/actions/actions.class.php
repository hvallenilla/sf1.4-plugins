<?php

/**
 * news actions.
 *
 * @package    
 * @subpackage news
 * @author     Your name here
 */
class newsActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista de Notícias').' - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'title';      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {
				case 'desc':
					$c->addDescendingOrderByColumn(SfNewsPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(SfNewsPeer::$this->getRequestParameter('sort'));
					$this->by = "desc";
					$this->by_page = "asc";
					break;
			}
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
      //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
      sfConfig::set('sf_escaping_strategy', false);
      //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
      $criterio = $c->getNewCriterion(SfNewsPeer::TITLE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
      $criterio->addOr($c->getNewCriterion(SfNewsPeer::DATE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
      $criterio->addOr($c->getNewCriterion(SfNewsPeer::AUTHOR, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
      $c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}

    //Si existen categorias configuradas en el app.yml del backend
    if(sfConfig::get('app_newsConfig_categories'))
    {
      if(!$request->hasParameter('category'))
      {
        //$c->add(SfNewsPeer::CATEGORY, '0');
      }else{

        if($request->getParameter('category') != 'all')
        {
            //$c->add(SfNewsPeer::CATEGORY, $request->getParameter('category'));
        }                     
      }
    }

    if($this->getUser()->getAttribute('idProfile') > 2)
    {
      $c->add(SfNewsPeer::ID_PROFILE, sfContext::getInstance()->getUser()->getAttribute('idProfile'));
    }
                
		$pager = new sfPropelPager('SfNews',15);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->SfNewss = $pager;                
    // Crea sesion de la uri al momento
    $this->getUser()->setAttribute('uri_news','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SfNewss->getPage());
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Agregar notícia').' - Lynx Cms');
    $this->form = new SfNewsForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar notícia').' - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("news/new");
    }
    $this->form = new SfNewsForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar notícia').' - Lynx Cms');
    $this->forward404Unless($SfNews = SfNewsPeer::retrieveByPk($request->getParameter('id_news')), sprintf('Object SfNews does not exist (%s).', $request->getParameter('id_news')));
    $this->form = new SfNewsForm($SfNews);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($SfNews = SfNewsPeer::retrieveByPk($request->getParameter('id_news')), sprintf('Object SfNews does not exist (%s).', $request->getParameter('id_news')));
    $this->form = new SfNewsForm($SfNews);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($SfNews = SfNewsPeer::retrieveByPk($request->getParameter('id_news')), sprintf('Object SfNews does not exist (%s).', $request->getParameter('id_news')));

    //Remove the asociated image
    if ($SfNews->getImage())
    {
        $appYml = sfConfig::get('app_upload_images_news');
        $uploadDir = sfConfig::get('sf_upload_dir').'/news/';

        for($i=1;$i<=$appYml['copies'];$i++)
        {
          // Elimino las fotos de la carpeta
          if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$SfNews->getImage()))
          {
            unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$SfNews->getImage());
          }
        }
    }

    //Album delete images process
    $c = new Criteria();
    $c->add(SfAlbumPeer::ID_RELATION, $request->getParameter('id_news'));
    $items = SfAlbumPeer::doSelect($c);

    if ($items)
    {
        foreach($items as $item)
        {
            $item->setIdRelation(0);
            $item->save();
        }
    }
    $SfNews->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('news/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
  if ($this->getRequestParameter('chk'))
  {
    foreach ($this->getRequestParameter('chk') as $gr => $val)
    {
      $this->forward404Unless($SfNews = SfNewsPeer::retrieveByPk($val), sprintf('Object SfNews does not exist (%s).', $request->getParameter('id_news')));

      //Remove the asociated image
      if ($SfNews->getImage())
      {
        $appYml = sfConfig::get('app_upload_images_news');
        $uploadDir = sfConfig::get('sf_upload_dir').'/news/';

        for($i=1;$i<=$appYml['copies'];$i++)
        {
          // Elimino las fotos de la carpeta
          if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$SfNews->getImage()))
          {
            unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$SfNews->getImage());
          }
        }
      }

    //Album delete images process
    $c = new Criteria();
    $c->add(SfAlbumPeer::ID_RELATION, $SfNews->getIdNews());
    $items = SfAlbumPeer::doSelect($c);

    if ($items)
    {
        foreach($items as $item)
        {
            $item->setIdRelation(0);
            $item->save();
        }
    }

      $SfNews->delete();
    }
    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
  }
  return $this->redirect('news/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

    if ($form->isValid())
    {
      $SfNews = $form->save();

      //Permalink process
      $SfNews->setPermalink($SfNews->getUrlPermalink($SfNews->getTitle()));
      if(!$form->getValue('date')){
        $SfNews->setDate(date('Y-m-d'));
      }
      $SfNews->save();

      //Image process
      if($form->getValue('image'))
      {
        $file = $form->getValue('image');
        $Model = SfNewsPeer::retrieveByPK($SfNews->getIdNews());

        // Aqui cargo la imagen con la funcion loadFiles de mi Helper
        sfProjectConfiguration::getActive()->loadHelpers('uploadFile');
        $fileUploaded = loadFiles($file->getOriginalName(), $file->getTempname(), 0, sfConfig::get('sf_upload_dir').'/news/', $Model->getIdNews(), false);
        $Model->setImage($fileUploaded);
        $Model->save();
      }
      if($form->getValue('image_principal'))
      {
          
        $file = $form->getValue('image_principal');
        $Model = SfNewsPeer::retrieveByPK($SfNews->getIdNews());
        //echo $Model->getIdNews();exit();
        // Aqui cargo la imagen con la funcion loadFiles de mi Helper
        sfProjectConfiguration::getActive()->loadHelpers('uploadFile');
        $fileUploaded = loadFiles($file->getOriginalName(), $file->getTempname(), 0, sfConfig::get('sf_upload_dir').'/news/', $Model->getIdNews(), false);
        $Model->setImagePrincipal($fileUploaded);
        $Model->save();
      }

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_news') && !$request->getParameter('back')){
        return $this->redirect('@default?module=news&action=index&'.$this->getUser()->getAttribute('uri_news'));
      }elseif($request->getParameter('back') == 'Save and Continue Editing'){
        return $this->redirect('@default?module=news&action=edit&id_news='.$SfNews->getIdNews());
      }else{
        return $this->redirect('news/index');
      }
    }
  }

  public function executeChangeStatus(sfWebRequest $request)
  {
      $this->forward404Unless($this->SfNews = SfNewsPeer::retrieveByPK($request->getParameter('id_news')), sprintf('Object News does not exist (%s).', $request->getParameter('id_news')));
      $this->field = $request->getParameter('field');

      if ($request->getParameter('field') == 'status')
      {
          if($request->getParameter('status'))
          {
            $this->SfNews->setStatus(0);
          }else{
            $this->SfNews->setStatus(1);
          }
          $this->SfNews->save();
      }

      if ($request->getParameter('field') == 'home')
      {
          if($request->getParameter('home'))
          {
            $this->SfNews->setHome(0);
          }else{
            $this->SfNews->setHome(1);
          }
          $this->SfNews->save();
      }

      if ($request->getParameter('field') == 'sticky')
      {
          if($request->getParameter('sticky'))
          {
            $this->SfNews->setSticky(0);
          }else{
            $this->SfNews->setSticky(1);
          }
          $this->SfNews->save();
      }
  }

  public function executeDeleteImage(sfWebRequest $request)
  {
    $this->forward404Unless($Model = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Model does not exist (%s).', $request->getParameter('id')));
    

    //Delete images process
    if ($Model->getImage())
    {
      $appYml = sfConfig::get('app_upload_images_news');
      $uploadDir = sfConfig::get('sf_upload_dir').'/news/';
      for($i=1;$i<=$appYml['copies'];$i++)
      {
        //Delete images from uploads directory
        if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImage()))
        {
          
          unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImage());
        }
      }
    }
    $Model->setImage('');
    $Model->save();
  }
  
  public function executeDeleteImagePrincipal(sfWebRequest $request)
  {
    $this->forward404Unless($Model = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Model does not exist (%s).', $request->getParameter('id')));
    

    //Delete images process
    if ($Model->getImagePrincipal())
    {
      $appYml = sfConfig::get('app_upload_images_news');
      $uploadDir = sfConfig::get('sf_upload_dir').'/news/';
      for($i=1;$i<=$appYml['copies'];$i++)
      {
        //Delete images from uploads directory
        if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImagePrincipal()))
        {
          
          unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getImagePrincipal());
        }
      }
    }
    $Model->setImagePrincipal('');
    $Model->save();
  }
  
  public function executeVisualizacionNucleoCategoria(sfWebRequest $request)
  {
      $this->setLayout('layoutSimple');
      $this->forward404Unless($this->news = SfNewsPeer::retrieveByPk($request->getParameter('id_news')), sprintf('Object Model does not exist (%s).', $request->getParameter('id_news')));
      
      $this->nucleos = LxProfilePeer::getProfileWithoutAdminAndRoot();
      
  }
  
  public function executeCategoriasXNucleo(sfWebRequest $request)
  {
      if(!SfNewsAccessPeer::getActiveNucleoInNews($request->getParameter('id_nucleo'), $request->getParameter('id_news'))){
        echo '<div class="ppalText">'.$this->getContext()->getI18N()->__(sfConfig::get('mod_news_msn_no_permissions')).'</div>';
        exit();
      }
      $this->categoryInNucleo = SfNewsAccessPeer::getSelectActiveNucleoInNews($request->getParameter('id_nucleo'), $request->getParameter('id_news'));
  }
  
  public function executeChangeCategoryInNuclueByNews(sfWebRequest $request)
  {
      $this->forward404If(!$request->getParameter('id_nucleo') && !$request->getParameter('id_news') && !$request->getParameter('category'));
      $access = SfNewsAccessPeer::getSelectActiveNucleoInNews($request->getParameter('id_nucleo'), $request->getParameter('id_news'));
      $access->setCategoria($request->getParameter('category'));
      $access->save();
      return sfView::NONE;
  }
  
  /**
   * Cambia el status del nucleo para la noticia
   *
   * @param sfWebRequest $request
   */
  public function executeChangeStatusAccess(sfWebRequest $request)
  {
      $this->nucleo = SfNewsAccessPeer::getSelectActiveNucleoInNews($request->getParameter('id_nucleo'),$request->getParameter('id_news'));
      $this->forward404If(!$request->getParameter('id_nucleo') && !$request->getParameter('id_news'));
      if($request->getParameter('status'))
      {
        $this->editAccess = SfNewsAccessPeer::retrieveByPk($this->nucleo->getIdAccess());
        $this->editAccess->delete();
        $this->status = 0;
        
      }else{
        $this->editAccess = new SfNewsAccess();
        $this->editAccess->setIdNucleo($request->getParameter('id_nucleo'));
        $this->editAccess->setIdNews($request->getParameter('id_news'));
        $this->editAccess->save();
        $this->status = 1;
      }
  }
  
  
  public function executeAsignFile(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        $this->form = new ArchivoNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        
        $this->archivosActuales = SfNewsPeer::getFilesNews($request->getParameter('id'));
    }
    
    public function executeSaveAsingFile(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("news/index");
        }
        $this->form = new ArchivoNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignFile($request, $this->form);
        $this->archivosActuales = SfNewsPeer::getFilesNews($request->getParameter('id'));
        $this->setTemplate('asignFile');
    }
    
    protected function processFormAsignFile(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfNewsArchivos();
            $newFileSection->setIdNews($form->getValue('id_news'));
            $newFileSection->setIdArchivo($form->getValue('archivo'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('news/asignFile?id='.$form->getValue('id_news'));
        }
    }
    
    public function executeDeleteNewsFile(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfArchivosNews = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfArchivosNews does not exist (%s).', $request->getParameter('id')));
        $SfArchivosNews->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('news/asignFile?id='.$SfArchivosNews->getIdNews());
    }
    
    
    /**
     * ALBUMES PARA LA NOTICIA*/
    
    public function executeAsignAlbum(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfNews does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        $this->form = new AlbumNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        
        $this->albunesActuales = SfNewsAlbumPeer::getAlbumNews($request->getParameter('id'));
    }
    
    public function executeSaveAsingAlbum(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("news/index");
        }
        $this->form = new AlbumNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignAlbum($request, $this->form);
        $this->albunesActuales = SfNewsAlbumPeer::getAlbumNews($request->getParameter('id'));
        $this->setTemplate('asignAlbum');
    }
    
    public function executeDeleteNewsAlbum(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfNewsAlbum = SfNewsAlbumPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfArchivosAlbum does not exist (%s).', $request->getParameter('id')));
        $SfNewsAlbum->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('news/asignAlbum?id='.$SfNewsAlbum->getIdNews());
    }
    
    protected function processFormAsignAlbum(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfNewsAlbum();
            $newFileSection->setIdNews($form->getValue('id_news'));
            $newFileSection->setIdAlbum($form->getValue('album'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('news/asignAlbum?id='.$form->getValue('id_news'));
        }
    }
    
        /**
     * VIDEOS PARA LA NOTICIA*/
    
    public function executeAsignVideo(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        $this->form = new VideoNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->videosActuales = SfNewsVideoPeer::getVideoNews($request->getParameter('id'));
    }
    
    public function executeSaveAsingVideo(sfWebRequest $request)
    {
        sfConfig::set('sf_escaping_strategy', false);
        $this->forward404Unless($this->sf_news = SfNewsPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfSection does not exist (%s).', $request->getParameter('id')));
        $this->namesection = $this->sf_news->getTitle();
        
        if (!$request->isMethod('post'))
        {
            $this->redirect("news/index");
        }
        $this->form = new VideoNewsForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processFormAsignVideo($request, $this->form);
        $this->videosActuales = SfNewsVideoPeer::getVideoNews($request->getParameter('id'));
        $this->setTemplate('asignVideo');
    }
    
    public function executeDeleteSectionVideo(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($SfNewsVideo = SfNewsVideoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object SfNewsVideo does not exist (%s).', $request->getParameter('id')));
        $SfNewsVideo->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('news/asignVideo?id='.$SfNewsVideo->getIdNews());
    }
    
    protected function processFormAsignVideo(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid())
        {
            $newFileSection = new SfNewsVideo();
            $newFileSection->setIdNews($form->getValue('id_news'));
            $newFileSection->setIdVideo($form->getValue('video'));
            $newFileSection->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            return $this->redirect('news/asignVideo?id='.$form->getValue('id_news'));
        }
    }
}
