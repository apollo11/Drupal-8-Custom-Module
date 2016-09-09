<?php
/**
 * Created by PhpStorm.
 * User: apollomm
 * Date: 9/8/16
 * Time: 3:06 PM
 */

namespace Drupal\hello_world\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  public function alterRoutes(RouteCollection $collection)
  {
    // Change path

    if($route = $collection->get('hello_world.content')) {
      $route->setPath('/fuckhello');
    }

  }
}