<?php
namespace Drupal\games_api\Model;


class GamesModel
{

  public function getGames($langcode)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid and nfet.langcode = nfd.langcode');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('taxonomy_term__field_sub_classification', 'ttfsc', 'ttfsc.entity_id = ttfgc.entity_id and ttfsc.langcode = ttfgc.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfb', 'ttfb.tid = ttfsc.field_sub_classification_target_id and ttfb.langcode = ttfsc.langcode');
    $query->addField('ttfb', 'name', 'category');
    $query->leftJoin('node__field_content_main_image', 'nfcm', 'nfcm.entity_id = nfet.entity_id and nfcm.langcode = nfd.langcode');
    $query->fields('nfcm', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('node__field_is_all', 'nfia', 'nfia.entity_id = nfcm.entity_id and nfia.langcode = nfcm.langcode');
    $query->addField('nfia', 'field_is_all_value', 'all_category');
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfia.entity_id and nff.langcode = nfia.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfcm.field_content_main_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'egames');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfd.nid', 'DESC');

    $result = $query->execute()->fetchAll();

    return $result;
  }

  public function getGamesByPlatformCategory($langcode, $category, $platform)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('taxonomy_term__field_sub_classification', 'ttfsc', 'ttfsc.entity_id = ttfgc.entity_id and ttfsc.langcode = ttfgc.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfb', 'ttfb.tid = ttfsc.field_sub_classification_target_id and ttfb.langcode = ttfsc.langcode');
    $query->addField('ttfb', 'name', 'category');
    $query->leftJoin('node__field_content_main_image', 'nfcm', 'nfcm.entity_id = nfet.entity_id and nfcm.langcode = nfd.langcode');
    $query->fields('nfcm', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('node__field_is_all', 'nfia', 'nfia.entity_id = nfcm.entity_id and nfia.langcode = nfcm.langcode');
    $query->addField('nfia', 'field_is_all_value', 'all_category');
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfia.entity_id and nff.langcode = nfia.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfcm.field_content_main_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'egames');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('ttfd.name', $platform, '=');
    $query->condition('ttfb.name', $category, '=');
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfd.nid', 'DESC');

    $result = $query->execute()->fetchAll();

    return $result;
  }

  public function getGamesByPlatform($langcode, $platform)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('taxonomy_term__field_sub_classification', 'ttfsc', 'ttfsc.entity_id = ttfgc.entity_id and ttfsc.langcode = ttfgc.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfb', 'ttfb.tid = ttfsc.field_sub_classification_target_id and ttfb.langcode = ttfsc.langcode');
    $query->addField('ttfb', 'name', 'category');
    $query->leftJoin('node__field_content_main_image', 'nfcm', 'nfcm.entity_id = nfet.entity_id and nfcm.langcode = nfd.langcode');
    $query->fields('nfcm', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('node__field_is_all', 'nfia', 'nfia.entity_id = nfcm.entity_id and nfia.langcode = nfcm.langcode');
    $query->addField('nfia', 'field_is_all_value', 'all_category');
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfia.entity_id and nff.langcode = nfia.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfcm.field_content_main_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'egames');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('ttfd.name', $platform, '=');
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfd.nid', 'DESC');

    $result = $query->execute()->fetchAll();

    return $result;
  }

  public function getGamesByCategory($langcode, $category)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('taxonomy_term__field_sub_classification', 'ttfsc', 'ttfsc.entity_id = ttfgc.entity_id and ttfsc.langcode = ttfgc.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfb', 'ttfb.tid = ttfsc.field_sub_classification_target_id and ttfb.langcode = ttfsc.langcode');
    $query->addField('ttfb', 'name', 'category');
    $query->leftJoin('node__field_content_main_image', 'nfcm', 'nfcm.entity_id = nfet.entity_id and nfcm.langcode = nfd.langcode');
    $query->fields('nfcm', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('node__field_is_all', 'nfia', 'nfia.entity_id = nfcm.entity_id and nfia.langcode = nfcm.langcode');
    $query->addField('nfia', 'field_is_all_value', 'all_category');
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfia.entity_id and nff.langcode = nfia.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfcm.field_content_main_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'egames');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('ttfb.name', $category, '=');
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfd.nid', 'DESC');

    $result = $query->execute()->fetchAll();

    return $result;
  }

  public function gameTaxonomyTerm($tid, $langcode)
  {
    $query = \Drupal::database()->select('taxonomy_term_field_data', 'ttfd');
    $query->fields('ttfd', ['tid', 'vid', 'name']);
    $query->condition('ttfd.vid', 'egames_classification ', '=');
    $query->condition('ttfd.langcode', 'en', '=');
    $result = $query->execute()->fetchAll();

    return $result;
  }

}