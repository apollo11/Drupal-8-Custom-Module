<?php
/**
 * Created by PhpStorm.
 * User: apollomm
 * Date: 9/7/16
 * Time: 4:44 PM
 */

/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController
 */

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

  public function content () {
    return [
      '#type' => '#markup',
      '#markup' => $this->t('Hello World!'),
    ];
  }

  public function cats($name) {
    return [
      '#type' => '#markup',
      '#markup' => $this->t('My cats name is: @name', ['@name' => $name]),
    ];
  }

}