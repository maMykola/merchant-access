<?php
require_once  __DIR__.'/../vendor/autoload.php';

try {
  $loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
  $twig = new Twig_Environment($loader);
  $template = $twig->loadTemplate('registration.html.twig');
  echo $template->render($_POST);

} catch (Exception $e) {
  die ('ERROR: ' . $e->getMessage());
}
?>