<?php

/*
|--------------------------------------------------------------------------
| Register custom macros
|--------------------------------------------------------------------------
|
| Register custom macros for blade view.
*/

/**
 * Macro untuk navigasi yang aktif sesuai URL di address bar
 * @return  string html
 */
\Html::macro('smartNav', function($url, $title) {
  $class = $url == request()->url() ? 'active' : '';
  return "<li class=\"$class\"><a href=\"$url\">$title</a></li>";
});
