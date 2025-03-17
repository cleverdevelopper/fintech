<?php
    namespace App\Controller\Dashboard;

    use App\Controller\Alert;
    use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
    use App\Model\Entity\DepositosEntity;
    use App\Model\Entity\GroupEntity;
    use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class RequestsController extends PageController
    {
        public static function setRequestAnswerPage($request){
            if(Funcoes::Permition(0)){
                $postVars = $request->getPostVars();
                $objDeposito = new DepositosEntity;

                if($postVars['status'] == 'Aprovado'){
                    $objDeposito->codigo_movimento           = $postVars['text_codigo_movimento'];
                    $objDeposito->status                     = $postVars['status'];
                    $objDeposito->atualizado_em              = parent::getNowDateTime();

                    $objDeposito->actualizarDeposito();
                    $request->getRouter()->redirect('/requests?status=aproved');
                }else if($postVars['status'] == 'Rejeitado'){
                    $objDeposito->codigo_movimento           = $postVars['text_codigo_movimento'];
                    $objDeposito->status                     = $postVars['status'];
                    $objDeposito->atualizado_em              = parent::getNowDateTime();

                    $objDeposito->actualizarDeposito();
                    $request->getRouter()->redirect('/requests?status=rejected');
                }
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        
        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){ 
                case 'aproved':
                    return Alert::getSuccess('O Valor foi depositado com sucesso.');
                    break;
                case 'rejected':
                    return Alert::getSuccess('A Requisição foi rejeitada com suceso.');
                    break;
                
            }
        } 

        private static function getMovimentosClienteItem(){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('status = "Pendente"',"codigo_movimento DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
                $objConta = ContasEntity::getContaByclienteId($objDeposito->codigo_cliente);
                $border = "";
                $text = "";
                $icon = "";

                if($objDeposito->tipo_transacao == 'Deposito'){
                    $border = 'border-success';
                    $text = 'text-success'; 
                } else{
                    $border = 'border-danger';
                    $text = 'text-danger';
                    $icon = '<i class="bi bi-dash"></i>'; 
                }
                
                $itens .=ViewManager::render('dashboard/modules/requests/item', [
                    'codigo_movimento'  => $objDeposito->codigo_movimento,
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'tipo'              => $objDeposito->tipo_transacao,
                    'montante'          => parent::formatarNumero($objDeposito->montante),
                    'numero_conta'      => $objConta->numero_conta,
                    'cor'               => $cor,
                    'border'            => $border,
                    'text'              => $text,
                    'icon'              => $icon
                ]);
            }
            return $itens;  
        }
        
        public static function getRequestsPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/requests/requests', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'requests'      => self::getMovimentosClienteItem(),
                    'status'        => self::getStatus($request)
                ]);

                return parent::getPage('FINTECH | Requisições', $content);
            } 
        }
    }
?>