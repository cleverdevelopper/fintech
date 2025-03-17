<?php
    namespace App\Controller\Api;

    class Api{
        public static function getDetails($request){
            return[
                'name'      => 'FINTECH - API',
                'versao'    => 'v1.0.0',
                'autor'     => 'cleverdeveloper',
            ];
        }

        public static function formatarNumero($numero) {
            // Formata o número com separador de milhar (.) e separador decimal (,)
            return number_format($numero, 2, ',', '.');
        }
    }

?>