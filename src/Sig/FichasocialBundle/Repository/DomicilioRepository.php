<?php

namespace Sig\FichasocialBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DomicilioRepository extends EntityRepository
{
/*
    public function getDomicilioByPersonaId($personaId)
    {

        $qb = $this->createQueryBuilder('d');

        $query = $qb->select('d.id, d.calle, d.numero, d.rol')
                    ->where('d.persona = :personaId')
                    ->orderBy('d.createdAt', 'DESC')
                    ->setMaxResults( 1 )
                    ->setParameters(array('personaId' => $personaId))
                    ->getQuery();

        $domicilio = $query->getOneOrNullResult();

        return $domicilio;

    }

    public function findOneByPersonaId($personaId)
    {

        $qb = $this->createQueryBuilder('d');

        $query = $qb->select('d.id, d.calle, d.numero, d.rol')
                    ->where('d.persona = :personaId')
                    ->orderBy('d.createdAt', 'DESC')
                    ->setMaxResults( 1 )
                    ->setParameters(array('personaId' => $personaId))
                    ->getQuery();

        $domicilio = $query->getOneOrNullResult();

        return $domicilio;

    }
*/
}