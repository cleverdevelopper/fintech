<?php

    #===================================================
    #  Rotas relacionadas com dashboard
    #===================================================
    include __DIR__.'/admin/painel.php';
    include __DIR__.'/admin/collaborator.php';
    include __DIR__.'/admin/interest.php';
    include __DIR__.'/admin/users.php';
    include __DIR__.'/admin/groups.php';
    include __DIR__.'/admin/configs.php';
    include __DIR__.'/admin/depositos.php';

    #===================================================
    #  Rotas relacionadas com API
    #===================================================
    include __DIR__.'/api/v1/clientes.php';
    /*include __DIR__.'/api/v1/visits.php';
    include __DIR__.'/api/v1/funcionarios.php';
    include __DIR__.'/api/v1/armamento.php';
    */
    #===================================================
    #  Rotas relacionadas com dashboard
    #===================================================
    include __DIR__.'/login/login.php';
?>