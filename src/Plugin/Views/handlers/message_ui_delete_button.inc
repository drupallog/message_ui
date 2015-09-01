<?php

use Drupal\Core\Url;
use Drupal\message\Entity\Message;
use Drupal\message_ui\MessageAccessControlHandler;

/**
 * Delete button for a message instance.
 */
class message_ui_delete_button extends views_handler_field_entity {

  function render($values) {
    $message = Message::load($values->mid);

    $access_handler = new MessageAccessControlHandler('message');
    if ($access_handler->checkAccess($message, 'delete', \Drupal::currentUser())) {
      $url = Url::fromRoute('message_ui.delete_message', $message);
      return \Drupal::l(t('Delete'), $url);
    }
  }
}