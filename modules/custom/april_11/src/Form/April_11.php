<?php

namespace Drupal\april_11\Form;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
        
class April_11 extends FormBase{
    
    private $city = [
        0 => [
            'New Delhi' => 'New Delhi',
            'Noida' => 'Noida',
            'Haryana' => 'Haryana',
        ],
        1 =>[
            'London' => 'London',
            'Paris' => 'Paris',
            'Amsterdam' => 'Amsterdam',
        ],        
    ];
    
    protected $con;
    public function __construct(Connection $conn) {
       $this->con = $conn; 
    }    
    
    public static function create(ContainerInterface $container) {
        return new static (
          $container->get('database')
        );
    }
    
    public function buildForm(array $form, FormStateInterface $form_state){        
     //echo "dvhvjvcdk";die;
     
     //kint("djkfvbbfduhvskfuv");die;
     
     
      $form['information'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'FORM',
      ]; 
      
      $form['personal_details'] = [
      '#type' => 'details',
      '#title' => 'Personal Details',
      '#group' => 'information',
      ];
      
      $form['other'] = [
      '#type' => 'details',
      '#title' => 'Other Details',
      '#group' => 'information',
      ];
      
      $form['personal_details']['full_name']= array(
        '#type' => 'textfield',
        '#placeholder' => 'Your username',
        '#title' => $this->t('Username'),
        '#ajax' => [
            'callback' => '::validateUser',
            'event' => 'change',
            'method' => 'replace',
            'progress' => array(
                'type' => 'throbber',
                 'message' => t('Verifying UserName...'),
            ),
        ],
        '#suffix' => '<span class="user-valid-message"></span>'          
      );
           
      $form['personal_details']['gender'] = array(
          '#type' => 'radios',
          '#title' => $this->t('Vertical'),         
          '#id' => 'gender-wrapper',
          '#options' => [
              'Drupal' => 'Drupal',
              'JVM' => 'JVM',
              'MEAN' => 'MEAN',
              'FEEN' => 'FEEN',
           ],
          '#ajax' => [
          'callback' => '::validateVertical',
          ]
        ); 
        
        $form['personal_details']['number']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Contact Number'),
          '#placeholder' => $this->t('Your contact number'),
        );
        
        $form['personal_details']['email_id']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Email Id'),
          '#placeholder' => $this->t('abc@xyz.pqr'),
        );
        
        $form['personal_details']['add']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Address'),
          '#placeholder' => $this->t('Your address'),
        );
        
        $form['personal_details']['countary'] = array(
            '#type' => 'select',
            '#title' => 'Country',
            '#empty_option' => $this->t('-select'),
            '#options' => ['India','Europe'],
            '#ajax' => [
                'callback' => '::displayCities',
                'wrapper' => 'countary_wrapper',
                'progress' => array(
                'type' => 'throbber',
                'message' => 'Validating Countary',
             ),
            ],
        );
        
        $form['personal_details']['countary-wrapper']=[
            '#type' => 'container',
            '#attributes' => ['id' => 'countary_wrapper']        
        ];
        
        $form['other']['add_button']= array (
          '#type' => 'button',
          '#value' => 'Add Field',
        );
        
        $form['other']['password'] = array(
          '#type'  => 'password',
          '#title' => 'Create Password',
        );
        
        $form['other']['re_password'] = array(
          '#type'  => 'password',
          '#title' => 'Confirm Password',
          '#ajax' => [
              'callback' => '::validatePassword',
              'event' => 'change',
          ],
          '#suffix' => '<span class="pass-valid-message"></span>',
        );
        
        $form['agree']= array(
          '#type' => 'checkbox',
          '#title' => $this->t('I agree to all the terms and condition mentioned'),
          '#ajax' => [
              'callback' => '::validate_Agree',
              'wrapper' => 'actions_ajax',
               'event' => 'change'
          ],
        );
        
        $form['actions'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
            '#button_type' => 'primary',
            '#attributes' => ['disabled' => 'true','id' => 'actions_ajax'] 
        ];

      return $form;
        
    }
    
    public function validatePassword(array &$form, FormStateInterface $form_state) {
        echo $form_state->getValue('password');die;
        
        if($form_state->getValue('password') == $form_state->getValue('re_password')){
            $css = ['color' => 'green'];
            $error = $this->t('Passwords match');
        }
        else {
            $css = ['color' => 'red'];
          $error = $this->t('Passwords does not match');
        }
        
        $response = new AjaxResponse();
        $response->addCommand(new CssCommand('.pass-valid-message', $css));
        $response->addCommand(new HtmlCommand('.pass-valid-message', $error));
        return $response;
    }
    
    public function validateUser(array &$form, FormStateInterface $form_state) {
        
        if(!preg_match('/^[a-zA-Z0-9._@]+$/', $form_state->getValue('full_name'))){
          $error = 'User name can not contain any special character other than (.),(_),(@)';
        }
        else{
            $query = $this->con->select('services_2','kirti');
            $query->fields('kirti',['full_name']);
            $query->condition('full_name', $form_state->getValue('full_name') , '=');
            $result = $query->execute()->fetchAll();
            if(count($result)){
                    $error = 'UserName already exists';
            }
        }

       // $response = new AjaxResponse();
        if (!$error) {
          $css = ['color' => 'green'];
          $error = $this->t('Valid Username.');
        }
        else {
          $css = ['color' => 'red'];
        }
        $response->addCommand(new CssCommand('.user-valid-message', $css));
        $response->addCommand(new HtmlCommand('.user-valid-message', $error));
        return $response;
    }
    
    public function displayCities(array &$form, FormStateInterface $form_state) {
        
        $form['countary-wrapper']['city_ajax']= [
            '#type'=> 'select',
            '#title'=> 'City',
            '#empty_option' => $this->t('-select'),
            '#options' => $this->city[$form_state->getValue('countary')],
        ];
        
        return $form['countary-wrapper'];
    }
    
    public function validate_Agree(array &$form, FormStateInterface $form_state) {
        if($form_state->getValue('agree')){
           unset($form['actions']['#attributes']['disabled']); 
        }
        else{
            $form['actions']['#attributes']['disabled'] = 'false';
        }        
        return $form['actions'];
    }

    public function validateVertical(array &$form, FormStateInterface $form_state){
 
        $res = new AjaxResponse();
        $res->addCommand(new ReplaceCommand('#gender-wrapper',$form_state->getValue('gender')));
        return $res;
        }

    public function getFormId(){
        return 'april_11_form';
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        //   kint($form_state->getValue('op')->__toString());die;
        exit;
        $this->con->insert('services_2')->fields([
          'full_name'=> $form_state->getValue('full_name'), 
            'gender'=>  $form_state->getValue('gender')? :'Female',
            'address'=> $form_state->getValue('add'),
            'city'=> $form_state->getValue('city'),
            'number'=> $form_state->getValue('number'),
            'email_id'=> $form_state->getValue('email_id')  
        ])->execute();
    }
}