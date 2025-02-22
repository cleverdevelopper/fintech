<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class EmailEntity{
        public $codigo_email_config;
        public $email;                    
        public $senha;   
        public $host_mail;   
        public $porta;   
        public $protocolo_tls;   
        public $protocolo_ssl;   
        public $criado_em;
        public $atualizado_em;  

        
        public  function cadastrar(){
            $this->codigo_email_config = (new Database('email_config'))->insert([
                'email'               => $this->email,
                'senha'               => $this->senha,
                'host_mail'           => $this->host_mail,
                'porta'               => $this->porta,
                'protocolo_tls'       => $this->protocolo_tls,
                'protocolo_ssl'       => $this->protocolo_ssl,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
            return true;
        }

        public static function getEmail($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('email_config'))->select($where, $order, $limit, $fields);
        }

        public static function getEmailById($id){
            return self::getEmail('codigo_email_config = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('email_config'))->update('codigo_email_config = '.$this->codigo_email_config, [
                'email'               => $this->email,
                'senha'               => $this->senha,
                'host_mail'           => $this->host_mail,
                'porta'               => $this->porta,
                'protocolo_tls'       => $this->protocolo_tls,
                'protocolo_ssl'       => $this->protocolo_ssl,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
        }

    }
?>