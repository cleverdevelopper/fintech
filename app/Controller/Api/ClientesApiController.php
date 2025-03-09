<?php
    namespace App\Controller\Api;
    use App\Model\Entity\clienteEntity;
    use App\Model\Entity\ContasEntity;

    class ClientesApiController extends Api{
        public static function getClientes($request) {
            $itens = [];

            $results = clienteEntity::getCliente(null, 'codigo_cliente DESC', null);

            while ($objCliente = $results->fetchObject(clienteEntity::class)) {
                $objConta   = ContasEntity::getContaByclienteId($objCliente->codigo_cliente);
                $itens[] = [
                    'id'            => $objCliente->codigo_cliente,
                    'name'          => $objCliente->nome_completo,
                    'birthday'      => $objCliente->data_nascimento,
                    'genero'        => $objCliente->genero,
                    'codigo_conta'  => $objConta->codigo_conta,
                    'numero_conta'  => $objConta->numero_conta,
                    'estado'        => $objConta->status,
                    'saldo'         => $objConta->saldo,
                    'tipo_doc'      => $objCliente->tipo_documento,
                    'documento'     => $objCliente->documento_identidade,
                    'celular'       => $objCliente->celular,
                    'celular_alt'   => $objCliente->celular_alt,
                    'endereco'      => $objCliente->endereco,
                    'email'         => $objCliente->email
                ];
            }
        
            return $itens;
        }
    }
?>