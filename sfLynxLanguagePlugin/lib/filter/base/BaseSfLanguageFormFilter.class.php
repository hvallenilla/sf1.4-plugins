<?php

/**
 * SfLanguage filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfLanguageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'language'    => new sfWidgetFormFilterInput(),
      'country'     => new sfWidgetFormFilterInput(),
      'principal'   => new sfWidgetFormFilterInput(),
      'status'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'language'    => new sfValidatorPass(array('required' => false)),
      'country'     => new sfValidatorPass(array('required' => false)),
      'principal'   => new sfValidatorPass(array('required' => false)),
      'status'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_language_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfLanguage';
  }

  public function getFields()
  {
    return array(
      'id_language' => 'Number',
      'language'    => 'Text',
      'country'     => 'Text',
      'principal'   => 'Text',
      'status'      => 'Text',
    );
  }
}
