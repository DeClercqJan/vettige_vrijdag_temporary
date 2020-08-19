<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\OrderLine;
use App\Entity\VettigeVrijdag;
use App\EventSubscriber\ApiRoute;
use App\Repository\CategoryRepository;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\VettigeVrijdagRepository;
use App\Types\StatusType;
use App\ValueObject\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function __invoke(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        OrderLineRepository $orderLineRepository,
        VettigeVrijdagRepository $vettigeVrijdagRepository,
        EntityManagerInterface $entityManager,
        Environment $twig,
        CategoryRepository $categoryRepository
    ) {
        return new Response($twig->render('test.html.twig'));

        $categories = $categoryRepository->findAll();
        $oneCategory = $categoryRepository->findOneBy(['id' => 1]);
        // return new Response($twig->render('404.html.twig'));
        $orderBasket = [];
        $product1 = $productRepository->findOneBy(['id' => 1]);
        $orderBasket[] = ["product" => $product1, "amount" => 3];
        $product2 = $productRepository->findOneBy(['id' => 2]);
        $orderBasket[] = ["product" => $product2, "amount" => 300];
        $product5 = $productRepository->findOneBy(['id' => 5]);
        $orderBasket[] = ["product" => $product5, "amount" => 1];

        // return new Response($twig->render('3_columns/order-empty.html.twig', ['categories' => $categories]));

//        return new Response($twig->render('3_columns/order-category-chosen.html.twig',
//            ['categoryChosen' => $oneCategory,
//                'categories' => $categories,
//                'orderBasket' => $orderBasket
//            ]));
        // return new Response($twig->render('3_columns/order-category-chosen.html.twig', ['categories' => $categories]));
         // return new Response($twig->render('3_columns/order-empty.html.twig', ['categories' => $categories]));
        // return new Response($twig->render('3_columns/change-menu.html.twig'));
        // return new Response($twig->render('3_columns/order-empty.html.twig'));
        // return new Response($twig->render('confirmed.html.twig'));

        $value = new Category('test', '123', '123');
        if ($value === null || !$value instanceof Category) {
            dd('test');
        }

// return new Response($twig->render('dark_blue_left_bar/order-started.html.twig'));
// return new Response($twig->render('dark_blue_left_bar/order-empty.html.twig'));
        return new Response($twig->render('light_blue_left_bar/confirmed.html.twig'));

// ONDERSTAANDE CODE NOG VAN VOOR FEEDBACK STIJN
//        $vleesjes = new Category('vleesjes', 'vleesjesicon', 'vleesjesimage');
//        $groentjes = new Category('groentjes', 'gro²entjesicon', 'groentjesimage');
//
//        $hamburger = new Product('hamburger', $vleesjes);
//        $frikandel = new Product('frikandel', $vleesjes);
//        $bicky = new Product('bicky', $vleesjes);
//
//        $frieten = new Product('frieten', $groentjes);
//        $ajuintjes = new Product('ajuintjes', $groentjes);
//
//        $orderJan = new Order('Jan');

//        // TEST TOEVOEGEN FRIETEN AAN ORDERLINES
//        $productLineFrietjesJan = new OrderLine($orderJan, $frieten);
//        dump($productLineFrietjesJan);
//        $productLineFrietjesJan->addOneToAmount();
//        $productLineFrietjesJan->addOneToAmount();
//        $productLineFrietjesJan->subtractOneFromAmount();
//        $productLineFrietjesJan->subtractOneFromAmount();
//        $productLineFrietjesJan->subtractOneFromAmount();
//        $productLineFrietjesJan->subtractOneFromAmount();
//        dump($productLineFrietjesJan);
//
//        $productLineBickyJan = new OrderLine($orderJan, $bicky);
//        $productLineBickyJan->addOneToAmount();
//        // dump($productLineBickyJan);
//
//        $orderHadewijch = new Order('Hadewijch');
//
//        // to do: minus one AND/OF remove
//        // ? how? repo callNN
//        // to do: make sure you can only add orderlines with your name to our order.
//        // ? How? Repo call in entity?? Before that in message handler?
//
//        // TEST TOEVOEGEN ORDERLINES AAN ORDER
////        dump($orderJan);
//        $orderJan->addProductLine($productLineFrietjesJan);
////        dump($orderJan);
//        $orderJan->addProductLine($productLineFrietjesJan);
////        dump($orderJan);
//        $orderJan->addProductLine($productLineBickyJan);
////       dump($orderJan);
//        $orderJan->removeProductLine($productLineFrietjesJan);
////       dump($orderJan->getProductLines());
//
//        // to do, maybe, set the other side as well in fucntions like addProductLine
//
//        // ADD PRODUCT TO ORDER AND LET THE WHOLE THING BE DONE BEHIND THE SCENES
//        // to do: make it simpler/more elegant. Perhaps there are other methods than looping array. Or i can refactor this bit in helper function
//        // to do: make methods like removeProductLine private? edit: not sure I want this, actually. At least this way, I'm getting all the info instead of building methods that try to get aspects of the same
////        dump($orderJan->getProductLines());
//        $orderJan->addProduct($bicky);
//        $orderJan->addProduct($bicky);
////        dump($orderJan->getProductLines());
//        $orderJan->addProduct($frieten);
////        dump($orderJan->getProductLines());
//        $orderJan->removeProduct($frieten);
////        dump($orderJan->getProductLines());
//
//        dump($orderJan->getProducts());
//        // mogelijk is dit de verkeerde manier, want alles zit eigenlijk in het ProductLine object, dat ik dan kan callen
//        // to do: is het niet beter om met repo dit te fetchen?
////        dump($orderJan->getProductsWithAmount());
////
////        $newOrder = new CustomerOrder('new order');
////        var_dump($newOrder);
////        $customerOrderRepository->create($newOrder);
//        $newOrder = $customerOrderRepository->findOneBy(['customerName' => 'new order']);
//        dump($newOrder);
//        // probleem? kmoet gelijk eerst die andere entities in db steken
//        $sdgsdgsd = $productRepository->findOneBy(['name' => 'sdgsdgsd']);
//        $newOrder->addProduct($sdgsdgsd);
//        $newOrder->addProduct($sdgsdgsd);
//        $customerOrderRepository->update($newOrder);

// 1. testen andere manier van doen, om alles in 1 keer met React door te spelen
//        $orderNew = new Order('order new5');
//        // eerst maken via de admin routes manier
//        $ajuintjes = $productRepository->findOneBy(['name' => 'ajuintjes']);
//        dump($ajuintjes);
//        $frikandel = $productRepository->findOneBy(['name' => 'frikandel']);
//        $OrderLineNieuw = new OrderLine($orderNew, $ajuintjes, 60);
//        $orderLineNieuw2 = new OrderLine($orderNew, $frikandel, 50);
//        $orderLineRepository->create($OrderLineNieuw);
//        $orderLineRepository->create($orderLineNieuw2);

//        $vettigeVrijdag = $vettigeVrijdagRepository->findOneBy(['status' => 'open']);
//        foreach ( $vettigeVrijdag->getOrders()->toArray() as $order) {
//        dump($order);
//        }

// testen value object
        $valueObject = new Status(Status::OPEN);
        dump($valueObject);
        dump($valueObject->asString());
        dump(Status::fromString('open'));
// $valueSlecht = new Status('foutief');

// 2. testen vettige vrijdag object
// $vettigeVrijdag = new VettigeVrijdag($valueObject);
// var_dump($orderRepository->findAll());
// $orderNew = new Order('order new6', $openVettigeVrijdag);
// eerst maken via de admin routes manier
// $ajuintjes = $productRepository->findOneBy(['name' => 'ajuintjes']);
// dump($ajuintjes);
// $frikandel = $productRepository->findOneBy(['name' => 'frikandel']);
// $OrderLineNieuw = new OrderLine($orderNew, $ajuintjes, 35);
// $orderLineNieuw2 = new OrderLine($orderNew, $frikandel, 25);

// 3. testen andere order toevoegen aan vettige vrijdag totaalbestelling
//        $openVettigeVrijdag = $vettigeVrijdagRepository->findOneBy(['status' => 'open']);
//        $orderNew2 = new Order('order new7', $openVettigeVrijdag);
//        $kipknots = $productRepository->findOneBy(['name' => 'kipknots']);
//        dump($kipknots);
//        $bloemkool = $productRepository->findOneBy(['name' => 'bloemkool']);
//        $OrderLineNieuw3 = new OrderLine($orderNew2, $kipknots, 12);
//        $OrderLineNieuw4 = new OrderLine($orderNew2, $bloemkool, 44);
//        $orderLineRepository->create($OrderLineNieuw3);
//        $orderLineRepository->create($OrderLineNieuw4);

        $vettigeVrijdagNew = new VettigeVrijdag(new Status(Status::OPEN));
        $entityManager->persist($vettigeVrijdagNew);
        $entityManager->flush();

        $openVettigeVrijdag = $vettigeVrijdagRepository->findOneBy(['status' => 'open']);
        dump($openVettigeVrijdag);
        dump($openVettigeVrijdag->getOrders());

        return new Response ($twig->render('/test.html.twig', [
                'vettige_vrijdag' => $openVettigeVrijdag
            ]
        ));
    }
}
