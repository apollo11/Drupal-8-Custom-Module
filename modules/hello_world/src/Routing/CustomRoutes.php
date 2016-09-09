<?php
/**
 * Created by PhpStorm.
 * User: apollomm
 * Date: 9/8/16
 * Time: 11:59 AM
 */
namespace Drupal\hello_world\Routing;

use Symfony\Component\Routing\Route;

class CustomRoutes
{

  public function routes()
  {
    $routes = [];

    $routes['hello_world.hellopage'] = new Route (
    //Path Definition
      'hellopage',
      //Route Defaults
      [
        '_controller' => '\Drupal\hello_world\Controller\HelloController::content',
        '_title' => 'This is sample custom route'
      ],
      //Route Requirements
      [
        '_permission' => 'access content'
      ]
    );

    return $routes;
  }
}
