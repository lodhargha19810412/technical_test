<?php

namespace Drupal\auth_token\responsePolicy;

use Drupal\Core\PageCache\ResponsePolicyInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cache policy for the Auth token.
 *
 * This policy deny fetching from caching having auth token 
 */
class AuthTokenResponsePolicy implements ResponsePolicyInterface {

  /**
   * {@inheritdoc}
   */
  public function check(Response $response, Request $request) {
    // This method check if the authtoken having into the query string and if exists it returns deny for caching
	$authToken = $request->query->get('authtoken');
    if (!empty($authToken)) {
      return static::DENY;
    }
  }

}
