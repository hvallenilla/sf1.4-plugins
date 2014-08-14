<?php

/**
 * SfLanguage form base class.
 *
 * @method SfLanguage getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfLanguageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_language'  => new sfWidgetFormInputHidden(),
      'language'     => new sfWidgetFormInputText(),
      'country'      => new sfWidgetFormInputText(),
      'lang_country' => new sfWidgetFormInputText(),
      'principal'    => new sfWidgetFormInputText(),
      'status'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_language'  => new sfValidatorPropelChoice(array('model' => 'SfLanguage', 'column' => 'id_language', 'required' => false)),
      'language'     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'country'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'lang_country' => new sfValidatorString(array('max_length' => 10)),
      'principal'    => new sfValidatorString(array('required' => false)),
      'status'       => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SfLanguage', 'column' => array('language')))
    );

    $this->widgetSchema->setNameFormat('sf_language[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfLanguage';
  }


}
