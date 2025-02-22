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

        private static function getDepositosItem($id){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('codigo_cliente = '.$id ,"codigo_cliente DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
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
                    'codigo'              => $objDeposito->codigo_deposito,
                    'numero_conta'        => $objDeposito->numero_conta,
                    'montante'            => $objDeposito->montante,
                    'talao_deposito'      => $objDeposito->talao_deposito,
                    'estado'              => $objDeposito->status,
                    'cor'                 => $cor,
                ]);
            }
            return $itens;
        }

        private static function getClienteItem($id){
            $itens = '';
            $results = ClienteEntity::getCliente('codigo_cliente = '.$id ,"codigo_cliente", null);
            While ($objCliente = $results->fetchObject(ClienteEntity::class)){
                $objConta = ContasEntity::getContaByclienteId($objCliente->codigo_cliente);
                $itens .=ViewManager::render('dashboard/modules/deposit/depositItem', [
                    'codigo'              => $objCliente->codigo_cliente,
                    'numero_conta'        => $objConta->numero_conta,
                    'nome_completo'       => $objCliente->nome_completo,
                    'tipo_documento'      => $objCliente->tipo_documento,
                    'doc_number'          => $objCliente->documento_identidade,
                    'contacto'            => $objCliente->celular,
                    'contacto_alt'        => $objCliente->celular_alt,
                    'endereco'            => $objCliente->endereco,
                    'email'               => $objCliente->email,
                    'estado'              => $objConta->status,
                ]);
            }
            return $itens;
        }


        public static function setNewDepositPage($request){
            if(Funcoes::Permition(0)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                $objDeposito = new DepositosEntity;
                $objDeposito->codigo_cliente         = $postVars['text_codigo_cliente'];
                $objDeposito->codigo_conta           = $postVars['text_codigo_conta'];
                $objDeposito->numero_conta           = $postVars['text_numero_conta'];
                $objDeposito->montante               = $postVars['text_montante_deposito'];
                $objDeposito->talao_deposito         = $file;
                $objDeposito->status                 = 'Pendente';
                $objDeposito->criado_em              = parent::getNowDateTime();
                $objDeposito->atualizado_em          = parent::getNowDateTime();

                $objDeposito->cadastrar();
                $request->getRouter()->redirect('/deposit?status=created');
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
                    'account'       => self::getClienteItem($_SESSION['admin']['utilizador']['id']),
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
                    return Alert::getSuccess('Deposito Submentido para aprovacao.');
                    break;
                case 'updated':
                    return Alert::getSuccess('A senha de configuracao actualizada com sucesso.');
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
                    'depositos'     => self::getDepositosItem($_SESSION['admin']['utilizador']['id'])
                ]);
                return parent::getPage('FINTECH | Depositos', $content);
            } 
        }

    }
?>