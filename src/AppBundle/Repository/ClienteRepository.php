<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ClienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClienteRepository extends EntityRepository
{

    public function findEmpresaLike($texto)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Cliente c
                                WHERE c.nome LIKE :texto
                                ');
        $consulta->setParameter('texto', '%'.$texto.'%');
        return $consulta->getOneOrNullResult();
    }

    public function findIdLike($texto)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c.id
                                FROM AppBundle:Cliente c
                                WHERE c.nome LIKE :texto
                                ');
        $consulta->setParameter('texto', '%'.$texto.'%');
        return $consulta->getResult();
    }

    public function findLike($id)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT c
            FROM AppBundle:Cliente c
            WHERE c.nome LIKE :texto
        ');
        $consulta->setParameter('texto', '%'.$id.'%');
        return $consulta->getOneOrNullResult();
    }

    public function todos()
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                                SELECT c
                                FROM AppBundle:Cliente c
                                ');
        return $consulta->getResult();
    }
}
