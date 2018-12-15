<?php
/**
 * Created by PhpStorm.
 * User: ovidijus
 * Date: 18.12.8
 * Time: 16.07
 */

namespace App\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
    protected function renderLogin(array $data)
    {
        /**
         * If the user has already logged in (marked as is authenticated fully by symfony's security)
         * then redirect this user back (in my case, to the dashboard, which is the main entry for
         * my logged in users)
         */
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('index');
        }
        return $this->render('@FOSUser/Security/login.html.twig', $data);
    }
}
