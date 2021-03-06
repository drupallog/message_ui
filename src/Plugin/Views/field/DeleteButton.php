<?php

/**
 * @file
 * Definition of Drupal\message_ui\Plugin\views\field\DeleteButton.
 */

namespace Drupal\message_ui\Plugin\views\field;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\message_ui\MessageUiAccessControlHandler;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\message\Entity\Message;

/**
 * Field handler to present a Delete button for a message instance.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("delete_button")
 */
class DeleteButton extends FieldPluginBase {

  /**
   * Stores the result of node_view_multiple for all rows to reuse it later.
   *
   * @var array
   */
  protected $build;

  /**
   * {@inheritdoc}
   */
  public function query() {}

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    $message = Message::load($values->_entity->id());

    $access_handler = new MessageUiAccessControlHandler($message->getEntityType());
    if ($access_handler->access($message, 'delete', \Drupal::currentUser())) {
      $url = Url::fromRoute('entity.message.delete_form', $message);
      return Link::fromTextAndUrl(t('Delete'), $url);
    }
  }

}
