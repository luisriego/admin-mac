<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Internet;
//use AppBundle\Form\InternetType;

/**
 * Servidor controller.
 *
 * @Route("/admin/internet")
 */
class InternetController extends Controller
{
    /**
     * Lists all Internet entities.
     *
     * @Route("/", name="admin_internet_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
//        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
        $campos = ['id', 'nome', 'telefone', 'obs'];
        $titulo = 'Tipo de Internet';

        $dados = $em->getRepository('AppBundle:Internet')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Dados Utilizados',
                'url' => 'homepage',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Internet',
                'url' => 'admin_internet_index',
                'is_root' => true
            ],
        ];

//        $statuses = $em->getRepository('AppBundle:Status')->findAll();

        $internet = new Internet();
        $form = $this->createForm('AppBundle\Form\InternetType', $internet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($internet);
            $em->flush();
//
//            return $this->redirectToRoute('admin_servidor_index', array('id' => $internet->getId()));
        }

        return $this->render('auxiliar/index.generico.html.twig', array(
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