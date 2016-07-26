<?php

/**
 * @file
 * Contains \Drupal\insert_view\Plugin\Filter\InsertView.
 */

namespace Drupal\insert_view\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\views\Views;

/**
 * Provides a filter for insert view.
 *
 * @Filter(
 *   id = "insert_view",
 *   module = "insert_view",
 *   title = @Translation("Insert View"),
 *   description = @Translation("Allows to embed views using the simple syntax: [view:name=display=args]"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class InsertView extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);
    if (!empty($text)) {
      if (preg_match_all("/\[view:([^=\]]+)=?([^=\]]+)?=?([^\]]*)?\]/i", $text, $match)) {
        $search = $replace = array();
        foreach ($match[0] as $key => $value) {
          $view_name = $match[1][$key];
          $display_id = ($match[2][$key] && !is_numeric($match[2][$key])) ? $match[2][$key] : 'default';
          $args = $match[3][$key];

          if (!empty($view_name)) {

            $view = Views::getView($view_name);
            if (!empty($view) && $view->access($display_id)) {
              $result->addCacheableDependency($view->storage);
              $current_path = \Drupal::service('path.current')->getPath();
              $url_args = explode('/', $current_path);
              foreach ($url_args as $id => $arg) {
                $args = str_replace("%$id", $arg, $args);
              }
              $args = preg_replace(',/?(%\d),', '', $args);
              $args = $args ? explode('/', $args) : array();

              $view_output = $view->preview($display_id, $args);
              $result->addCacheTags($view->getCacheTags());
              $search[] = $value;
              $replace[] = !empty($view_output) ? render($view_output) : '';

            }
          }
        }

        $result->setProcessedText(str_replace($search, $replace, $text));
      }
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    if ($long) {
      return '<br />' . t(
'<dl>
<dt>Insert view filter allows to embed views using tags. The tag syntax is relatively simple: [view:name=display=args]</dt>
<dt>For example [view:tracker=page=1] says, embed a view named "tracker", use the "page" display, and supply the argument "1".</dt>
<dt>The <em>display</em> and <em>args</em> parameters can be omitted. If the display is left empty, the view\'s default display is used.</dt>
<dt>Multiple arguments are separated with slash. The <em>args</em> format is the same as used in the URL (or view preview screen).</dt>
</dl>
Valid examples:
<dl>
<dt>[view:my_view]</dt>
<dt>[view:my_view=my_display]</dt>
<dt>[view:my_view=my_display=arg1/arg2/arg3]</dt>
<dt>[view:my_view==arg1/arg2/arg3]</dt>
</dl>') . '<br />';
    }
    else {
      return t('You may use [view:<em>name=display=args</em>] tags to display views.');
    }
  }
}

