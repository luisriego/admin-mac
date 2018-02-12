<?php

namespace AppBundle\Controller;

use AppBundle\Services\Utiles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="public")
     */
    public function publicAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('public/index.html.twig', []);
    }

    /**
     * @Route("/admin", name="homepage")
     */
    public function indexAction(Request $request, Utiles $utiles)
    {
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        // Primero guradamos en data los valores obtenidos de la api weather con el servicio Utiles
        $weather = $utiles->weather();


        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
        ];

        // replace this example code with whatever you need
        return $this->render('dashboard/index.html.twig', [
            'usuario' => $usuario,
            'weather' => $weather,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }



//    /**
//     * @Route("/login", name="login")
//     */
//    public function loginAction(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('@FOSUser/layout.html.twig', []);
//    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('auth/register.html.twig', []);
    }

    /**
     * @Route("/termos-e-condicoes", name="terms")
     */
    public function termsAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('auth/terms.html.twig', []);
    }
}
