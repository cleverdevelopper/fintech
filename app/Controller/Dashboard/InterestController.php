<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
use App\Model\Entity\InterestEntity;
use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class InterestController extends PageController
    {
        public static function setNewInterestPage($request){
            if(Funcoes::Permition(0)){
                $postVars = $request->getPostVars();


                $objInterest = new InterestEntity;
                $objInterest->tipo_emprestimo        = $postVars['text_interest_description'];
                $objInterest->taxa_juros             = $postVars['text_percentagem'] / 100;
                $objInterest->status                 = $postVars['text_estado'];
                $objInterest->criado_em              = parent::getNowDateTime();
                $objInterest->atualizado_em          = parent::getNowDateTime();

                $objInterest->cadastrar();

                $request->getRouter()->redirect('/interest?status=created');
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        
        
        public static function getNewInterestPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/interest/newinterest', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter()
                ]);

                return parent::getPage('FINTECH | Nova Taxa', $content);
            } 
        }



        private static function getInterestItem(){
            $itens = '';
            $results = InterestEntity::getInterest(null, 'codigo_taxa', null);
            While ($objInterest = $results->fetchObject(InterestEntity::class)){
                $itens .=ViewManager::render('dashboard/modules/interest/item', [
                    'codigo'              => $objInterest->codigo_taxa,
                    'descricao'           => $objInterest->tipo_emprestimo,
                    'percentagem'         => $objInterest->taxa_juros * 100,
                    'estado'              => $objInterest->status,
                ]);
            }
            return $itens;
        }


        public static function getInterestPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/interest/interest', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getInterestItem(),
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('FINTECH | Taxas de Juros', $content);
            } 
        }

    }
?>