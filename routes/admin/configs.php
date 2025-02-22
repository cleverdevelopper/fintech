<?php
    use App\Http\Response;
    use App\Controller\Dashboard\ConfigurationsController;

    $objRouter->get('/configs', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ConfigurationsController::getConfigurationsPage($request));
        }
    ]);

    $objRouter->post('/configs', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, ConfigurationsController::setNewConfiguration($request));
        }
    ]);
?>