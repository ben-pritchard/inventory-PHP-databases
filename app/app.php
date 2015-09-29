<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Collection.php";
    require_once __DIR__."/../src/Item.php";

    //Add symfony debug component and turn it on.
    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    // Set Silex debug mode in $app object
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=inventory';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('collections' => Collection::getAll(), 'items' => Item::getAll()));
    });

    $app->post('/collection', function() use ($app) {
        $collection = new Collection($_POST['name']);
        $collection->save();
        return $app['twig']->render('index.html.twig', array('collections' => Collection::getAll(), 'items' => Item::getAll()));
    });

    $app->post('/delete_collections', function() use ($app) {
        Collection::deleteAll();
        return $app['twig']->render('index.html.twig', array('collections' => Collection::getAll(), 'items' => Item::getAll()));
    });

    $app->post('/item', function() use ($app) {
        $item = new Item($_POST['name']);
        $item->save();
        return $app['twig']->render('index.html.twig', array('collections' => Collection::getAll(), 'items' => Item::getAll()));
    });

    $app->post('/delete_items', function() use ($app) {
        Item::deleteAll();
        return $app['twig']->render('index.html.twig', array('collections' => Collection::getAll(), 'items' => Item::getAll()));
    });

    return $app;
?>
