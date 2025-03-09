<?php
    namespace App\Controller\Dashboard;

use App\Controller\Alert;
use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
use App\Model\Entity\DepositosEntity;
use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class DepositoController extends PageController
    {

        private static function getMovimentosClienteItem($id){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('codigo_cliente = '.$id ,"codigo_cliente DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
                $objConta   = ContasEntity::getContaByclienteId($id);
                if($objDeposito->tipo_transacao == "Pendente"){
                    $cor = 'bg-warning';
                }
                if($objDeposito->tipo_transacao == "Deposito"){
                    $cor = 'bg-success';
                }
                if($objDeposito->tipo_transacao == "Transferencia"){
                    $cor = 'bg-danger';
                }

                $itens .=ViewManager::render('dashboard/modules/deposit/item', [
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'descricao'         => $objDeposito->descricao,
                    'estado'            => $objDeposito->tipo_transacao,
                    'montante'          => $objDeposito->montante,
                    'saldos'            => $objConta->saldo,
                    'cor'               => $cor,
                ]);
            }
            return $itens;  
        }
        
        
        private static function getMovimentosItem(){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos(null ,"codigo_cliente DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
                if($objDeposito->tipo_transacao == "Pendente"){
                    $cor = 'bg-warning';
                }
                if($objDeposito->tipo_transacao == "Deposito"){
                    $cor = 'bg-success';
                }
                if($objDeposito->tipo_transacao == "Transferencia"){
                    $cor = 'bg-danger';
                }

                $itens .=ViewManager::render('dashboard/modules/deposit/itemDeposit', [
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'descricao'         => $objDeposito->descricao,
                    'estado'            => $objDeposito->tipo_transacao,
                    'montante'          => $objDeposito->montante,
                    'cor'               => $cor,
                ]);
            }
            return $itens;
        }

        public static function setNewDepositPage($request){
            if(Funcoes::Permition(0)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                if(isset($postVars['text_codigo_cliente'])){
                    $objConta   = ContasEntity::getContaByclienteId($postVars['text_codigo_cliente']);
                }

                $objDeposito = new DepositosEntity;
                $objDeposito->codigo_cliente         = $postVars['text_codigo_cliente'];
                $objDeposito->codigo_conta           = $objConta->codigo_conta;
                $objDeposito->numero_conta           = $objConta->numero_conta;
                $objDeposito->montante               = $postVars['text_montante_deposito'];
                $objDeposito->tipo_transacao         = 'Deposito';
                $objDeposito->talao_transacao        = $file;
                //$objDeposito->status                 = 'Pendente';
                $objDeposito->criado_em              = parent::getNowDateTime();
                $objDeposito->atualizado_em          = parent::getNowDateTime();

                $objDeposito->cadastrar();
                $request->getRouter()->redirect('/deposits?status=created');
            }/*else{
                return ErrorController::getError($request);
            }*/
        }




        public static function getNewDeposito($request)
        {
            if (Funcoes::Permition(0)) {
                $objCliente = ClienteEntity::getClienteById($_SESSION['admin']['utilizador']['id']);
                $objConta   = ContasEntity::getContaByclienteId($objCliente->codigo_cliente);
                $content = ViewManager::render('dashboard/modules/deposit/newDeposit', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'codigo_cliente'=> $objCliente->codigo_cliente,
                    'codigo_conta'  => $objConta->codigo_conta,
                    'numero_conta'  => $objConta->numero_conta
                ]);
                return parent::getPage('FINTECH | Depositos', $content);
            } 
        }


        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){ 
                case 'created':
                    return Alert::getSuccess('Deposito feito com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('O deposito foi actualizado com sucesso.');
                    break;
            }
        } 

        public static function getDepositoPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/deposit/deposit', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'status'        => self::getStatus($request),
                    'depositos'     => self::getMovimentosItem()
                ]);
                return parent::getPage('FINTECH | Depositos', $content);
            }else if(Funcoes::Permition(8)){
                $content = ViewManager::render('dashboard/modules/deposit/depositCliente', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'status'        => self::getStatus($request),
                    'depositos'     => self::getMovimentosClienteItem($_SESSION['admin']['utilizador']['id'])
                ]);
                return parent::getPage('FINTECH | Meus Movimentos', $content);
            } 
        }

    }
?>