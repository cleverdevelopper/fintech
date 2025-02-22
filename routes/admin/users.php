<?php
    use App\Http\Response;
    use App\Controller\Dashboard\UsersController;

    $objRouter->get('/users', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, UsersController::getUsersPage($request));
        }
    ]);
?>