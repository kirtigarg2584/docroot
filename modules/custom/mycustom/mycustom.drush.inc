<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Drupal\Core\Entity\Entity;
use Drupal\Core\Entity\EntityManager;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;

function mycustom_drush_command() {
 $items = array();
 
 $items['say-hello'] = [
   'description' => 'Echo the name you type with Say hello command',
   'arguments' => [
     'name' => 'The name for saying hello',
   ],
   'aliases' => ['say:hello'],
 ];
 $items['abc'] = [
   'description' => 'Echo the name you type with Say hello command',
   'arguments' => [
     'name' => 'The name for saying hello',
   ],
   'aliases' => ['say:abc'],
 ];
 $items['cus-select'] = [
   'description' => 'Echo the name you type with Say hello command',
   'arguments' => [
     'name' => 'The name for saying hello',
   ],
  // 'drupal dependencies' => ['custom_drush_command'],
   'aliases' => ['sel'],
 ];
 
  $items['email-address'] = [
   'description' => 'print email address of all drupal user accounts in terminal',
   'aliases' => ['emadd'],
 ];
  
  $items['article-node'] = [
    'description' => 'Create a node of article content type',
    'arguments' => [
      'title' => 'Title of content',
      'body' => 'Body of content',
      ],
    'aliases' => ['arnode'],
   ];
  
  
  
 return $items;
}

function drush_mycustom_say_hello($name) {
 drush_print('Hello ' . $name . ' !');
}

function drush_mycustom_abc() {
     $choice = drush_prompt('Do you want to continue..??' ,NULL,false);
     if($choice=='y'){
         drush_print('You agree to continue');
     }
     else
         drush_print('You do not agree to continue');
}

function drush_mycustom_cus_select() {
 
    $select = array(1 => 'hi' , 2 =>'hello',3=>'bye');
    $choice = drush_choice($select, 'Select any one : ');
    drush_print(t('You selected @choice' ,['@choice'=>$select[$choice]]));
}

function drush_mycustom_email_address() {
    
    $con= \Drupal::database();
    $data=$con->select('users_field_data','u')
          ->fields('u',['mail'])
            ->execute()->fetchAll();
    
    foreach ($data as $value) {
       print_r($value);
    }   
}

function drush_mycustom_article_node() {
    $title = drush_prompt('Enter title',NULL,false) ;
    $body = drush_prompt('Enter body',NULL,false) ;
    $node = Node::create(array(
     'title' => $title,
     'body' => $body ,
     'uid' => 1,
     'type' =>'article'  ,
     ));
    $node->save();
    
    drush_print('Node created');
}
 