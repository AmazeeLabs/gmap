<?php
/**
 * @file
 * Contains GmapDefaults.php
 */

namespace Drupal\gmap;


class GmapDefaults {
  /**
   * @var array containing gmap defaults
   * former gmap_defaults()
   */
  private $defaults;
  /**
   * @var static Singleton instance
   */
  static private $gmapInstance;

  /**
   * do not change
   */
  private function __construct() {
    $this->defaults = array(
      'width' => '300px',
      'height' => '200px',
      'zoom' => 3,
      'maxzoom' => 14,
      'controltype' => 'Small',
      'pancontrol' => 1,
      'streetviewcontrol' => 0,
      'align' => 'None',
      'latlong' => '40,0',
      'maptype' => 'Map',
      'mtc' => 'standard',
      'baselayers' => array('Map', 'Satellite', 'Hybrid'),
      'styles' => array(
        'line_default' => array('0000ff', 5, 45, '', 0, 0),
        'poly_default' => array('000000', 3, 25, 'ff0000', 45),
        'highlight_color' => 'ff0000',
      ),
      'line_colors' => array('#00cc00', '#ff0000', '#0000ff'),
    );
    $this->defaults['behavior'] = array();
    // @todo refactor this for removal
    $m = array();
    // @todo convert to class GmapBehaviours or method addBehavior
    $behaviors = gmap_module_invoke('behaviors', $m);
    foreach ($behaviors as $k => $v) {
      $this->defaults['behavior'][$k] = $v['default'];
    }
    $this->defaults = array_merge($this->defaults, variable_get('gmap_default', array()));
  }

  /**
   * do not clone
   */
  protected function __clone() {
  }

  /**
   * @return GmapDefaults SingleTon instance
   */
  static public function getInstance() {
    if (is_null(self::$gmapInstance)) {
      self::$gmapInstance = new self();
    }
    return self::$gmapInstance;
  }

  public function getDefaults() {
    return $this->defaults;
  }


}