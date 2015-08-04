<?php

include 'src/Collection.php';
include 'src/Collector.php';
include 'src/Dispatcher.php';
include 'src/Strategies/AbstractStrategy.php';
include 'src/Strategies/UriStrategy.php';
include 'src/Exceptions/MethodNotAllowedException.php';
include 'src/Exceptions/NotFoundException.php';

class Test {

    /**
     * blablabla
     *
     * @param integer $id blablabla
     */
    public function getSomeTest($id, $name)
    {
        echo "funfo $id $name";
    }
}

$c = new Codeburner\Router\Collector;

$c->get('/user/{id:\d+}[/{name}]', function ($id, $name = 'unknown') {
    echo "hello $name your id is $id";
});

$c->controller('Test');


try {
    $d = new Codeburner\Router\Dispatcher($c->getCollection());
    $d->dispatch('get', '/some/test/18/alex');
} catch (Codeburner\Router\Exceptions\NotFoundException $e) {
    die("request not found for {$e->requested_uri} on {$e->requested_method}");
} catch (Codeburner\Router\Exceptions\MethodNotAllowedException $e) {
    if ($e->can('get')) {
        $d->dispatch('get', $e->requested_uri.'/alex');
    }
}