<?php
/**
 * @file
 * Contains GmapMacroToolbox.php
 *
 * former gmap_parse_macro.inc
 */

namespace Drupal\gmap;


class GmapMacroToolbox {

  /**
   * @var static Singleton instance
   */
  static private $gmapInstance;

  /**
   * @var array
   */
  private $style;

  /**
   * @var string
   */
  private $coordString;

  /**
   * do not change
   */
  private function __construct() {
  }

  /**
   * do not clone
   */
  protected function __clone() {
  }

  /**
   * @return GmapMacroToolbox SingleTon instance
   */
  static public function getInstance() {
    if (is_null(self::$gmapInstance)) {
      self::$gmapInstance = new self();
    }
    return self::$gmapInstance;
  }

  /**
   * @param $style array
   * @return $this GmapMacroToolbox
   *
   * former _gmap_parse_style($style)
   */
  public function setStyle($style){
    $this->style = $style;
    return $this;
  }

  /**
   * @return array
   *
   * former _gmap_parse_style($style)
   */
  public function getParsedStyles(){
    if (strpos($this->style, '/') === FALSE) {
      // Style ref.
      return $this->style;
    }
    $styles = explode('/', $this->style);

    // @@@ Todo: Fix up old xmaps stuff. Possibly detect by looking for array length 7?

    // Strip off # signs, they get added by code.
    if (isset($styles[0]) && substr($styles[0], 0, 1) == '#') {
      $styles[0] = substr($styles[0], 1);
    }
    if (isset($styles[3]) && substr($styles[3], 0, 1) == '#') {
      $styles[3] = substr($styles[3], 1);
    }

    // Assume anything > 0 and < 1.1 was an old representation.
    if ($styles[2] > 0 && $styles[2] < 1.1) {
      $styles[2] = $styles[2] * 100;
    }
    if (isset($styles[4])) {
      if ($styles[4] > 0 && $styles[4] < 1.1) {
        $styles[4] = $styles[4] * 100;
      }
    }

    return $styles;
  }

  /**
   * @param $str string
   * @return $this GmapMacroToolbox
   *
   * former _gmap_str2coord($str)
   */
  public function setCoordString($str){
    $this->coordString = $str;
    return $this;
  }

  /**
   * Parse "x.xxxxx , y.yyyyyy (+ x.xxxxx, y.yyyyy ...)" into an array of points.
   * @return array
   *
   * former _gmap_str2coord($str)
   */
  public function getCoord(){
    // Explode along + axis
    $arr = explode('+', $this->coordString);
    // Explode along , axis
    $points = array();
    foreach ($arr as $pt) {
      list($lat, $lon) = explode(',', $pt);
      $points[] = array((float) trim($lat), (float) trim($lon));
    }
    return $points;
  }
}
