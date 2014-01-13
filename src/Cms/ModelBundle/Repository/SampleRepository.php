<?php

namespace Cms\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SampleRepository extends EntityRepository
{
	public function getAll(){

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $samples = $qb->select('s')
            ->from('ModelBundle:Sample', 's')
            ->getQuery()
            ->getArrayResult();

        return $samples;
    }
}
