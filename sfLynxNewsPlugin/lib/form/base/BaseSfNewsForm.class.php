<?php

/**
 * SfNews form base class.
 *
 * @method SfNews getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfNewsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_news'         => new sfWidgetFormInputHidden(),
      'id_profile'      => new sfWidgetFormInputText(),
      'title'           => new sfWidgetFormInputText(),
      'sub_title'       => new sfWidgetFormInputText(),
      'body'            => new sfWidgetFormTextarea(),
      'date'            => new sfWidgetFormDate(),
      'summary'         => new sfWidgetFormTextarea(),
      'author'          => new sfWidgetFormInputText(),
      'image_principal' => new sfWidgetFormInputText(),
      'image'           => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'home'            => new sfWidgetFormInputText(),
      'permalink'       => new sfWidgetFormTextarea(),
      'home_title'      => new sfWidgetFormInputText(),
      'category'        => new sfWidgetFormInputText(),
      'sticky'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_news'         => new sfValidatorPropelChoice(array('model' => 'SfNews', 'column' => 'id_news', 'required' => false)),
      'id_profile'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'title'           => new sfValidatorString(array('max_length' => 200)),
      'sub_title'       => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'body'            => new sfValidatorString(),
      'date'            => new sfValidatorDate(array('required' => false)),
      'summary'         => new sfValidatorString(),
      'author'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'image_principal' => new sfValidatorString(array('max_length' => 50)),
      'image'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'status'          => new sfValidatorString(),
      'home'            => new sfValidatorString(),
      'permalink'       => new sfValidatorString(array('required' => false)),
      'home_title'      => new sfValidatorString(array('max_length' => 58, 'required' => false)),
      'category'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'sticky'          => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('sf_news[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfNews';
  }


}
