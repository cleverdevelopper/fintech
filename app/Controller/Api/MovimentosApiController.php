<?php
    namespace App\Controller\Api;
    use App\Model\Entity\clienteEntity;
    use App\Model\Entity\ContasEntity;
    use App\Model\Entity\DepositosEntity;

    class MovimentosApiController extends Api{
        public static function getMovimentos($request) {
            $itens = [];

            $results = DepositosEntity::getDepositos('status = "Pendente"',"codigo_movimento DESC", null);
            While ($objDeposito = $results->fetchObject(ClienteEntity::class)){
                $objConta   = ContasEntity::getContaByclienteId($objDeposito->codigo_cliente);
                $objCliente = ClienteEntity::getClienteById($objDeposito->codigo_cliente);
                $itens[] = [
                    'id'                => $objDeposito->codigo_movimento,
                    'name'              => $objCliente->nome_completo,
                    'codigo_conta'      => $objConta->codigo_conta,
                    'numero_conta'      => $objConta->numero_conta,
                    'estado'            => $objConta->status,
                    'saldo'             => parent::formatarNumero($objConta->saldo),
                    'celular'           => $objCliente->celular,
                    'celular_alt'       => $objCliente->celular_alt,
                    'endereco'          => $objCliente->endereco,
                    'email'             => $objCliente->email,
                    'tipo_transacao'    => $objDeposito->tipo_transacao,
                    'talao_transacao'   => $objDeposito->talao_transacao,
                    'montante'          => parent::formatarNumero($objDeposito->montante),
                    'data'              => $objDeposito->data,
                    'data_valor'        => $objDeposito->data_valor,
                    'referencia'        => $objDeposito->referencia,
                    'descricao'         => $objDeposito->descricao,
                ];
            }
        
            return $itens;
        }
    }
?>