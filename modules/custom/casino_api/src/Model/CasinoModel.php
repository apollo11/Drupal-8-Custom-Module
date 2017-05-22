<?php
namespace Drupal\casino_api\Model;

class CasinoModel {

  public function getCasino($langcode)
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
    $query->leftJoin('node__field_content_main_image', 'nfcm', 'nfcm.entity_id = nfet.entity_id and nfcm.langcode = nfd.langcode');
    $query->fields('nfcm', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfcm.field_content_main_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->leftJoin('node__field_casino_carousel_image', 'nfcci', 'nfcci.entity_id = nfcm.entity_id and nfcci.langcode = nfcm.langcode');
    $query->fields('nfcci', [
      'field_casino_carousel_image_target_id'
      , 'field_casino_carousel_image_alt'
      , 'field_casino_carousel_image_title'
      , 'field_casino_carousel_image_width '
      , 'field_casino_carousel_image_height'
    ]);
    $query->leftJoin('file_managed', 'fm_2', 'fm_2.fid = nfcci.field_casino_carousel_image_target_id');
    $query->fields('fm_2', ['uri', 'filename', 'fid', 'langcode']);
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfcm.entity_id and nff.langcode = nfd.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('node__field_powered_by', 'nfpb', 'nfpb.entity_id =  nfd.nid and nfpb.langcode = nfd.langcode');
    $query->leftJoin('taxonomy_term__field_content_main_image', 'tcmmi', 'tcmmi.entity_id = nfpb.field_powered_by_target_id and tcmmi.langcode = nfpb.langcode');
    $query->fields('tcmmi', [
      'field_content_main_image_target_id'
      , 'field_content_main_image_alt'
      , 'field_content_main_image_title'
      , 'field_content_main_image_width '
      , 'field_content_main_image_height'
    ]);
    $query->leftJoin('file_managed', 'fm_1', 'fm_1.fid = tcmmi.field_content_main_image_target_id ');
    $query->fields('fm_1', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('nfd.type', 'casinos');
    $query->condition('nfd.status', 1 , '=');
    $query->distinct('nfd.nid');
    $result = $query->execute();

    return $result;

  }
}