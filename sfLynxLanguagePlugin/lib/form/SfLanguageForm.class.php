<?php

/**
 * SfLanguage form.
 *
 * @package    lynx4
 * @subpackage form
 * @author     Your name here
 */
class SfLanguageForm extends BaseSfLanguageForm
{
  public function configure()
  {
      $this->disableLocalCSRFProtection();
      $this->widgetSchema['language'] = new sfWidgetFormI18nChoiceLanguage();
      $this->widgetSchema['country'] = new sfWidgetFormI18nChoiceCountry();
      $this->widgetSchema['principal']  = new sfWidgetFormChoice(array('choices' => array('1' => 'Yes', '0' => 'No')));
      $this->widgetSchema['status']  = new sfWidgetFormChoice(array('choices' => array('1' => 'Yes', '0' => 'No')));

      //Excluidos
      unset($this['id_language'], $this['lang_country']);
      // Agrega un post validador personalizado
        $this->validatorSchema->setPostValidator(
                new sfValidatorCallback(array('callback' => array($this, 'checkLogicLanguage')))
        );
    }


    public function checkLogicLanguage($validator, $values) {
        $totalLanguages = SfLanguagePeer::totalLanguages();
        if($values['id_language'])
        {
            /* Solo existe un idioma y este se esta desactivando*/
            if($totalLanguages==1 && !$values['status'])
            {
                $error = new sfValidatorError($validator, sfConfig::get('mod_language_msn_error_status_desactivo'));
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));
            }        
            $language = SfLanguagePeer::isActualPrincipal($values['id_language']);
            /* EL lenguage seleccionado es principal*/
            if($language && !$values['principal']) /*Si es principal y se selecciono como no principal*/
            {
                $error = new sfValidatorError($validator, sfConfig::get('mod_language_msn_error_language_principal'));
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));
            }
            if($language && !$values['status'])/*Si es principal y se desactiva*/
            {
                $error = new sfValidatorError($validator, sfConfig::get('mod_language_msn_error_status_desactivo'));
                throw new sfValidatorErrorSchema($validator, array('Error' => $error));
            }
        }
        return $values;
    }
}
