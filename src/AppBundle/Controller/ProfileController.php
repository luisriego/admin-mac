<?php

namespace AppBundle\Controller;

use Symfony\Component\Security\Http\Util\TargetPathTrait;
use AppBundle\Services\Utiles;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * @Route("/admin/perfil", name="perfil")
     */
    public function profileAction(Request $request, Utiles $utiles)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AppBundle:User')->findOneById($this->getUser());

        $weather = $utiles->weather();

        $form = $this->createForm('AppBundle\Form\ProfileType', $usuario->getProfile());
        $formDir = $this->createForm('AppBundle\Form\ProfileDirType', $usuario->getEndereco());
        $form->handleRequest($request);
        $formDir->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($usuario->getNome() == null && $form["nome"]->getData() != null) {
                $usuario->setNome($form["nome"]->getData());
            }
            if ($usuario->getSobrenome() == null && $form["sobrenome"]->getData() != null) {
                $usuario->setSobrenome($form["sobrenome"]->getData());
            }

            $em->persist($perfil);
            $em->flush();

//            return $this->redirectToRoute('admin_user_index', array('id' => $perfil->getId()));
        }

        if ($formDir->isSubmitted() && $formDir->isValid()) {

            $em->persist($endereco);
            $em->flush();

        }

        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
            'profile' => [
                'name' => 'Perfil de Usuario',
                'url'  => 'profile',
                'is_root' => true
            ],
        ];

        // replace this example code with whatever you need
        return $this->render('backend/dashboard/profile.html.twig', [
            'usuario'       => $usuario,
            'weather'       => $weather,
            'breadcrumbs'   => $breadcrumbs,
            'form'          => $form->createView(),
            'formDir'       => $formDir->createView(),
        ]);
    }

}
