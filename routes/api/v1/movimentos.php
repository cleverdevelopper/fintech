<?php
    use App\Http\Response;
    use App\Controller\Api;

    $objRouter->get('/api/movimentos', [
        'middlewares' => [
            'api'
        ],
        function ($request){
            return new Response(200, Api\MovimentosApiController::getMovimentos($request), 'application/json');
        }
    ]);
?>