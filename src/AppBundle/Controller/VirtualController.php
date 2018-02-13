<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VServe;
use AppBundle\Form\VServeType;

/**
 * Servidor controller.
 *
 * @Route("/admin/servidor-virtual")
 */
class VirtualController extends Controller
{
    /**
     * Lists all Virtual Servers entities.
     *
     * @Route("/", name="admin_vserve_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
//        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
        $campos = ['id', 'nome', 'preco'];
        $titulo = 'servidor virtual';

        $dados = $em->getRepository('AppBundle:VServe')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Dados Utilizados',
                'url' => 'homepage',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Servidor Virtual',
                'url' => 'admin_vserve_index',
                'is_root' => true
            ],
        ];


        $servidor = new VServe();
        $form = $this->createForm('AppBundle\Form\VServeType', $servidor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($servidor);
            $em->flush();

//            return $this->redirectToRoute('admin_vserve_index');
        }

        return $this->render('backend/dados/index.generico.html.twig', array(
                'titulo' => $titulo,
//            'ultimosChamados' => $ultimosChamados,
                'breadcrumbs' => $breadcrumbs,
                'dados' => $dados,
                'campos' => $campos,
                'form' => $form->createView(),
            )
        );
    }
}