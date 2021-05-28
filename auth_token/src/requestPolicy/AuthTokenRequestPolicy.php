<?php

namespace Drupal\auth_token\requestPolicy;

use Drupal\Core\PageCache\RequestPolicyInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cache policy for the Auth token.
 *
 * This policy deny fetching from caching having auth token .
 */
class AuthTokenRequestPolicy implements RequestPolicyInterface {

  /**
   * {@inheritdoc}
   */
  public function check(Request $request) {
    // Deny to retrieve from caching if authtoken exist in query string.
    $authToken = $request->query->get('authtoken');
    if (!empty($authToken)) {
      return static::DENY;
    }
  }

}
