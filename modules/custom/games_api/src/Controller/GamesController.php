<?php

namespace Drupal\games_api\Controller;

use Drupal\games_api\Model\GamesModel as Games;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class GamesController extends ControllerBase {

  /**
   * @param $langcode
   * @return JsonResponse
   */
  public function index($langcode)
  {
    $data = new Games();
    $gameContent = $data->getGames($langcode);

    foreach ($gameContent as $gameValue) {
      $result [] = [
        'id' => $gameValue->nid,
        'type' => $gameValue->type,
        'title' => $gameValue->title,
        'thumb_image' => [
          'alt' => $gameValue->field_content_main_image_alt,
          'title' => $gameValue->field_content_main_image_title,
          'height' => $gameValue->field_content_main_image_height,
          'width' => $gameValue->field_content_main_image_width,
          'src' => file_create_url($gameValue->uri),
          'filename' => $gameValue->filename,
        ],
        'games_category' => $gameValue->category,
        'game_platform' => $gameValue->game_platform,
        'game_platform_code' => $gameValue->field_game_code_value,
        'game_code' => $gameValue->field_game_no_value,
        'is_all' => $gameValue->all_category,
        'is_single_wallet' => $gameValue->field_is_single_wallet_value,
        'is_home' => $gameValue->field_featured_value,
        'langcode' => $gameValue->langcode
      ];
    }

    return new JsonResponse($result);
  }

  /**
   * @param $langcode
   * @param $category
   * @param $platform
   * @return JsonResponse
   */
  public function getGamesFilterByPlatformCategory($langcode, $platform, $category)
  {
    $data = new Games();
    $gameContent = $data->getGamesByPlatformCategory($langcode, $category, $platform);

    foreach ($gameContent as $gameValue) {
      $result [] = [
        'id' => $gameValue->nid,
        'type' => $gameValue->type,
        'title' => $gameValue->title,
        'thumb_image' => [
          'alt' => $gameValue->field_content_main_image_alt,
          'title' => $gameValue->field_content_main_image_title,
          'height' => $gameValue->field_content_main_image_height,
          'width' => $gameValue->field_content_main_image_width,
          'src' => file_create_url($gameValue->uri),
          'filename' => $gameValue->filename,
        ],
        'games_category' => $gameValue->category,
        'game_platform' => $gameValue->game_platform,
        'game_platform_code' => $gameValue->field_game_code_value,
        'game_code' => $gameValue->field_game_no_value,
        'is_all' => $gameValue->all_category,
        'is_single_wallet' => $gameValue->field_is_single_wallet_value,
        'is_home' => $gameValue->field_featured_value,
        'langcode' => $gameValue->langcode
      ];
    }
    return new JsonResponse($result);
  }

  /**
   * @param $langcode
   * @param $platform
   * @return JsonResponse
   */
  public function getGamesFilterByPlatform($langcode, $platform)
  {
    $data = new Games();
    $gameContent = $data->getGamesByPlatform($langcode, $platform);

    foreach ($gameContent as $gameValue) {
      $result [] = [
        'id' => $gameValue->nid,
        'type' => $gameValue->type,
        'title' => $gameValue->title,
        'thumb_image' => [
          'alt' => $gameValue->field_content_main_image_alt,
          'title' => $gameValue->field_content_main_image_title,
          'height' => $gameValue->field_content_main_image_height,
          'width' => $gameValue->field_content_main_image_width,
          'src' => file_create_url($gameValue->uri),
          'filename' => $gameValue->filename,
        ],
        'games_category' => $gameValue->category,
        'game_platform' => $gameValue->game_platform,
        'game_platform_code' => $gameValue->field_game_code_value,
        'game_code' => $gameValue->field_game_no_value,
        'is_all' => $gameValue->all_category,
        'is_single_wallet' => $gameValue->field_is_single_wallet_value,
        'is_home' => $gameValue->field_featured_value,
        'langcode' => $gameValue->langcode
      ];
    }
    return new JsonResponse($result);
  }

  /**
   * @param $langcode
   * @param $platform
   * @return JsonResponse
   */
  public function getGamesFilterByCategory($langcode, $category)
  {
    $data = new Games();
    $gameContent = $data->getGamesByCategory($langcode, $category);

    foreach ($gameContent as $gameValue) {
      $result [] = [
        'id' => $gameValue->nid,
        'type' => $gameValue->type,
        'title' => $gameValue->title,
        'thumb_image' => [
          'alt' => $gameValue->field_content_main_image_alt,
          'title' => $gameValue->field_content_main_image_title,
          'height' => $gameValue->field_content_main_image_height,
          'width' => $gameValue->field_content_main_image_width,
          'src' =>file_create_url($gameValue->uri),
          'filename' => $gameValue->filename,
        ],
        'games_category' => $gameValue->category,
        'game_platform' => $gameValue->game_platform,
        'game_platform_code' => $gameValue->field_game_code_value,
        'game_code' => $gameValue->field_game_no_value,
        'is_all' => $gameValue->all_category,
        'is_single_wallet' => $gameValue->field_is_single_wallet_value,
        'is_home' => $gameValue->field_featured_value,
        'langcode' => $gameValue->langcode
      ];
    }
    return new JsonResponse($result);
  }

  public function getTerms()
  {
    $gameTerm = new Games();
    $term = $gameTerm->gameTaxonomyTerm();
    return new JsonResponse($term);
  }

}