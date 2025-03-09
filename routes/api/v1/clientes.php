<?php
    use App\Http\Response;
    use App\Controller\Api;

    $objRouter->get('/api/clientes', [
        'middlewares' => [
            'api'
        ],
        function ($request){
            return new Response(200, Api\ClientesApiController::getClientes($request), 'application/json');
        }
    ]);
?>