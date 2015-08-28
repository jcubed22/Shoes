<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views/'));

    //Home page
    $app->get('/', function() use ($app) {

        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    /* Linked from home page "View list of stores."  Links to separate page with store list. */
    $app->get('/stores', function() use ($app) {

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    /* Route for Add Store form from Stores page */
    $app->post('/stores', function() use ($app) {
        $store = new Store($_POST['retailer'], $_POST['address'], $_POST['phone']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    $app->post('/delete_stores', function() use ($app) {
        Store::deleteAll();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    /* Linked from home page "Browse by brand" link.  Takes user to separeate page dispalying list of all added brands. */
    $app->get('/brands', function() use ($app) {

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post('/brands', function() use ($app) {
        $brand = new Brand($_POST['name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post('/delete_brands', function() use ($app) {
        Brand::deleteAll();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    return $app;
?>
