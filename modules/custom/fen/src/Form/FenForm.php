<?php

namespace Drupal\fen\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FenForm extends ConfigFormBase{
    
    protected $config;
    
    public function __construct(ConfigFactoryInterface $config_factory) {
        //parent::__construct($config_factory);
        
        $this->config = $config_factory;
    }
    public static function create(ContainerInterface $container) {
        //parent::create($container);
        
        return new static ($container->get('config.factory'));
    }
    
    protected function getEditableConfigNames(){
        return ['fen.fenConfig'];
    }

    public function getFormId(){
        return 'fen_form';
    }
    
    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['#tree'] = TRUE;
      if (empty($form_state->get('num_names'))) {
         $form_state->set('num_names', 0);
      }
      $conf = $this->config->get('fen.fenConfig');
      $form['v_tabs'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'FORM',
      ]; 
      
      $form['details1'] = [
      '#type' => 'details',
      '#title' => 'Did you Know??',
      '#group' => 'v_tabs',
      ];
      
      $form['details1']['did_you_know']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Did you Know??'),
          '#placeholder' => $this->t('Did you Know??'),
          '#default_value' => $conf->get('did_you_know')?  : NULL,
      );
      
      $form['details1']['did_you_know_link']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Did you Know Link'),
          '#placeholder' => $this->t('Did you Know Link'),
          '#default_value' => $conf->get('did_you_know_link')?  : NULL,
      );
      
      $form['details2'] = [
      '#type' => 'details',
      '#title' => 'Who said??',
      '#group' => 'v_tabs',
      ];
      
      $form['details2']['who_said']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Who said??'),
          '#placeholder' => $this->t('Who said??'),
          '#default_value' => $conf->get('who_said')?  : NULL,
        );
      
      $form['details2']['who_said_link']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Who said Link'),
          '#placeholder' => $this->t('Who said Link'),
          '#default_value' => $conf->get('who_said_link')?  : NULL,
        );
      
      $form['details3'] = [
      '#type' => 'details',
      '#title' => 'Top Ten List',
      '#group' => 'v_tabs',
      ];
      
      $form['details3']['top_ten_list']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Top Ten List'),
          '#placeholder' => $this->t('Top Ten List'),
          '#default_value' => $conf->get('top_ten_list')?  : NULL,
        );
      
      $form['details3']['top_ten_list_link']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Top Ten List Link'),
          '#placeholder' => $this->t('Top Ten List Link'),
          '#default_value' => $conf->get('top_ten_list_link')?  : NULL,
        );
      
      $form['details4'] = [
      '#type' => 'details',
      '#title' => 'Link of the Day',
      '#group' => 'v_tabs',
      ];
      
      $form['details4']['link_of_the_day']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Link of the Day'),
          '#placeholder' => $this->t('Link of the Day'),
          '#default_value' => $conf->get('link_of_the_day')?  : NULL,
        );
      
      $form['details4']['link_of_the_day_link']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Link of the Day Link'),
          '#placeholder' => $this->t('Link of the Day Link'),
          '#default_value' => $conf->get('link_of_the_day_link')?  : NULL,
        );
      
      $form['details5'] = [
      '#type' => 'details',
      '#title' => 'Featured Articles',
      '#group' => 'v_tabs',
      ];
      
      $form['details5']['features']['featured_articles']= array(
          '#type' => 'textarea',
          '#title' => $this->t('Featured Articles'),
          '#placeholder' => $this->t('Featured Articles'),
          '#default_value' => $conf->get('featured_articles')?  : NULL,
        );
      
      $form['details5']['features']['featured_articles_link']= array(
          '#type' => 'textfield',
          '#title' => $this->t('Featured Articles Link'),
          '#placeholder' => $this->t('Featured Articles Link'),
          '#default_value' => $conf->get('featured_articles_link')?  : NULL,
        );
      
        
      $form['details5']['hgvjfy']= array(
         '#prefix' => '<div id="featured_articles_link_wrapper">',
          '#suffix' => '</div>',          
      );
       
      
      for ($i = 0; $i < $form_state->get('num_names') ; $i++) {
//       $form['details5']['features']['featured_articles_additional'][$i] = [
//        '#type' => 'textarea',
//        '#title' => $this->t('Featured Articles'),
//        '#placeholder' => $this->t('Featured Articles'),
//      ];
//      $form['details5']['features']['featured_articles_link_additional'][$i] = [
//        '#type' => 'textfield',
//        '#title' => $this->t('Featured Articles Link'),
//        '#placeholder' => $this->t('Featured Articles Link'),
//      ];
          
          
          $form['details5']['features']['afjjtf'][$i]=[
              
          ];
          
    }
      $form['actions'] = [
      '#type' => 'actions',
    ];
      
      $form['details5']['actions']['add_more_button']= array(
          '#type' => 'submit',
          '#value' => $this->t('Add more'),
          '#submit' => array('::addOne'),
          '#ajax' => [
            'callback' => '::addFieldCallback',
            'wrapper' => 'featured_articles_link_wrapper'
            ]
        );
      
      $count = $form_state->get('num_names');
     // if($count >0){
      $form['details5']['actions']['delete_button']= array(
          '#type' => 'submit',
          '#value' => $this->t('Delete one'),
          '#submit' => array('::reduceOne'),
          '#ajax' => [
            'callback' => '::addFieldCallback',
            'wrapper' => 'featured_articles_link_wrapper'
            ]
        );
      //}
      $form_state->setCached(FALSE);
      
      $form['actions']['submit_button'] = array (
        '#type' => 'submit',
        '#value' => 'Save',        
      );
      
      return $form;
       
    }
    
    
    public function addFieldCallback(array &$form, FormStateInterface $form_state) {
        return $form['details5']['features'];
    }
    
    public function addOne(array &$form, FormStateInterface $form_state) {
        $form_state->set('num_names', ($form_state->get('num_names')+1));
        $form_state->setRebuild();
    }
    
    public function reduceOne(array &$form, FormStateInterface $form_state) {
        if($form_state->get('num_names')>0){
        $form_state->set('num_names', ($form_state->get('num_names')-1));
        }
        $form_state->setRebuild();
    }
    
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $configEditable = $this->config->getEditable('fen.fenConfig');
        
        $configEditable->set('did_you_know',$form_state->getValue('did_you_know'));
        $configEditable->set('did_you_know_link',$form_state->getValue('did_you_know_link'));
        $configEditable->set('who_said',$form_state->getValue('who_said'));
        $configEditable->set('who_said_link',$form_state->getValue('who_said_link'));
        $configEditable->set('top_ten_list',$form_state->getValue('top_ten_list'));
        $configEditable->set('top_ten_list_link',$form_state->getValue('top_ten_list_link'));
        $configEditable->set('link_of_the_day',$form_state->getValue('link_of_the_day'));
        $configEditable->set('link_of_the_day_link',$form_state->getValue('link_of_the_day_link'));
        $configEditable->set('featured_articles',$form_state->getValue('featured_articles'));
        $configEditable->set('featured_articles_link',$form_state->getValue('featured_articles_link'));
        $configEditable->save();
    }
}

