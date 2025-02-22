<?php
    use App\Http\Response;
    use App\Controller\Dashboard\InterestController;

    $objRouter->get('/interest', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, InterestController::getInterestPage($request));
        }
    ]);

    $objRouter->get('/new-interest', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, InterestController::getNewInterestPage($request));
        }
    ]);

    $objRouter->post('/new-interest', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, InterestController::setNewInterestPage($request));
        }
    ]);

    
?>