<?php

namespace Drupal\services_2\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;


class Display extends ControllerBase{

    protected $con;
    
    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('database')
        );
    }
    
    public function __construct(Connection $conn) {
        $this->con = $conn;
    }
    
    public function content(){
      $name = "jhbvjdvhb";
      
      $query = $this->con->select('services_2','kirti');
      $query->fields('kirti',['full_name' , 'gender' , 'number' ,'address' , 'city' , 'email_id']);
      $result = $query->execute()->fetchAll();
      //kint($result);die;
      return array(
        '#theme' => 'hello',
        '#result' => $result
//          '#type' => 'markup',
//          '#markup' => $this->t('bkhdbf')
      );
    }
}

