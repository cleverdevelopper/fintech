<?php
    use App\Http\Response;
    use App\Controller\Dashboard\GroupsController;

    $objRouter->get('/groups', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupsController::getGroupsPage($request));
        }
    ]);

    $objRouter->get('/new-group', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupsController::getNewGrupo($request));
        }
    ]);

    $objRouter->post('/new-group', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, GroupsController::setNewGrupo($request));
        }
    ]);

    
?>