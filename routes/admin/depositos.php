<?php
    use App\Http\Response;
    use App\Controller\Dashboard\DepositoController;

    $objRouter->get('/deposit', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, DepositoController::getDepositoPage($request));
        }
    ]);

    $objRouter->get('/new-deposit', [
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
    ]);
?>