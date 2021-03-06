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

    /* Allows usage of patch & delete _methods in hidden forms */
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

    /* Route for deleting all stores from Stores page */
    $app->post('/delete_stores', function() use ($app) {
        Store::deleteAll();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    /* Route from Stores page to individual store */
    $app->get('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    /* Route from individual store page to add brand to that store */
    $app->post('/add_brand', function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);

        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    /* Route to edit page from individual store page */
    $app->get('/stores/{id}/edit', function($id) use ($app) {
        $store = Store::find($id);

        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    /* Update individual store */
    $app->patch('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);
        $store->update($_POST['retailer'], $_POST['address'], $_POST['phone']);

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    /* Delete store from store edit page */
    $app->delete('/stores/{id}', function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();

        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    /* Linked from home page "Browse by brand" link.  Takes user to separeate page dispalying list of all added brands. */
    $app->get('/brands', function() use ($app) {

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    /* Route for creating a new brand from the brands pgae */
    $app->post('/brands', function() use ($app) {
        $brand = new Brand($_POST['name']);
        $brand->save();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    /* Route for deleting all brands from the brand page */
    $app->post('/delete_brands', function() use ($app) {
        Brand::deleteAll();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    /* Route from brands page brand name link to view individual brand and list of stores for that brand */
    $app->get('/brands/{id}', function ($id) use ($app) {
        $brand = Brand::find($id);

        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    /* Route from individual brand page to add store to that brand */
    $app->post('/add_store', function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);

        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    /* Route to delete a brand from individual brand page */
    $app->delete('/brand/{id}', function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();

        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    return $app;
?>
