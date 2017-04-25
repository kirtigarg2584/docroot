<?php

namespace Drupal\april_10\Form;

use  Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Ajax_Form extends ConfigFormBase{
    
    public function getFormId() {
        return 'ajax_form';
    }
    
    protected function getEditableConfigNames() {
        return['april_10.formConfig'];
    }
    public function buildForm(array $form, FormStateInterface $form_state) {
        //parent::buildForm($form, $form_state);
       // kint('dbjsdbjdh');die;
    $form['user_ajax'] = array(
    '#type' => 'textfield',
    '#title' => $this->t('Username'),
    '#placeholder' => $this->t('Your username'),
    '#ajax' => [
        'callback' => '::validateUser',
        'wrapper' => 'color-wrapper',
        'event' => 'change',
        'method' => 'replace',
    ]
    );
        
    $form['color_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'color-wrapper'],
    ];
    
    $form['number']= array(
        '#type' => 'textfield',
        '#title' => $this->t('Contact Number'),
        '#placeholder' => $this->t('Your contact number'),
        '#ajax' => [
          'callback' => '::validateNumber',
          'wrapper' => 'number-wrapper',
          'event'  => 'change',
          'method' => 'replace',  
       ]
    );
    
    $form['number_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'number-wrapper'],
    ];
    
    $form['vertical'] = array(
      '#type' => 'select',
      '#title' => $this->t('Choose your vertical'),
      '#options' => [
        '1' => $this->t('Drupal'),
        '2' => $this->t('JVM'),
        '3' => $this->t('MEAN'),
        '4' => $this->t('FEEN')
      ],
     // '#default_value' => $config->get('vertical') ? $config->get('vertical') : '1',
    );
    
    $form['gender'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        0 => $this->t('Male'),
        1 => $this->t('Female')
      ],
     // '#default_value' => $config->get('gender') ? $config->get('gender') : 0,
    );
    
    //$config = $this->configFactory->get('harsh_task.Harsh_TaskConfig');
    $form['desc'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#placeholder' => $this->t('A brief description about you'),
     // '#default_value' => $config->get('desc') ? $config->get('desc') : '',
    );

    
    $form['actions'] = [
      '#type' => 'actions',
    ];
    
    return $form;
    
    }
    
    public function validateUser(array $form, FormStateInterface $form_state){
        
      if(!preg_match('/^[a-zA-Z ]+$/', $form_state->getValue('user_ajax'))){
           $error = 'Your name should contain alphabets only';
            
            
      }
    
    $form['color_wrapper']['user-error'] = [
              '#type' => 'label',
              '#title' => $error,
          ];
   
     return $form['color_wrapper'];
    }
    
    public function validateNumber(array $form, FormStateInterface $form_state){
       
      if(!preg_match('/^[0-9]{10}$/', $form_state->getValue('number'))){
           $error = 'Contact number should contain 10 digits';
          
      }
      
       $form['number_wrapper']['number-error'] = [
            '#type' => 'label',
            '#title' => $error,
        ];
           return $form['number_wrapper'];  
    }
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
        //parent::submitForm($form, $form_state);
    }
}