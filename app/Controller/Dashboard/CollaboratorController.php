<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
    use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class CollaboratorController extends PageController
    {

        public static function setNewCollabPage($request){
            if(Funcoes::Permition(0)){
                $postVars = $request->getPostVars();


                /*$objInterest = new InterestEntity;
                $objInterest->tipo_emprestimo        = $postVars['text_interest_description'];
                $objInterest->taxa_juros             = $postVars['text_percentagem'] / 100;
                $objInterest->status                 = $postVars['text_estado'];
                $objInterest->criado_em              = parent::getNowDateTime();
                $objInterest->atualizado_em          = parent::getNowDateTime();

                $objInterest->cadastrar();

                $request->getRouter()->redirect('/collaborator?status=created');*/
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        public static function getNewCollabPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/collaborator/newCollaborator', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getCollabItem(),
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('FINTECH | Colaboradores', $content);
            } 
        }


        private static function getCollabItem(){
            $itens = '';
            $results = ClienteEntity::getCliente(null, 'codigo_cliente', null);
            While ($objCliente = $results->fetchObject(ClienteEntity::class)){
                $objConta = ContasEntity::getContaByclienteId($objCliente->codigo_cliente);

                $itens .=ViewManager::render('dashboard/modules/collaborator/item', [
                    'codigo'              => $objCliente->codigo_cliente,
                    'numero_conta'        => $objConta->numero_conta,
                    'nome_completo'       => $objCliente->nome_completo,
                    'contacto'            => $objCliente->celular,
                    'estado'              => $objConta->status,
                ]);
            }
            return $itens;
        }


        public static function getCollabPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/collaborator/collaborator', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getCollabItem(),
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('FINTECH | Colaboradores', $content);
            } 
        }

    }
?>