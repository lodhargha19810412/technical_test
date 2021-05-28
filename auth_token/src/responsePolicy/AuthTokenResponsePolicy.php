<?php

namespace Drupal\auth_token\responsePolicy;

use Drupal\Core\PageCache\ResponsePolicyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cache policy for the Auth token.
 *
 * This policy deny fetching from caching having auth token .
 */
class AuthTokenResponsePolicy implements ResponsePolicyInterface {

  /**
   * {@inheritdoc}
   */
  public function check(Response $response, Request $request) {
    // Deny to store in caching if authtoken exist in query string.
    $authToken = $request->query->get('authtoken');
    if (!empty($authToken)) {
      return static::DENY;
    }
  }

}
