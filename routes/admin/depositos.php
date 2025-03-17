<?php
    use App\Http\Response;
    use App\Controller\Dashboard\DepositoController;

    $objRouter->get('/deposits', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, DepositoController::getDepositoPage($request));
        }
    ]);

    $objRouter->post('/deposits', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, DepositoController::setNewDepositPage($request));
        }
    ]);
?>