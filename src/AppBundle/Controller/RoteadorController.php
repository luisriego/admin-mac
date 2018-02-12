<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Roteador;
use AppBundle\Form\RoteadorType;

/**
 * Servidor controller.
 *
 * @Route("/admin/roteador")
 */
class RoteadorController extends Controller
{
    /**
     * Lists all Internet entities.
     *
     * @Route("/", name="admin_roteador_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
//        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
        $campos = ['id', 'nome', 'valor'];
        $titulo = 'Tipo de Roteador';

        $dados = $em->getRepository('AppBundle:Roteador')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Dados Utilizados',
                'url' => 'homepage',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Roteador',
                'url' => 'admin_roteador_index',
                'is_root' => true
            ],
        ];


        $roteador = new Roteador();
        $form = $this->createForm('AppBundle\Form\RoteadorType', $roteador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($roteador);
            $em->flush();

            return $this->redirectToRoute('admin_servidor_index', array('id' => $roteador->getId()));
        }

        return $this->render(
            'auxiliar/index.generico.html.twig',
            array(
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