<?php

namespace Drupal\site_info_form_extension\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;

class GetResponse extends ControllerBase {
  /**
   * Return node data in json format if the nid is set of content type page and site api key is set
   */
  function getData($siteapikey = NULL, $nid = NULL) {
    $site_config = \Drupal::service('config.factory')->getEditable('system.site');
    $data = null;
    if(NULL != $nid && isset($site_config)) {
      $stored_site_api_key = $site_config->get('siteapikey');
      $node = Node::load($nid);
      if(NULL != $node && $node->getType() == 'page' && $stored_site_api_key == $siteapikey) {
        // serializing the node object which will help to send data in json format
        if(\Drupal::hasService('serializer')) {
          $serializer = \Drupal::service('serializer');
          $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
          $response = new Response($data);
          $response->headers->set('Content-Type', 'application/json');
          return $response;
        }
        else {
          $response = new Response(json_encode(array('status' => 'error', 'message' => 'Serialization module is need to be enabled.')));
          $response->headers->set('Content-Type', 'application/json');
          return $response;
        }
      }
      else {
        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
      }
    }
    else {
      throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
    }
  }
}
