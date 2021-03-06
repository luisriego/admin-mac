<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Defeito;
use AppBundle\Form\DefeitoType;

/**
 * Servidor controller.
 *
 * @Route("/admin/defeito")
 */
class DefeitoController extends Controller
{
    /**
     * Lists all Internet entities.
     *
     * @Route("/", name="admin_defeito_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
//        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
        $campos = ['id', 'nome', 'prioridade'];
        $titulo = 'Tipo de Defeito';

        $dados = $em->getRepository('AppBundle:Defeito')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Dados Utilizados',
                'url' => 'homepage',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Defeito',
                'url' => 'admin_defeito_index',
                'is_root' => true
            ],
        ];

//        $statuses = $em->getRepository('AppBundle:Status')->findAll();

        $defeito = new Defeito();
        $form = $this->createForm('AppBundle\Form\DefeitoType', $defeito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($defeito);
            $em->flush();

//            return $this->redirectToRoute('admin_defeito_index', array('id' => $defeito->getId()));
        }

        return $this->render('backend/dados/index.generico.html.twig',
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