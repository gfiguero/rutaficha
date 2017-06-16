<?php

namespace Sig\FichasocialBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PropiedadRepository extends EntityRepository
{

    public function findLikeCalle($calle)
    {

        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('p.id, p.calle')
                    ->andWhere($qb->expr()->like('p.calle', ':calle'))
                    ->groupBy('p.calle')
                    ->orderBy('p.calle', 'ASC')
//                    ->setMaxResults( 5 )
                    ->setParameters(array('calle'=>'%'.$calle.'%'))
                    ->getQuery()
                    ->getArrayResult();

        $list = array();
        foreach ($query as $key => $value) {
            $list[] = array(
                'id'        =>  $value['id'],
                'value'     =>  $value['calle'],
            );
        }
        return $list;
    }

    public function findLikeNumero($calle, $numero)
    {

        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('p.id, p.calle, p.numero')
                    ->andWhere($qb->expr()->andX(
                        $qb->expr()->like('p.calle', ':calle'),
                        $qb->expr()->like('p.numero', ':numero')
                    ))
                    ->groupBy('p.numero')
                    ->orderBy('p.numero', 'ASC')
                    ->setMaxResults( 5 )
                    ->setParameters(array(
                        'calle'            =>  '%'.$calle.'%',
                        'numero'            =>  $numero.'%',
                    ))
                    ->getQuery()
                    ->getArrayResult();

        $list = array();
        foreach ($query as $key => $value) {
            $list[] = array(
                'id'        =>  $value['id'],
                'value'     =>  $value['numero'],
            );
        }
        return $list;
    }

    public function findLikeComplemento($calle, $numero, $complemento)
    {

        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('p.id, p.calle, p.numero, p.complemento')
                    ->andWhere($qb->expr()->andX(
                        $qb->expr()->like('p.calle', ':calle'),
                        $qb->expr()->like('p.numero', ':numero'),
                        $qb->expr()->like('p.complemento', ':complemento')
                    ))
                    ->orderBy('p.complemento', 'ASC')
                    ->setMaxResults( 5 )
                    ->setParameters(array(
                        'calle'            =>  '%'.$calle.'%',
                        'numero'            =>  $numero.'%',
                        'complemento'       =>  '%'.$complemento.'%'
                    ))
                    ->getQuery()
                    ->getArrayResult();

        $list = array();
        foreach ($query as $key => $value) {
            $list[] = array(
                'id'        =>  $value['id'],
                'value'     =>  $value['complemento'],
            );
        }
        return $list;
    }

/*
        $list[] = array(
            'id'        =>  $value['id'],
            'value'     =>  $value['numero'],
        );
        $list[] = array(
            'id'        =>  $value['id'],
            'value'     =>  $value['complemento'],
        );

*/
/*
    public function findLikeNumero($termN)
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('p.id, p.numero')
                    ->andWhere($qb->expr()->like('p.numero', ':numero'))
                    ->orderBy('p.numero', 'ASC')
                    ->setParameters(array(
                        'numero'            =>  $termN.'%',
                    ))
                    ->getQuery()
                    ->getArrayResult();

        $list = array();
        foreach ($query as $key => $value) {
            $list[] = array(
                'id'        =>  $value['id'],
                'value'     =>  $value['numero'],
            );
        }

        return $list;
    }
*/
    public function getById($id)
    {

        $qb = $this->createQueryBuilder('p');

        $query = $qb->select('p.id, p.calle, p.numero, p.complemento')
                    ->where('p.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getArrayResult();

        $list['calle'] = current($query)['calle'];
        $list['numero'] = current($query)['numero'];
        $list['complemento'] = current($query)['complemento'];

        return $list;
    }
}