<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\UserListType;

/**
 * Servidor controller.
 *
 * @Route("/admin/usuario")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_user_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
//        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
        $campos = ['id', 'nome', 'sobrenome', 'username', 'email', 'enabled', 'roles'];
        $titulo = 'Usuário';

        $dados = $em->getRepository('AppBundle:User')->findAll();

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Dados Utilizados',
                'url' => 'homepage',
                'is_root' => true
            ],
            'status' => [
                'name' => 'Usuário',
                'url' => 'admin_user_index',
                'is_root' => true
            ],
        ];

//        $statuses = $em->getRepository('AppBundle:Status')->findAll();

        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserNewType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_index', array('id' => $user->getId()));
        }

        return $this->render(
            'pessoa/index.generico.html.twig',
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