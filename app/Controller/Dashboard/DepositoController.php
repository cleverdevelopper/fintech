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

        #Funcao que faz a geracao das Referencias
        private static function gerarReferencia() {
            // Obtém o timestamp atual
            $timestamp = time();
            // Gera a referência no formato REF + timestamp
            $referencia = "REF" . $timestamp;
            return $referencia;
        }
        

        private static function getMovimentosClienteItem($id){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('codigo_cliente = '.$id ,"codigo_cliente DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
                $objConta   = ContasEntity::getContaByclienteId($id);
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



                if($objDeposito->status == "Pendente"){
                    $cor = 'bg-warning';
                }
                if($objDeposito->status == "Aprovado"){
                    $cor = 'bg-success';
                }
                if($objDeposito->status == "Rejeitado"){
                    $cor = 'bg-danger';
                }

                $itens .=ViewManager::render('dashboard/modules/deposit/item', [
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'status'            => $objDeposito->status,
                    'montante'          => parent::formatarNumero($objDeposito->montante),
                    'saldos'            => parent::formatarNumero($objConta->saldo),
                    'cor'               => $cor,
                    'border'            => $border,
                    'text'              => $text,
                    'icon'              => $icon
                ]);
            }
            return $itens;  
        }
        
        
        private static function getMovimentosItem(){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('status = "Aprovado" ' ,"codigo_movimento DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
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


                if($objDeposito->status == "Pendente"){
                    $cor = 'bg-warning';
                }
                if($objDeposito->status == "Aprovado"){
                    $cor = 'bg-success';
                }
                if($objDeposito->status == "Rejeitado"){
                    $cor = 'bg-danger';
                }

                $itens .=ViewManager::render('dashboard/modules/deposit/itemDeposit', [
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'tipo'              => $objDeposito->tipo_transacao,
                    'status'            => $objDeposito->status,
                    'montante'          => parent::formatarNumero($objDeposito->montante),
                    'cor'               => $cor,
                    'border'            => $border,
                    'text'              => $text,
                    'icon'              => $icon
                ]);
            }
            return $itens; 
        }

        public static function setNewDepositPage($request){
            if(Funcoes::Permition(0) || Funcoes::Permition(5)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                if(isset($postVars['text_codigo_cliente'])){
                    $objConta   = ContasEntity::getContaByclienteId($postVars['text_codigo_cliente']);
                }

                $objDeposito = new DepositosEntity;
                $objDeposito->data                   = parent::getNowDate();
                $objDeposito->data_valor             = parent::getNowDate();
                $objDeposito->codigo_cliente         = $postVars['text_codigo_cliente'];
                $objDeposito->codigo_conta           = $objConta->codigo_conta;
                $objDeposito->numero_conta           = $objConta->numero_conta;
                $objDeposito->montante               = $postVars['text_montante_deposito'];
                $objDeposito->referencia             = self::gerarReferencia();
                $objDeposito->descricao              = "Deposito em Dinheiro";
                $objDeposito->tipo_transacao         = 'Deposito';
                $objDeposito->talao_transacao        = $file;
                $objDeposito->status                 = 'Aprovado';
                $objDeposito->criado_em              = parent::getNowDateTime();
                $objDeposito->atualizado_em          = parent::getNowDateTime();

                $objDeposito->cadastrar();
                $request->getRouter()->redirect('/search-collaborator?status=deposit');
            }elseif(Funcoes::Permition(10)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                if(isset($postVars['text_codigo_cliente'])){
                    $objConta   = ContasEntity::getContaByclienteId($postVars['text_codigo_cliente']);
                }

                $objDeposito = new DepositosEntity;
                $objDeposito->data                   = parent::getNowDate();
                $objDeposito->data_valor             = parent::getNowDate();
                $objDeposito->codigo_cliente         = $postVars['text_codigo_cliente'];
                $objDeposito->codigo_conta           = $objConta->codigo_conta;
                $objDeposito->numero_conta           = $objConta->numero_conta;
                $objDeposito->montante               = $postVars['text_montante_deposito'];
                $objDeposito->referencia             = self::gerarReferencia();
                $objDeposito->descricao              = "Deposito em Dinheiro";
                $objDeposito->tipo_transacao         = 'Deposito';
                $objDeposito->talao_transacao        = $file;
                $objDeposito->status                 = 'Pendente';
                $objDeposito->criado_em              = parent::getNowDateTime();
                $objDeposito->atualizado_em          = parent::getNowDateTime();

                $objDeposito->cadastrar();
                $request->getRouter()->redirect('/deposits?status=requested');
            }
            
            /*else{
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
                case 'requested':
                    return Alert::getSuccess('O deposito submetido para aprovacao com sucesso.');
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
                $objConta   = ContasEntity::getContaByclienteId($_SESSION['admin']['utilizador']['id']);
                $content = ViewManager::render('dashboard/modules/deposit/depositCliente', [
                    'navbar'                => parent::getNavbar(),
                    'sidebar'               => parent::getMenu(),
                    'footer'                => parent::getFooter(),
                    'status'                => self::getStatus($request),
                    'numero_conta'          => $objConta->numero_conta,
                    'codigo_conta'          => $objConta->codigo_conta,
                    'nome_completo'         => $_SESSION['admin']['utilizador']['nome_utilizador'],
                    'codigo_conta_cliente'  => $_SESSION['admin']['utilizador']['id'],
                    'saldo'                 => parent::formatarNumero($objConta->saldo) ,
                    'depositos'             => self::getMovimentosClienteItem($_SESSION['admin']['utilizador']['id'])
                ]);
                return parent::getPage('FINTECH | Meus Movimentos', $content);
            } 
        }

    }
?>