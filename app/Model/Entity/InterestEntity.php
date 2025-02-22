<?php
    namespace App\Model\Entity;
    use App\DatabaseManager\Database;

    class InterestEntity{
        public $codigo_taxa;
        public $tipo_emprestimo;
        public $taxa_juros;
        public $status;
        public $criado_em;
        public $atualizado_em; 
        public $apagado_em; 
    
        
        
        public  function cadastrar(){
            $this->codigo_taxa = (new Database('taxas_juros'))->insert([
                'tipo_emprestimo'           => $this->tipo_emprestimo,
                'taxa_juros'                => $this->taxa_juros,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
            return $this->codigo_taxa;
        }

        public static function getInterest($where = null, $order = null, $limit = null, $fields = "*"){
            return (new Database('taxas_juros'))->select($where, $order, $limit, $fields);
        }

        public static function getInterestById($id){
            return self::getInterest('codigo_taxa = '.$id)->fetchObject(self::class);
        }

        public  function actualizar(){
            return (new Database('taxas_juros'))->update('codigo_taxa = '.$this->codigo_taxa, [
                'tipo_emprestimo'           => $this->tipo_emprestimo,
                'taxa_juros'                => $this->taxa_juros,
                'status'                    => $this->status,
                'criado_em'                 => $this->criado_em,
                'atualizado_em'             => $this->atualizado_em,
                'apagado_em'                => $this->apagado_em
            ]);
        }

    }
?>