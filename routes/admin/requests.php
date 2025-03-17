<?php
    use App\Http\Response;
    use App\Controller\Dashboard\RequestsController;

    $objRouter->get('/requests', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, RequestsController::getRequestsPage($request));
        }
    ]);

    $objRouter->post('/requests', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, RequestsController::setRequestAnswerPage($request));
        }
    ]);

    /*$objRouter->get('/new-deposit', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, DepositoController::getNewDeposito($request));
        }
    ]);

    $objRouter->post('/new-deposit', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, DepositoController::setNewDepositPage($request));
        }
    ]);*/

?>