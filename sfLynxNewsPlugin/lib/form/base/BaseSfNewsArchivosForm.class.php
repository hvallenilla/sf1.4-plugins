<?php

/**
 * SfNewsArchivos form base class.
 *
 * @method SfNewsArchivos getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfNewsArchivosForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_news_archivo' => new sfWidgetFormInputHidden(),
      'id_news'         => new sfWidgetFormInputText(),
      'id_archivo'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_news_archivo' => new sfValidatorPropelChoice(array('model' => 'SfNewsArchivos', 'column' => 'id_news_archivo', 'required' => false)),
      'id_news'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_archivo'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_news_archivos[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfNewsArchivos';
  }


}
