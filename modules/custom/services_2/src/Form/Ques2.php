<?php

namespace Drupal\services_2\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Database\Query\SelectInterface;

class Ques2 extends ConfigFormBase{
    
    protected $config;
    protected $con;


    public function getFormId() {
        return 'ques2';
    }
    protected function getEditableConfigNames() {
        return ['services_2.servicesConfig'];
    }  
    
    public static function create(ContainerInterface $container) {
        //parent::create($container);
        //kint($container);die;
        return new static(
          $container->get('config.factory'),
          $container->get('database')
        );
    }
    
    public function __construct(ConfigFactoryInterface $config_factory, Connection $conn) {
        //parent::__construct($config_factory);
        $this->config = $config_factory;
        $this->con = $conn;
    }
   
    public function buildForm(array $form, FormStateInterface $form_state) {
        //parent::buildForm($form, $form_state);
        
        //kint($this->con);die;
        //kint($this->con->insert('services_2')->values([''=>'',]));die;
        $conf= $this->config('services_2.servicesConfig');
        $form['full_name']= array(
          '#type' => 'textfield',
          '#title' => $this->t('User Name'),
          '#default_value' => $conf->get('full_name') ? $conf->get('full_name') : '',
          '#placeholder' => $this->t('Your Full Name'),
        );
        
        $form['gender']= array(
          '#type' => 'radios',
          '#title' => $this->t('Gender'),
          '#default_value' => $conf->get('gender') ? $conf->get('gender') : 'Female',
          '#options'=> [
              'Female' => $this->t('Female'),
              'Male' => $this->t('Male')
          ]
        );
        
        $form['number']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Contact Number'),
          '#default_value' => $conf->get('number') ? $conf->get('number') : '',
          '#placeholder' => $this->t('Your contact number'),
        );
        
        $form['email_id']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Email Id'),
          '#default_value' => $conf->get('email_id') ? $conf->get('email_id') : '',
          '#placeholder' => $this->t('abc@xyz.pqr'),
        );
        
        $form['add']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Address'),
          '#default_value' => $conf->get('add') ? $conf->get('add') : '',
          '#placeholder' => $this->t('Your address'),
        );
        
        $form['city']= array(
          '#type' => 'textfield',
          '#title' => $this->t('City'),
          '#default_value' => $conf->get('city') ? $conf->get('city') : '',
          '#placeholder' => $this->t('Your city'),
        );
        
        $form['actions']['submit'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Save'),
          '#button_type' => 'primary',
        );
        
        return $form;
        
    }
    
    public function validateForm(array &$form, FormStateInterface $form_state) {
        //parent::validateForm($form, $form_state);
//        
//        $configEditable = $this->config->getEditable('services_2.servicesConfig');
//        $configEditable->set('full_name',$form_state->getValue('full_name'));
//        $configEditable->set('gender',$form_state->getValue('gender'));
//        $configEditable->set('add',$form_state->getValue('add'));
//        $configEditable->set('city',$form_state->getValue('city'));
//        $configEditable->set('email_id',$form_state->getValue('email_id'));
//        $configEditable->set('number',$form_state->getValue('number'));
//        $configEditable->save();
//        
//        $conf= $this->config('services_2.servicesConfig');
        //kint($conf->get('full_name'));die;
        if(!preg_match('/^[a-zA-Z ]+$/', $form_state->getValue('full_name'))){
           $form_state->setErrorByName('full_name',t('Your name should contain alphabets only'));
        }
        if(!preg_match_all('/^[0-9]{10}$/', $form_state->getValue('number'))){
           $form_state->setErrorByName('number',t('Contact number should contain 10 digits'));
        }
        if(!preg_match_all('/^[a-zA-Z0-9.-_]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,63}$/', $form_state->getValue('email_id'))){
           $form_state->setErrorByName('email_id',t('Invalid email id'));
        }
    }
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
        //parent::submitForm($form, $form_state);
//        $configEditable = $this->config->getEditable('services_2.servicesConfig');
//        $configEditable->set('full_name',$form_state->getValue('full_name'));
//        $configEditable->set('gender',$form_state->getValue('gender'));
//        $configEditable->set('add',$form_state->getValue('add'));
//        $configEditable->set('city',$form_state->getValue('city'));
//        $configEditable->set('email_id',$form_state->getValue('email_id'));
//        $configEditable->set('number',$form_state->getValue('number'));
//        $configEditable->save();
        //kint($form_state    );die;
       // kint($form_state->getValue('number'));die;
        $this->con->insert('services_2')->fields([
            'full_name'=> $form_state->getValue('full_name'), 
            'gender'=>  $form_state->getValue('gender'),
            'address'=> $form_state->getValue('add'),
            'city'=> $form_state->getValue('city'),
            'number'=> $form_state->getValue('number'),
            'email_id'=> $form_state->getValue('email_id')
            ])->execute();
//        kint($query);die;
        drupal_set_message($this->t('Changes are successfully saved'));
    }
}
