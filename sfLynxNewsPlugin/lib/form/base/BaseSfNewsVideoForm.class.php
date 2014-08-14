<?php

/**
 * SfNewsVideo form base class.
 *
 * @method SfNewsVideo getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfNewsVideoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_news_video' => new sfWidgetFormInputHidden(),
      'id_news'       => new sfWidgetFormInputText(),
      'id_video'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_news_video' => new sfValidatorPropelChoice(array('model' => 'SfNewsVideo', 'column' => 'id_news_video', 'required' => false)),
      'id_news'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_video'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('sf_news_video[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfNewsVideo';
  }


}
