<?php

namespace AppBundle\Controller;

use AppBundle\Services\Utiles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 * @Route("/admin")
 */
class BackendController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function backendAction(Request $request, Utiles $utiles)
    {
        $em = $this->getDoctrine()->getManager();
        
        // Primero guradamos en data los valores obtenidos de la api weather con el servicio Utiles
        $weather = $utiles->weather();
        
        $todosChamados = $em->getRepository('AppBundle:Chamado')->findAll();
        $todosTecnicos = $em->getRepository('AppBundle:Tecnico')->findAll();
        $todosUsuarios = $em->getRepository('AppBundle:User')->findBy(array(), array('lastLogin' => 'DESC'));
        $todosClientes = $em->getRepository('AppBundle:Cliente')->findAll();
        $chamadosFinalizados = $em->getRepository('AppBundle:Chamado')->chamadosFinalAdmin();
        $chamadosAbertos = $em->getRepository('AppBundle:Chamado')->chamadosAbertos();
        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
        ];

        // replace this example code with whatever you need
        return $this->render('backend/dashboard/index.html.twig', [
            'titulo'                => 'Dashboard',
            'breadcrumbs'           => $breadcrumbs,
            'todosChamados'         => $todosChamados,
            'todosTecnicos'         => $todosTecnicos,
            'todosUsuarios'         => $todosUsuarios,
            'todosClientes'         => $todosClientes,
            'chamadosFinalizados'   => $chamadosFinalizados,
            'chamadosAbertos'       => $chamadosAbertos,
            'weather'               => $weather,
        ]);
    }
}
