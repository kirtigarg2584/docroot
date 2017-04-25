<?php

namespace \Drupal\fen\Form;
 use Drupal\Core\Form\ConfigFormBase;
 
class FenForm extends ConfigFormBase{
    
    
    protected function getEditableConfigNames() {
        return ['fen.fenConfig'];
    }

    public function getFormId() {
        return 'fen_form';
    }
    
    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state) {
        //parent::buildForm($form, $form_state);
    }

}

