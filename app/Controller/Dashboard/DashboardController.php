<?php
    namespace App\Controller\Dashboard;
    use App\Controller\PageController;
use App\Model\Entity\ContasEntity;
use App\Model\Entity\DepositosEntity;
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
            }elseif(Funcoes::Permition(8)){
                //$quantidadeTotal = EntityUtilizador::getUtilizadores(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
                $objConta   = ContasEntity::getContaByclienteId($_SESSION['admin']['utilizador']['id']);

                $results = DepositosEntity::getDepositos('codigo_cliente = '.$_SESSION['admin']['utilizador']['id'].' AND '.'tipo_transacao = "Deposito"' ,"codigo_cliente DESC", null);
                $total_depositos = 0;
                while ($row = $results->fetchObject(DepositosEntity::class)) {
                    $total_depositos += $row->montante; // Usando a notação de objeto
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


                $content = ViewManager::render('dashboard/painelCliente', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'saldo'         => $objConta->saldo,
                    'loan'          => 0, //$total_depositos,
                    'participation' => $participation
                ]);

                return parent::getPage('SIGECM | Painel Incial', $content);
            }
        }

    }
?>