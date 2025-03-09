<?php
    //=============================================
    // Ficheiro das permissoes do sistema
    //=============================================
    return[
        //==========================================
        // Administracao do sistema
        //==========================================
        [
            'permissao'         => 'Taxas de Juros',
            'funcionalidade'    => 'Visualizar e cadastrar taxas de Juros'
        ], 
        [
            'permissao'         => 'Gestao de utilizadores',
            'funcionalidade'    => 'Visualizar e gerir utilizadores'
        ],
        [
            'permissao'         => 'Gestao de Grupos',
            'funcionalidade'    => 'Visualizar e cadastrar Grupos'
        ],
        [
            'permissao'         => 'Configuracoes do Sistema',
            'funcionalidade'    => 'Gestao de configuracoes do sistema'
        ],

        //==========================================
        // Permissoes de Operador
        //==========================================
        [
            'permissao'         => 'Depositos',
            'funcionalidade'    => 'Visualizar e Aprovar Depositos'
        ], 
        [
            'permissao'         => 'Emprestimos',
            'funcionalidade'    => 'Visualiza e Aprovar Emprestimos'
        ], 
        [
            'permissao'         => 'Colaboradores',
            'funcionalidade'    => 'Visualiza e Aprova novos Colaboradores'
        ],
        [
            'permissao'         => 'Geracao de Relatorios',
            'funcionalidade'    => 'Gera relatorios gerais do sistema'
        ],

        //==========================================
        // Permissoes do Colaboradores
        //==========================================
        [
            'permissao'         => 'Movimentos',
            'funcionalidade'    => 'Visualiza os seus movimentos'
        ], 
        [
            'permissao'         => 'Transferencias',
            'funcionalidade'    => 'Realizar trasferencias'
        ],
        [
            'permissao'         => 'Emprestimos',
            'funcionalidade'    => 'Pedido de Emorestimos'
        ],


    ]

?>