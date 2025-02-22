<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class TelegramEntity{
        public $codigo_telegram_config;
        public $bot_token;                    
        public $bot_username;   
        public $criado_em;
        public $atualizado_em;  

        
        public  function cadastrar(){
            $this->codigo_telegram_config = (new Database('telegram_config'))->insert([
                'bot_token'           => $this->bot_token,
                'bot_username'        => $this->bot_username,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
            return true;
        }

        public static function getTelegram($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('telegram_config'))->select($where, $order, $limit, $fields);
        }

        public static function getTelegramById($id){
            return self::getTelegram('codigo_telegram_config = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('telegram_config'))->update('codigo_telegram_config = '.$this->codigo_telegram_config, [
                'bot_token'           => $this->bot_token,
                'bot_username'        => $this->bot_username,
                'criado_em'           => $this->criado_em,
                'atualizado_em'       => $this->atualizado_em
            ]);
        }

    }
?>