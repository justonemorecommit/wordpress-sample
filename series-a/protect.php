<?php
# https://gist.github.com/4692807
namespace Protect;

# Will protect a page with a simple password.
function with($form, $password, $scope=null) {

  # add trailing slash
  if (!has_trailing_slash()) {
    header('Location: '.current_url(true));
    exit;
  }

  # check the POST for access
  if(array_key_exists('password', $_POST) && $_POST['password'] == $password) {
    return;
  } else {
    http_response_code(403);
    require $form;
    exit;
  }
}

function has_trailing_slash () {
  $parts = explode('?', $_SERVER['REQUEST_URI']);
  return ends_with($parts[0], '/');
}

function current_url($trailing_slash = true) {
  $protocol = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on'
    ? 'https'
    : 'http';
  $port = ':'.$_SERVER['SERVER_PORT'];
  if($protocol == 'http' && $port == ':80') $port = '';
  if($protocol == 'https' && $port == ':443') $port = '';
  $path = $_SERVER['REQUEST_URI'];
  if ($trailing_slash) {
    $parts = explode('?', $path);
    $path = str_replace('//', '/', $parts[0].'/');
    if ($parts[1]) $path .= '?'.$parts[1];
  }
  return "$protocol://$_SERVER[SERVER_NAME]$port$path";
}

function ends_with ($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) return true;
    return (substr($haystack, -$length) === $needle);
}
