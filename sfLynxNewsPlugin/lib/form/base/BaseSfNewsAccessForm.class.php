<?php

/**
 * SfNewsAccess form base class.
 *
 * @method SfNewsAccess getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfNewsAccessForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_access' => new sfWidgetFormInputHidden(),
      'id_nucleo' => new sfWidgetFormPropelChoice(array('model' => 'LxProfile', 'add_empty' => false)),
      'id_news'   => new sfWidgetFormPropelChoice(array('model' => 'SfNews', 'add_empty' => false)),
      'categoria' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_access' => new sfValidatorPropelChoice(array('model' => 'SfNewsAccess', 'column' => 'id_access', 'required' => false)),
      'id_nucleo' => new sfValidatorPropelChoice(array('model' => 'LxProfile', 'column' => 'id_profile')),
      'id_news'   => new sfValidatorPropelChoice(array('model' => 'SfNews', 'column' => 'id_news')),
      'categoria' => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('sf_news_access[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfNewsAccess';
  }


}
