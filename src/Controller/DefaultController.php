<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/admin-page")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function adminPage()
    {
		return new Response('OK');
    }
}
