<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Cliente;
use AppBundle\Form\ClienteNewType;
//use AppBundle\Form\UserListType;

/**
 * Cliente controller.
 *
 * @Route("/admin/cliente")
 */
class ClienteController extends Controller
{
    /**
     * Lists all Cliente entities.
     *
     * @Route("/", name="admin_cliente_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $campos = ['nome', 'email', 'telefone', 'contato', 'ip', 'raiox'];
        $dados = $em->getRepository('AppBundle:Cliente')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Pessoas',
                'url' => 'dashboard',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Cliente',
                'url' => 'admin_cliente_index',
                'is_root' => true
            ],
        ];

//        // Formulário adaptado a entidade
//        $cliente = new Cliente();
//        $form = $this->createForm('AppBundle\Form\ClienteNewType', $cliente);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em->persist($cliente);
//            $em->flush();
//
////            return $this->redirectToRoute('admin_cliente_index', array('id' => $cliente->getId()));
//        }

        return $this->render('backend/dados/index.pessoa.html.twig', array(
                'titulo' => 'Clientes',
                'breadcrumbs' => $breadcrumbs,
                'dados' => $dados,
                'campos' => $campos,
//                'form' => $form->createView(),
            )
        );
    }
}