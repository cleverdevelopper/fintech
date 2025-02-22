<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class SenhaEntity{
        public $codigo_senha_config;
        public $descricao;                    
        public $senha;   
        public $criado_em;
        public $atualizado_em;  

        
        public  function cadastrar(){
            $this->codigo_senha_config = (new Database('senha_config'))->insert([
                'senha'               => $this->senha,
                'descricao'           => $this->descricao,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
            return true;
        }

        public static function getSenha($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('senha_config'))->select($where, $order, $limit, $fields);
        }

        public static function getSenhaById($id){
            return self::getSenha('codigo_senha_config = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('senha_config'))->update('codigo_senha_config = '.$this->codigo_senha_config, [
                'senha'               => $this->senha,
                'descricao'           => $this->descricao,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
        }

    }
?>