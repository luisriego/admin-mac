<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ChamadoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ChamadoRepository extends EntityRepository
{

    /**
     * @param $usuario
     * @return array
     */
    public function findAllByUser($usuario)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c, t, s
                                FROM AppBundle:Chamado c
                                JOIN c.status s
                                JOIN c.tecnicos t
                                WHERE t.username = :usuario
                                AND c.status != 6
                                ');
        $consulta->setParameter('usuario', $usuario);
        return $consulta->getResult();
    }

    /**
     * @param $cliente
     * @return array
     */
    public function findAllByCliente($cliente)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Chamado c
                                WHERE c.cliente = :cliente
                                ');
        $consulta->setParameter('cliente', $cliente);
        return $consulta->getResult();
    }

    /**
     * @param $cliente
     * @return array
     */
    public function findAllByClienteBetween($empresa, $desde, $hasta)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Chamado c
                                WHERE c.empresa LIKE :empresa
                                AND c.data > :desde
                                AND c.data < :hasta
                                ');
        $consulta->setParameter('empresa', '%'.$empresa.'%');
        $consulta->setParameter('desde', $desde);
        $consulta->setParameter('hasta', $hasta);
        return $consulta->getResult();
    }

    public function findAllByClienteBetweenGrafico($empresa, $desde, $hasta)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT MONTH(c.data) AS mes, COUNT(c) AS qtd
                                FROM AppBundle:Chamado c
                                WHERE c.empresa LIKE :empresa
                                AND c.data > :desde
                                AND c.data < :hasta
                                GROUP BY mes
                                ');
        $consulta->setParameter('empresa', '%'.$empresa.'%');
        $consulta->setParameter('desde', $desde);
        $consulta->setParameter('hasta', $hasta);
        return $consulta->getResult();
    }

    /**
     * @param $cliente
     * @return array
     */
    public function findEmpresaByCliente($cliente, $desde, $hasta)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Chamado c
                                WHERE c.cliente = :cliente
                                AND c.data >= :desde
                                AND c.data <= :hasta
                                ');
        $consulta->setParameter('cliente', $cliente);
        $consulta->setParameter('desde', $desde);
        $consulta->setParameter('hasta', $hasta);
        return $consulta->getResult();
    }

    public function findEmpresaByClienteGrafico($cliente, $desde, $hasta)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT MONTH(c.data) AS mes, COUNT(c) AS qtd
                                FROM AppBundle:Chamado c
                                WHERE c.cliente = :cliente
                                AND c.data >= :desde
                                AND c.data <= :hasta
                                ORDER BY mes
                                ');
        $consulta->setParameter('cliente', $cliente);
        $consulta->setParameter('desde', $desde);
        $consulta->setParameter('hasta', $hasta);
        return $consulta->getResult();
    }

    /**
     * @param $usuario
     * @param DateTime $desde
     * @param DateTime $hasta
     * @return array
     */
    public function findChamadosByUser($usuario, \DateTime $desde = null, \DateTime $hasta = null)
    {
        if(!$desde){ $desde = new \DateTime('2016-01-01'); }
        if(!$hasta){ $hasta = new \DateTime('now'); }

        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Chamado c
                                WHERE c.nome = :usuario
                                AND c.data > :desde
                                AND c.data < :hasta
                                ');
        $consulta->setParameter('usuario', $usuario);
        $consulta->setParameter('desde', $desde);
        $consulta->setParameter('hasta', $hasta);
        return $consulta->getResult();
    }

    /**
     * @param $usuario
     * @return array
     */
    public function findAllByAdmin($limite = 1000)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c, s
                                FROM AppBundle:Chamado c
                                JOIN c.status s
                                WHERE c.status != 6
                                AND c.status != 4
                                ORDER BY c.data DESC
                                ');
        $consulta->setMaxResults($limite);
        return $consulta->getResult();
    }

//    public function findAllByAdmin()
//    {
//        $em = $this->getEntityManager();
//        $consulta = $em->createQuery('
//                                SELECT c, s
//                                FROM AppBundle:Chamado c
//                                JOIN c.status s
//                                WHERE c.status != 6
//                                ');
//        return $consulta->getResult();
//    }

    public function findTecnicos($chamado)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT IDENTITY(c.tecnicos)
                                FROM AppBundle:Chamado c
                                WHERE c.id = :chamado
                                ');
        $consulta->setParameter('chamado', $chamado);
        return $consulta->getArrayResult();
    }

    public function findAutorizado($chamado, $usuario)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c.id
                                FROM AppBundle:Chamado c
                                JOIN c.tecnicos t
                                WHERE c.id = :chamado
                                AND t.username = :usuario
                                ');
        $consulta->setParameter('chamado', $chamado);
        $consulta->setParameter('usuario', $usuario);
        return $consulta->getOneOrNullResult();
    }

    public function ultimosChamados($quantidade=3, $usuario)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Chamado c
                                JOIN c.tecnicos t
                                WHERE t.username = :usuario
                                AND c.status = 1
                                ORDER BY c.data DESC
                                ');
        $consulta->setParameter('usuario', $usuario);
        $consulta->setMaxResults($quantidade);
        return $consulta->getArrayResult();
    }

    public function chamadosFinalizados($usuario)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c, t, s
                                FROM AppBundle:Chamado c
                                JOIN c.status s
                                JOIN c.tecnicos t
                                WHERE c.status = 6
                                AND t.username = :usuario
                                OR c.finalizado IS NULL 
                                ORDER BY c.data DESC
                                ');
        $consulta->setParameter('usuario', $usuario);
        return $consulta->getArrayResult();
    }

    /*
     * Chamados Finalizados
     */
    public function chamadosAbertos()
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT ch, s
                                FROM AppBundle:Chamado ch
                                JOIN ch.status s
                                WHERE ch.status != 2
                                ');
        return $consulta->getArrayResult();
    }

    public function chamadosFinalAdmin($limite = 1000)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c, s
                                FROM AppBundle:Chamado c
                                JOIN c.status s
                                WHERE c.status = 6
                                OR c.status = 4
                                OR c.finalizado IS NULL 
                                ORDER BY c.data DESC
                                ');
        $consulta->setMaxResults($limite);
        return $consulta->getResult();
    }
}
