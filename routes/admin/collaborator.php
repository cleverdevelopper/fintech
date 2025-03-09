<?php
    use App\Http\Response;
    use App\Controller\Dashboard\CollaboratorController;

    $objRouter->get('/collaborator', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, CollaboratorController::getCollabPage($request));
        }
    ]);

    $objRouter->get('/new-collaborator', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, CollaboratorController::getNewCollabPage($request));
        }
    ]);

    $objRouter->post('/new-collaborator', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, CollaboratorController::setNewCollabPage($request));
        }
    ]);

    $objRouter->get('/search-collaborator', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, CollaboratorController::getListCollab($request));
        }
    ]);

    $objRouter->post('/search-collaborator', [
        'middlewares'   => [
            'requere-admin-login'
        ],
        function ($request){
            return new Response(200, CollaboratorController::setNewDepositPage($request));
        }
    ]);
?>