<?php

namespace Eccube\Tests\Repository;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * ProductRepository test cases.
 *
 * @author Kentaro Ohkouchi
 */
class ProductRepositoryTest extends AbstractProductRepositoryTestCase
{
    public function testGetFavoriteProductQueryBuilderByCustomer()
    {
        $Customer = $this->createCustomer();
        $this->app['orm.em']->persist($Customer);

        $this->createFavorites($Customer);

        // 3件中, 1件は非表示にしておく
        $Disp = $this->app['eccube.repository.master.disp']->find(\Eccube\Entity\Master\Disp::DISPLAY_HIDE);
        $Products = $this->app['eccube.repository.product']->findAll();
        $Products[0]->setStatus($Disp);
        $this->app['orm.em']->flush();

        $qb = $this->app['eccube.repository.product']->getFavoriteProductQueryBuilderByCustomer($Customer);
        $Favorites = $qb
            ->getQuery()
            ->getResult();

        $this->expected = 2;
        $this->actual = count($Favorites);
        $this->verify('お気に入りの件数は'.$this->expected.'件');
    }
}
