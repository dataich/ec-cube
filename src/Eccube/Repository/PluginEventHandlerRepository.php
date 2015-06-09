<?php

namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PluginEventHandlerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PluginEventHandlerRepository extends EntityRepository
{


    public function getHandlers()
    {
        $qb = $this->createQueryBuilder('e')
            ->innerJoin('e.Plugin', 'p')
            ->andWhere('e.del_flg = 0 ') ;

        return $qb->getQuery()->getResult();
    }


}
