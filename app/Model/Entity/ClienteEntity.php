<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class ClienteEntity{
        public $codigo_cliente;
        public $nome_completo;
        public $data_nascimento;
        public $genero;
        public $tipo_documento;
        public $documento_identidade; 
        public $endereco; 
        public $celular; 
        public $celular_alt; 
        public $email;
        public $palavra_passe;  
        public $data_admissao; 
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
        public $grupos; 
    
        
        
        public  function cadastrar(){
            $this->codigo_cliente = (new Database('clientes'))->insert([
                'nome_completo'             => $this->nome_completo,
                'data_nascimento'           => $this->data_nascimento,
                'genero'                    => $this->genero,
                'tipo_documento'            => $this->tipo_documento,
                'documento_identidade'      => $this->documento_identidade,
                'endereco'                  => $this->endereco,
                'celular'                   => $this->celular,
                'celular_alt'               => $this->celular_alt,
                'email'                     => $this->email,
                'palavra_passe'             => $this->palavra_passe,
                'data_admissao'             => $this->data_admissao,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em,
                'grupos'                    => $this->grupos
            ]);
            return $this->codigo_cliente;
        }

        public static function getCliente($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('clientes'))->select($where, $order, $limit, $fields);
        }

        public static function getClienteById($id){
            return self::getCliente('codigo_cliente = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('clientes'))->update('codigo_cliente = '.$this->codigo_cliente, [
                'nome_completo'             => $this->nome_completo,
                'data_nascimento'           => $this->data_nascimento,
                'genero'                    => $this->genero,
                'tipo_documento'            => $this->tipo_documento,
                'documento_identidade'      => $this->documento_identidade,
                'endereco'                  => $this->endereco,
                'celular'                   => $this->celular,
                'celular_alt'               => $this->celular_alt,
                'email'                     => $this->email,
                'palavra_passe'             => $this->palavra_passe,
                'data_admissao'             => $this->data_admissao,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em,
                'grupos'                    => $this->grupos
            ]);
        }

    }
?>