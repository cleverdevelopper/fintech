<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class DepositosEntity{
        public $codigo_movimento;
        public $codigo_cliente;
        public $data;
        public $data_valor;
        public $referencia;
        public $descricao;
        public $codigo_conta;
        public $numero_conta;
        public $montante;
        public $tipo_transacao; 
        public $talao_transacao; 
        public $status; 
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
    
        public  function cadastrar(){
            $this->codigo_movimento = (new Database('movimentos'))->insert([
                'codigo_cliente'            => $this->codigo_cliente,
                'data'                      => $this->data,
                'data_valor'                => $this->data_valor,
                'referencia'                => $this->referencia,
                'descricao'                 => $this->descricao,
                'codigo_conta'              => $this->codigo_conta,
                'numero_conta'              => $this->numero_conta,
                'montante'                  => $this->montante,
                'tipo_transacao'            => $this->tipo_transacao,
                'talao_transacao'           => $this->talao_transacao,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
            return $this->codigo_movimento;
        }

        public static function getDepositos($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('movimentos'))->select($where, $order, $limit, $fields);
        }

        public static function getDepositosById($id){
            return self::getDepositos('codigo_movimento = '.$id)->fetchObject(self::class);
        }

        public  function actualizarDeposito(){
            return (new Database('movimentos'))->update('codigo_movimento = '.$this->codigo_movimento, [
                'status'                    => $this->status,
                'atualizado_em'             => $this->atualizado_em
            ]);
        }

        public  function actualizar(){
            return (new Database('movimentos'))->update('codigo_movimento = '.$this->codigo_movimento, [
                'codigo_cliente'            => $this->codigo_cliente,
                'data'                      => $this->data,
                'data_valor'                => $this->data_valor,
                'referencia'                => $this->referencia,
                'descricao'                 => $this->descricao,
                'codigo_conta'              => $this->codigo_conta,
                'numero_conta'              => $this->numero_conta,
                'montante'                  => $this->montante,
                'tipo_transacao'            => $this->tipo_transacao,
                'talao_transacao'           => $this->talao_transacao,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
        }

    }
?>