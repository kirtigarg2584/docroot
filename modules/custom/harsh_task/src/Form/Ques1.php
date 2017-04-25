<?php

namespace Drupal\harsh_task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Session\AccountInterface;

/**
 * Implements an example form.
 */
class Ques1 extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected $configFactory;
  //protected $config;
  protected $currentUser;
    
  public function __construct(ConfigFactoryInterface $config_factory ,AccountProxy $current_user) {
    $this->configFactory = $config_factory;
    $this->currentUser = $current_user;
  }
    
  public static function create(ContainerInterface $container) {
    //kint($container); die;
    
  return new static(
      $container->get('config.factory'),
      $container->get('current_user')
  );
  }
  
  public function getFormId() {
    return 'ques1';
  }
  
  protected function getEditableConfigNames() {
    return [
      'harsh_task.Harsh_TaskConfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->configFactory->get('harsh_task.Harsh_TaskConfig');
    
    //echo $config;
    //$this->currentUser->uid;
    //drupal_set_message($uid);
    //kint($this->config('system.site'));die;
    $form['current@user'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Current User'),
      '#default_value' => $this->currentUser->getUsername()   ? $this->currentUser->getUsername() : '',
      '#placeholder' => $this->t('Your username'),
    );
    
    $form['system@site'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('System.site Service'),
      '#default_value' => $this->config('system.site')->get('name')? $this->config('system.site')->get('name') : '',
      '#placeholder' => $this->t('system.site service'),
    );
    
    $form['user'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#default_value' => $config->get('user') ? $config->get('user') : '',
      '#placeholder' => $this->t('Your username'),
    );
    
    $form['vertical'] = array(
      '#type' => 'select',
      '#title' => $this->t('Choose your vertical'),
      '#options' => [
        '1' => $this->t('Drupal'),
        '2' => $this->t('JVM'),
        '3' => $this->t('MEAN'),
        '4' => $this->t('FEEN')
      ],
      '#default_value' => $config->get('vertical') ? $config->get('vertical') : '1',
    );
    
    $form['gender'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        0 => $this->t('Male'),
        1 => $this->t('Female')
      ],
      '#default_value' => $config->get('gender') ? $config->get('gender') : 0,
    );
    
    //$config = $this->configFactory->get('harsh_task.Harsh_TaskConfig');
    $form['desc'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#placeholder' => $this->t('A brief description about you'),
      '#default_value' => $config->get('desc') ? $config->get('desc') : '',
    );

    $form['agree'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('All the information provided by me is true to my knowledge'),
      '#default_value' => $config->get('agree') ? $config->get('agree') : 1,
    );
    
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  
  /**
   * {@inheritdoc}
   */
  //public function validateForm(array &$form, FormStateInterface $form_state) {
  //  if (strlen($form_state->getValue('phone_number')) < 3) {
  //    $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
  //  }
  //}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //$user = $form_state->getValue('user');
    $configEditable = $this->configFactory->getEditable('harsh_task.Harsh_TaskConfig');
    //\Drupal::state()->set('name',$form_state->getValue('user'));
    //kint($form_state->getValue('user'));die;  
    $configEditable->set('user',$form_state->getValue('user'));
    $configEditable->set('vertical',$form_state->getValue('vertical'));
    $configEditable->set('gender',$form_state->getValue('gender'));
    $configEditable->set('desc',$form_state->getValue('desc'));
    $configEditable->set('agree',$form_state->getValue('agree'));
    $configEditable->save();
    drupal_set_message($this->t('Form is sucessfully submitted'));
  }

}