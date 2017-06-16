<?php

namespace Sig\FichasocialBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CalleRepository extends EntityRepository
{
    public function findLikeNombre($term)
    {

        $qb = $this->createQueryBuilder('c');

        $query = $qb->select('c.id, c.nombre')
                    ->where($qb->expr()->like('c.nombre', ':calle'))
                    ->orderBy('c.nombre', 'ASC')
                    ->setParameter('calle', '%'.$term.'%')
                    ->getQuery()
                    ->getArrayResult();

        $list = array();
        foreach ($query as $key => $value) {
            $list[] = array(
                'id'        =>  $value['id'],
                'value'     =>  $value['nombre'],
            );
        }

        return $list;
    }

    public function getById($term)
    {

        $qb = $this->createQueryBuilder('c');

        $query = $qb->select('c.id, c.nombre')
                    ->where('c.id = :calle')
                    ->setParameter('calle', $term)
                    ->getQuery()
                    ->getArrayResult();

        $list[] = current($query)['nombre'];

        return $list;
    }
}