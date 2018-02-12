<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Endereco;
use AppBundle\Entity\Profile;
use AppBundle\Services\Utiles;
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
        $usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $perfil = $em->getRepository('AppBundle:Profile')->findOneBy(array('user' => $usuario));
        $endereco = $em->getRepository('AppBundle:Endereco')->findOneBy(array('user' => $usuario));
        if (!$perfil) {
            $perfil = new Profile();
            $perfil->setUser($usuario);
        }

        if (!$endereco) {
            $endereco = new Endereco();
            $endereco->setUser($usuario);
        }

        $weather = $utiles->weather();

        $form = $this->createForm('AppBundle\Form\ProfileType', $perfil);
        $formDir = $this->createForm('AppBundle\Form\ProfileDirType', $endereco);
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
        return $this->render('dashboard/profile.html.twig', [
            'usuario'       => $usuario,
            'perfil'        => $perfil,
            'endereco'      => $endereco,
            'weather'       => $weather,
            'breadcrumbs'   => $breadcrumbs,
            'form'          => $form->createView(),
            'formDir'       => $formDir->createView(),
        ]);
    }

}
