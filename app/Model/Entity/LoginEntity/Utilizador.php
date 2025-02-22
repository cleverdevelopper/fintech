<?php
    namespace App\Model\Entity\LoginEntity;
    use App\DatabaseManager\Database;

    class Utilizador{
        public $codigo_utilizador;
        public $grupos;
        public $nome_utilizador;
        public $utilizador;
        public $palavra_passe;        
        public $permissoes;     
        public $descricao_grupo; 
        public $status; 
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
        


        public  function actualizar(){
            return (new Database('utilizadores'))->update('codigo_utilizador = '.$this->codigo_utilizador, [
                'grupos'                    => $this->grupos,
                'nome_utilizador'           => $this->nome_utilizador,
                'utilizador'                => $this->utilizador,
                'palavra_passe'             => $this->palavra_passe,
                'permissoes'                => $this->permissoes,
                'descricao_grupo'           => $this->descricao_grupo,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
            ]);
        }

        public static function getUserByUsername($utilizador){
            return (new Database('utilizadores')) -> select('utilizador = "'.$utilizador.'"')->fetchObject(self::class);
        }

        public static function getUsers($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('utilizadores'))->select($where, $order, $limit, $fields);
        }

        public static function getUserById($id){
            return self::getUsers('codigo_utilizador = '.$id)->fetchObject(self::class);
        }
    }
?>