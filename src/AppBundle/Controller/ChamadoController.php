<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chamado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ChamadoController extends Controller
{
    /**
     * @Route("admin/chamados-abertos", name="chamados-abertos")
     */
    public function indexAction()
    {
        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
//        $this->nameToUppercaseAction();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $todosMisChamados = $em->getRepository('AppBundle:Chamado')->findAllByAdmin(10);
        }else{
            $todosMisChamados = $em->getRepository('AppBundle:Chamado')->findAllByUser($usuario);
        }
        $todosChamados = $em->getRepository('AppBundle:Chamado')->findAll();
        $todosTecnicos = $em->getRepository('AppBundle:Tecnico')->findAll();
        $todosUsuarios = $em->getRepository('AppBundle:User')->findBy(array(), array('lastLogin' => 'DESC'));
        $todosClientes = $em->getRepository('AppBundle:Cliente')->findAll();
        $chamadosFinalizados = $em->getRepository('AppBundle:Chamado')->chamadosFinalAdmin();
        $abertos = $em->getRepository('AppBundle:Chamado')->chamadosAbertos();

        $titulo = 'Chamados Abertos';
        $campos = ['id', 'status', 'nome', 'empresa', 'telefone', 'mensagem', 'data', 'problema'];
        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
            'profile' => [
                'name' => 'Chamados Abertos',
                'url'  => 'profile',
                'is_root' => true
            ],
        ];

        return $this->render('chamado/index.html.twig', array(
            'breadcrumbs' => $breadcrumbs,
            'titulo' => $titulo,
            'todosChamados'         => $todosChamados,
            'todosMisChamados'      => $todosMisChamados,
            'todosTecnicos'         => $todosTecnicos,
            'todosUsuarios'         => $todosUsuarios,
            'todosClientes'         => $todosClientes,
            'chamadosFinalizados'   => $chamadosFinalizados,
            'chamados'       => $abertos,
            'dados' => $abertos,
            'campos' => $campos,
        ));
    }

    /**
     * @Route("admin/chamados-abertos/editar{chamado}", requirements={"chamado": "\d+"}, name="edit-chamados-abertos")
     */
    public function editAction(Chamado $chamado, Request $request)
    {
        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();

        if (null == $chamado->getCliente() && null != $chamado->getEmpresa()){
            $cli = $em->getRepository('AppBundle:Cliente')->findEmpresaLike($chamado->getEmpresa());
            if(null != $cli){
                $chamado->setCliente($cli);
                $chamado->setEmpresa(mb_strtoupper($chamado->getEmpresa()));
                $em->persist($chamado);
                $em->flush();
            }
        }

        $titulo = 'Chamados Abertos';
        $campos = ['id', 'status', 'nome', 'empresa', 'mensagem', 'data', 'problema'];
        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
            'list' => [
                'name' => 'Chamados Abertos',
                'url'  => 'chamados-abertos',
                'is_root' => false
            ],
            'edit' => [
                'name' => 'Editar chamado',
                'url'  => '',
                'is_root' => true
            ],
        ];

        $form = $this->createForm('AppBundle\Form\ChamadoType', $chamado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form["status"]->getData() == 'finalizado'){
                $status = $em->getRepository('AppBundle:Status')->findOneBy(array('nome' => 'finalizado'));
                $chamado->setFinalizado(new \DateTime('now') );
                $chamado->setStatus($status);
            }

            $em->persist($chamado);
            $em->flush();

            return $this->redirectToRoute('chamados-abertos', array('id' => $chamado->getId()));
        }

        return $this->render('chamado/edit.html.twig', array(
            'breadcrumbs' => $breadcrumbs,
            'titulo' => $titulo,
            'dados' => $chamado,
            'campos' => $campos,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/chamados-finalizados", name="chamados-finalizados")
     */
    public function finalizadosAction()
    {
        $usuario = $this->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
//        $ultimosChamados = $em->getRepository('AppBundle:Chamado')->ultimosChamados(5, $usuario);
//        $this->nameToUppercaseAction();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
        {
            $todosMisChamados = $em->getRepository('AppBundle:Chamado')->findAllByAdmin(10);
        }else{
            $todosMisChamados = $em->getRepository('AppBundle:Chamado')->findAllByUser($usuario);
        }
        $todosChamados = $em->getRepository('AppBundle:Chamado')->findAll();
        $todosTecnicos = $em->getRepository('AppBundle:Tecnico')->findAll();
        $todosUsuarios = $em->getRepository('AppBundle:User')->findBy(array(), array('lastLogin' => 'DESC'));
        $todosClientes = $em->getRepository('AppBundle:Cliente')->findAll();
        $chamadosFinalizados = $em->getRepository('AppBundle:Chamado')->chamadosFinalAdmin();
        $finalizados = $em->getRepository('AppBundle:Chamado')->chamadosFinalAdmin();

        $titulo = 'Chamados Finalizados';
        $campos = ['id', 'status', 'nome', 'empresa', 'mensagem', 'finalizado', 'problema'];
        // dados del breadcrumb
        $breadcrumbs = [
            'home' => [
                'name' => 'Painel Principal',
                'url'  => 'homepage',
                'is_root' => true
            ],
            'profile' => [
                'name' => 'Chamados Abertos',
                'url'  => 'profile',
                'is_root' => true
            ],
        ];

        return $this->render('chamado/index.html.twig', array(
            'breadcrumbs' => $breadcrumbs,
            'titulo' => $titulo,
            'todosChamados'         => $todosChamados,
            'todosMisChamados'      => $todosMisChamados,
            'todosTecnicos'         => $todosTecnicos,
            'todosUsuarios'         => $todosUsuarios,
            'todosClientes'         => $todosClientes,
            'chamadosFinalizados'   => $chamadosFinalizados,
            'chamados'       => $finalizados,
            'dados' => $finalizados,
            'campos' => $campos,
        ));
    }
}
