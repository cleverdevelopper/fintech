<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class DepositosEntity{
        public $codigo_deposito;
        public $codigo_cliente;
        public $codigo_conta;
        public $numero_conta;
        public $montante;
        public $talao_deposito; 
        public $status; 
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
    
        public  function cadastrar(){
            $this->codigo_deposito = (new Database('depositos'))->insert([
                'codigo_cliente'            => $this->codigo_cliente,
                'codigo_conta'              => $this->codigo_conta,
                'numero_conta'              => $this->numero_conta,
                'montante'                  => $this->montante,
                'talao_deposito'            => $this->talao_deposito,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
            return $this->codigo_deposito;
        }

        public static function getDepositos($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('depositos'))->select($where, $order, $limit, $fields);
        }

        public static function getDepositosById($id){
            return self::getDepositos('codigo_deposito = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('depositos'))->update('codigo_deposito = '.$this->codigo_deposito, [
                'codigo_cliente'            => $this->codigo_cliente,
                'codigo_conta'              => $this->codigo_conta,
                'numero_conta'              => $this->numero_conta,
                'montante'                  => $this->montante,
                'talao_deposito'            => $this->talao_deposito,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
        }

    }
?>