<?php

/**
 * SfNewsAlbum form base class.
 *
 * @method SfNewsAlbum getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfNewsAlbumForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_news_album' => new sfWidgetFormInputHidden(),
      'id_news'       => new sfWidgetFormInputText(),
      'id_album'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_news_album' => new sfValidatorPropelChoice(array('model' => 'SfNewsAlbum', 'column' => 'id_news_album', 'required' => false)),
      'id_news'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_album'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_news_album[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfNewsAlbum';
  }


}
