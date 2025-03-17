<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
    use App\Model\Entity\DepositosEntity;
    use App\Utils\ViewManager;

    use App\Utils\Funcoes;

    class DashboardController extends PageController
    {

        #=============================================
        # Funcao que busca todas requisoes para painel
        #=============================================
        private static function getMovimentosClienteItem($id){
            $itens = '';
            $cor = "";
            $results = DepositosEntity::getDepositos('codigo_cliente = '.$id ,"codigo_movimento DESC", "10");

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

                $itens .=ViewManager::render('dashboard/painelCliente/item', [
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
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


        public static function getDashboard($request)
        {
            if (Funcoes::Permition(0)) {

                $result = ContasEntity::getContas(null, "codigo_conta DESC", null);
                $saldo_global = 0;

                // Soma os saldos de todas as contas
                while ($row = $result->fetchObject(ContasEntity::class)) {
                    $saldo_global += $row->saldo; // Usando a notação de objeto
                }

                $content = ViewManager::render('dashboard/painel', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    //'rightsidebar'  => parent::getRightSidebar(),
                    'footer'        => parent::getFooter(),
                    'saldo'         => parent::formatarNumero($saldo_global),
                    //'users'         => $quantidadeTotal,
                    //'designation'   => 'Utilizadores Activos' 
                ]);

                return parent::getPage('SIGECM | Painel Incial', $content);
            }elseif(Funcoes::Permition(8)){

                $objConta   = ContasEntity::getContaByclienteId($_SESSION['admin']['utilizador']['id']);

                $results = DepositosEntity::getDepositos('codigo_cliente = '.$_SESSION['admin']['utilizador']['id'].' AND '.'tipo_transacao = "Deposito"' ,"codigo_cliente DESC", null);
                $total_depositos = 0;
                while ($row = $results->fetchObject(DepositosEntity::class)) {
                    $total_depositos += $row->montante; // Usando a notação de objeto
                }

                $requisicoes = 0;
                $results = DepositosEntity::getDepositos('codigo_cliente = '.$_SESSION['admin']['utilizador']['id'].' AND '.'status = "Pendente"' ,"codigo_movimento DESC", null);
                while ($results->fetchObject(DepositosEntity::class)) {
                    $requisicoes += 1;
                }

                $result = ContasEntity::getContas(null, "codigo_conta DESC", null);
                $saldo_global = 0;

                // Soma os saldos de todas as contas
                while ($row = $result->fetchObject(ContasEntity::class)) {
                    $saldo_global += $row->saldo; // Usando a notação de objeto
                }

                // Verifica se o saldo global é maior que zero antes de calcular a participação
                if ($saldo_global > 0) {
                    $participation = round(($objConta->saldo / $saldo_global) * 100, 2);
                } else {
                    // Se o saldo global for zero, a participação será 0 ou você pode definir uma lógica personalizada
                    $participation = 0;
                }


                $content = ViewManager::render('dashboard/painelCliente/painelCliente', [
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'footer'            => parent::getFooter(),
                    'saldo'             => parent::formatarNumero($objConta->saldo),
                    'requisicoes'       => $requisicoes,
                    'loan'              => 0,
                    'participation'     => $participation,
                    'request_moviments' => self::getMovimentosClienteItem($_SESSION['admin']['utilizador']['id'])
                ]);

                return parent::getPage('SIGECM | Painel Incial', $content);
            }
        }

    }
?>