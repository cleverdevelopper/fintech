<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
    use App\Utils\ViewManager;
    use App\Model\Entity\LoginEntity\UtilizadorPermissoes as EntityUtilizador;

    use App\Utils\Funcoes;

    class DashboardController extends PageController
    {
        public static function getDashboard($request)
        {
            if (Funcoes::Permition(0)) {
                //$quantidadeTotal = EntityUtilizador::getUtilizadores(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

                $content = ViewManager::render('dashboard/painel', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    //'users'         => $quantidadeTotal,
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('SIGECM | Painel Incial', $content);
            } 
        }

    }
?>