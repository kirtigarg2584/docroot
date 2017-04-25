<?php

namespace Drupal\site_import\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\migrate\Event\MigrateImportEvent;

/**
 * Source plugin for article content.
 *
 * @MigrateSource(
 *   id = "article_node"
 * )
 */
class ArticleNode extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('articles', 'a')
    ->fields('a');
    $query->addField('a', 'body', 'content');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {  
    $fields = [
      'id' => $this->t('Legacy ID'),
      'title' => $this->t('Legacy Title'),
      'body' => $this->t('Legacy Body'),
      'status' => $this->t('Legacy Status'),
    ];

    return $fields;
  }

  
  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'a',
      ],
    ];
  }

}
