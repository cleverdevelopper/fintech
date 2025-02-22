<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class ContasEntity{
        public $codigo_conta;
        public $codigo_cliente;
        public $numero_conta;
        public $saldo;
        public $data_abertura; 
        public $status; 
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
    
        
        
        public  function cadastrar(){
            $this->codigo_conta = (new Database('contas'))->insert([
                'codigo_cliente'            => $this->codigo_cliente,
                'numero_conta'              => $this->numero_conta,
                'saldo'                     => $this->saldo,
                'data_abertura'             => $this->data_abertura,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
            return $this->codigo_conta;
        }

        public static function getContas($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('contas'))->select($where, $order, $limit, $fields);
        }

        public static function getContaById($id){
            return self::getContas('codigo_conta = '.$id)->fetchObject(self::class);
        }

        public static function getContaByclienteId($id){
            return self::getContas('codigo_cliente = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('contas'))->update('codigo_conta = '.$this->codigo_conta, [
                'codigo_cliente'            => $this->codigo_cliente,
                'numero_conta'              => $this->numero_conta,
                'saldo'                     => $this->saldo,
                'data_abertura'             => $this->data_abertura,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
        }

    }
?>