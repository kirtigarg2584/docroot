<?php

/**
 * @file
 * Contains \Drupal\count_node\Plugin\Block\Countnode.
 */

namespace Drupal\count_node\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * Provides a 'Count_Node' block.
 *
 * @Block(
 *   id = "count_node",
 *   admin_label = @Translation("Count node"),
 *   category = @Translation("Count Nodes")
 * )
 */
class Countnode extends BlockBase implements ContainerFactoryPluginInterface {

    /**
     * @var EntityManagerInterface
     */
    private $type;

    /**
     * {@inheritdoc}
     */
    protected $content_types;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityManager $type) {
        // parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->content_types = $type;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static($configuration, $plugin_id, $plugin_definition, $container->get('entity.manager'), $container->get('entity.query'));
    }

    public function build() {
        $content = $this->content_types->getStorage('node_type')->loadMultiple();
        $result = [];
        foreach ($content as $contentType) {
            $query = \Drupal::entityQuery('node');
            $query->condition('status', 1);
            $query->condition('type', $contentType->id());
            $result[$contentType->id()] = count($query->execute());
        }

        return array(
            '#cache' => ['max-age' => 0],
            '#result' => $result,
            '#theme' => 'content_block',
        );
    }

}
