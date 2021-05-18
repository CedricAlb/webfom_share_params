<?php

namespace Drupal\webform_share_params\Controller;

use Drupal\webform_share\Controller\WebformShareController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Provides route responses for webform share script 
 * with query parameters from the embeding page.
 */
class WebformShareParamsController extends WebformShareController {

  /**
   * {@inheritdoc}
   */
  public function script(Request $request, $library = NULL, $version = NULL) {
    $webform = $this->requestHandler->getCurrentWebform();
    $source_entity = $this->requestHandler->getCurrentSourceEntity(['webform']);

    $build = [
      '#type' => 'webform_share_iframe',
      '#webform' => $webform,
      '#source_entity' => $source_entity,
      '#javascript' => TRUE,
      '#query' => $request->query->all(),
    ];
    $iframe = $this->renderer->renderPlain($build);

    $iframe_script = json_encode($iframe);
    $iframe_script = str_replace('src=\\"\/\/', 'src=\\"' . $request->getScheme() . ':\/\/', $iframe_script);
    $content = '
      var iframe_script = ' . $iframe_script . ';
      var found = iframe_script.match(/src="(.*?)"/i);
      if (found) {
        var excerpt = found[1];
        var iframe_script_with_params = iframe_script.replace(excerpt, excerpt + window.location.search);
        document.write(iframe_script_with_params);
      } else {
        document.write(iframe_script);
      }
    ';
    $response = new Response($content, 200, ['Content-Type' => 'text/javascript']);

    return $response;
  }
}