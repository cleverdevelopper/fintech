<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
    use App\Model\Entity\InterestEntity;
    use App\Model\Entity\LoginEntity\Utilizador;
    use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class UsersController extends PageController
    {
       
        private static function getUsersItem(){
            $itens = '';
            $results = Utilizador::getUsers(null, 'codigo_utilizador', null);
            While ($objUtilizador = $results->fetchObject(InterestEntity::class)){
                $itens .=ViewManager::render('dashboard/modules/users/item', [
                    'codigo'              => $objUtilizador->codigo_utilizador,
                    'nome_utilizador'     => $objUtilizador->nome_utilizador,
                    'utilizador'          => $objUtilizador->utilizador,
                    'descricao_grupo'     => $objUtilizador->descricao_grupo,
                    'estado'              => 'Activo', // $objUtilizador->status 
                ]);
            }
            return $itens;
        }


        public static function getUsersPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/users/users', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getUsersItem(),
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('FINTECH | Taxas de Juros', $content);
            } 
        }

    }
?>