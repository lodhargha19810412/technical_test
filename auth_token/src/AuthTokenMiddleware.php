<?php
/**
 * @file
 * Contains \Drupal\auth_token\AuthTokenMiddleware.
 */

namespace Drupal\auth_token;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Auth Token Middleware.
 *
 * @package Drupal\auth_token
 */
class AuthTokenMiddleware implements HttpKernelInterface {

  /**
   * The wrapped HTTP kernel.
   *
   * @var \Symfony\Component\HttpKernel\HttpKernelInterface
   */
  protected $app;

  /**
   * Constructs Auth Token Middleware.
   *
   * @param \Symfony\Component\HttpKernel\HttpKernelInterface $app
   *   The wrapper HTTP kernel.
   */
  public function __construct(HttpKernelInterface $app) {
    $this->app = $app;
  }

  /**
   * {@inheritdoc}
   */
  public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = TRUE) {

      
	  $uidInSession = \Drupal::service('session')->get('uid');
	  $authToken = $request->query->get('authtoken');
      // If user is not login then allow to load the user based on authtoken into the query string.
      if (empty($uidInSession) && !empty($authToken)) {
		  
		$userStorage = \Drupal::service('entity_type.manager')->getStorage('user');
		$users = $userStorage
                ->loadByProperties([
                    'field_auth_token' => $authToken,
                    'status' => 1,
                ]);
       
		if (!empty($users)) {
			$user = reset($users);
		    user_login_finalize($user);
		}
      }
    return $this->app->handle($request, $type, $catch);
  }

}
