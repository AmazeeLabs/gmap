<?php
/**
 * Created by PhpStorm.
 * User: podarokua
 * Date: 29.11.13
 * Time: 19:33
 */

namespace Drupal\gmap;


class GmapBehaviours {

  static private $behaviours;

  static private $gmapBehaviours;

  private function __construct() {
  }

  /**
   * do not clone
   */
  protected function __clone() {
  }

  /**
   * @return GmapBehaviours SingleTon instance
   */
  static public function getInstance() {
    if (is_null(self::$gmapBehaviours)) {
      self::$gmapBehaviours = new self();
    }
    return self::$gmapBehaviours;
  }

  public function getBehaviours($op, $map) {
      self::$behaviours = array();
      foreach (module_implements('gmap') as $module) {
        $function = $module . '_gmap';
        $result = $function($op, $map);
        if (isset($result) && is_array($result)) {
          self::$behaviours = array_merge_recursive(self::$behaviours, $result);
        }
        elseif (isset($result)) {
          self::$behaviours[] = $result;
        }
      }
    return self::$behaviours;
  }
} 