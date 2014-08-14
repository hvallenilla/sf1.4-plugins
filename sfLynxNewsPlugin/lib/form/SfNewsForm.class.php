<?php
/**
 * SfNews form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */

class SfNewsForm extends BaseSfNewsForm
{
  public function configure()
  {
    $fieldSize = 69;
    $idProfile = sfContext::getInstance()->getUser()->getAttribute('idProfile');
    // widgets
    $this->widgetSchema['id_profile'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['title']->setAttributes(array('class' => 'validate[required]', 'size' => $fieldSize));
    $this->widgetSchema['sub_title']->setAttributes(array('size' => $fieldSize));
    $this->widgetSchema['body'] = new sfWidgetFormRichTextarea(array('tool'=>'Custom','height' => '400'),array('class' => 'validate[required]'));
    $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array('config' => '{}','culture'=>'en'));
    $this->widgetSchema['summary'] = new sfWidgetFormTextarea(array(),array('cols' => '79', 'rows' => '10'));
    $this->widgetSchema['author']->setAttributes(array('size' => $fieldSize));
    
    $this->widgetSchema['image_principal'] = new sfWidgetFormInputFileEditable(array(
      'file_src' => sfConfig::get('sf_upload_dir').'/news/'.$this->getObject()->getImagePrincipal(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'      => '<div>%file%<br />%input%<br /></div>',
    ));
    
    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'file_src' => sfConfig::get('sf_upload_dir').'/news/'.$this->getObject()->getImage(),
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'      => '<div>%file%<br />%input%<br /></div>',
    ));
    
    
    
    $types = array('1' => 'Habilitado', '0' => 'Desabilitado');
    $this->setDefault('id_profile',$idProfile);
    if($idProfile == 1 || $idProfile ==  2)
    {
        $this->widgetSchema['status'] = new sfWidgetFormSelect(array('choices' => $types));
    }else{
        $this->widgetSchema['status'] = new sfWidgetFormInputHidden(array(), array('value' => 0));
    }
    
    $this->widgetSchema['sticky'] = new sfWidgetFormSelect(array('choices' => $types));
    $this->widgetSchema['home']   = new sfWidgetFormSelect(array('choices' => $types));
    $this->widgetSchema['home_title']->setAttributes(array('size' => $fieldSize));

    if(sfConfig::get('app_newsConfig_categories'))
    {
      $cont = sfConfig::get('app_newsConfig_categories');
      $this->widgetSchema['category'] = new sfWidgetFormSelect(array('choices' => $cont));
    }

    //Validators
    
    $this->validatorSchema['title'] = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['body']  = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['summary']   = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['image_principal'] = new sfValidatorFile(array(
     'required'   => false,
     'max_size'   => sfConfig::get('app_image_size'),
     'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif'),
    ));
    
    $this->validatorSchema['image'] = new sfValidatorFile(array(
     'required'   => false,
     'max_size'   => sfConfig::get('app_image_size'),
     'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif'),
    ));
    
    $this->validatorSchema['image_principal'] = new sfImageFileValidator(array(
          'required'      => false,
          'mime_types'    => array('image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'),
          'max_size'      => sfConfig::get('app_image_size'),
          'min_height'    => '398',
          'min_width'     => '1000',
          'path'          => false,
      ), array(
          'required'      => "La imagen principal es requerida",
          'min_width'     => "El ancho de la imagen es muy corto (mínimo es %min_width%px, tiene %width%px ).",
          'min_height'    => "La altura mínima de la imagen debe ser 398px."
    ));
    
    $this->validatorSchema['image'] = new sfImageFileValidator(array(
          'required'      => false,
          'mime_types'    => array('image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'),
          'max_size'      => sfConfig::get('app_image_size'),
          'min_height'    => '156',
          'min_width'     => '226',
          'path'          => false,
      ), array(
          'required'      => "La imagen principal es requerida",
          'min_width'     => "El ancho de la imagen es muy corto (mínimo es %min_width%px, tiene %width%px ).",
          'min_height'    => "La altura mínima de la imagen debe ser 415px."
    ));
    $this->validatorSchema['image']->setMessage('mime_types','Error mime types %mime_type%.');

    //Etiquetas
    $this->widgetSchema->setLabels(array(
        'title'         => 'Título <span class="required">*</span>',
        'sub_title'     => 'Subtítulo',
        'date'          => 'Data',
        'body'          => 'Corpo <span class="required">*</span>',
        'summary'       => 'Sumário',
        'author'        => 'Autor',
        'sticky'        => 'Destacado',
        'image_principal'        => 'Imagem Destaque',
        'image'         => 'Imagem Principal  e secundária',
        'home_title'    => 'Título da Home',
        'category'      => 'Categoria',
    ));
    $appYml = sfConfig::get('app_upload_images_news');
    
    //Help Messages
    $this->widgetSchema->setHelps(array(
        'image'     => 'A imagem deve ser JPEG, JPG, PNG ou GIF<br />
                        A imagem deve ter um tamanho Maximo de '.(sfConfig::get('app_image_size_text')).'<br />
                        A imagem deve ter um tamanho mínimo de '.$appYml['size_1']['image_width_1'].' x '.$appYml['size_1']['image_height_1'].' pixels',
        'image_principal'     => 'A imagem deve ser JPEG, JPG, PNG ou GIF<br />
                        A imagem deve ter um tamanho Maximo de '.(sfConfig::get('app_image_size_text')).'<br />
                        A imagem deve ter um tamanho mínimo de 600 px de largura',

    ));
  }

  protected function doSave($con = null)
  {
      $module = 'news';
      $appYml = sfConfig::get('app_upload_images_news');
      // Si hay un nuevo archivo por subir y ya mi registro tiene un archivo asociado entonces,
      if ($this->getObject()->getImage() && $this->getValue('image'))
      {
          // recorro y elimino
          for($i=1;$i<=$appYml['copies'];$i++)
          {
              // Elimino las fotos de la carpeta
              if(is_file(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getImage()))
              {
                unlink(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getImage());
              }
          }
      }
      
      return parent::doSave($con);
  }
}
