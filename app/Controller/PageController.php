<?php
    namespace App\Controller;
    use App\Utils\Funcoes;
    use App\Utils\ViewManager;
    use DateTime;
    use DateTimeZone;

    class PageController{
        public static function getPage($title, $content){
            return ViewManager::render('dashboard/page', [
                'title'          => $title,
                'content'        => $content
            ]);
        }


        public static function getNavbar(){
            return ViewManager::render('dashboard/common/navbar', [
                'name'              => $_SESSION['admin']['utilizador']['nome_utilizador'],
                'profile_pic'       => '',
                'grupo'             => 'Administrador'
            ]);
        }

        
        public static function getFooter(){
            return ViewManager::render('dashboard/common/footer', []);
        }


        //===============================================
        // Permissoes
        //===============================================
        private static function getAdminMenu(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/admin/admin', []);   
            return $itens;
        }

        private static function getCollaboratorMenu(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/collab/collaborator', []);   
            return $itens;
        }

        private static function getLoan(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/loan/loan', [
                //falta a verificacao do supervisor ou nao
            ]);   
            return $itens;
        }

        private static function getDeposit($menu){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/deposit/deposit', [
                'menu'      => $menu
            ]);   
            return $itens;
        }

        private static function getRequests(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/requests/requests', [
                
            ]);   
            return $itens;
        }

        private static function getTransfer(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/transfer/transfer', [
                //falta a verificacao do supervisor ou nao
            ]);   
            return $itens;
        }


        private static function getWithdraw(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/withdraw/withdraw', [
                //falta a verificacao do supervisor ou nao
            ]);   
            return $itens;
        }

        private static function getReports(){
            $itens = '';
            $itens .= ViewManager::render('dashboard/common/menu/reports/reports', [
                //falta a verificacao do supervisor ou nao
            ]);   
            return $itens;
        }


        public static function getMenu(){
            if(Funcoes::Permition(0)){
                return ViewManager::render('dashboard/common/menu/sidebar', [
                    'admin'               => self::getAdminMenu(),
                    'collab'              => self::getCollaboratorMenu(),
                    'loan'                => self::getLoan(),
                    'deposit'             => '',
                    'withdraw'            => self::getWithdraw(),
                    'transfer'            => self::getTransfer(),
                    'reports'             => self::getReports(),
                    'requests'            => self::getRequests()
                ]);
            }elseif(Funcoes::Permition(8)){
                return ViewManager::render('dashboard/common/menu/sidebar', [
                    'admin'               => '',
                    'collab'              => '',
                    'loan'                => self::getLoan(),
                    'deposit'             => self::getDeposit('Movimentos'),
                    'withdraw'            => self::getWithdraw(),
                    'transfer'            => self::getTransfer(),
                    'reports'             => '',
                    'requests'            => ''
                ]);
            }

            /*if(Funcoes::Permition(0)){
                return ViewManager::render('dashboard/menu/box', [
                    'administracao'     => self::getAdmin(),
                    'clinica'           => self::getClinica(),
                    'farmacia'          => self::getFarmacia(),
                ]);
            }elseif(Funcoes::Permition(5)){
                return ViewManager::render('dashboard/menu/box', [
                    'administracao'     => '',
                    'clinica'           => self::getClinica(),
                    'farmacia'          => '',
                ]);
            }elseif(Funcoes::Permition(9)){
                return ViewManager::render('dashboard/menu/box', [
                    'administracao'     => '',
                    'clinica'           => '',
                    'farmacia'          => self::getFarmacia(),
                ]);
            }*/
        }

        #==========================================================================
        # Funcoes que lidam com as formatacoes das datas
        #==========================================================================
        public static function getNowDateTime(){
            $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
            return $date->format('Y-m-d H:i:s');
        }

        public static function getNowDate(){
            $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
            return $date->format('Y-m-d');
        }

        public static function getFormattedData($data){
            $date = new DateTime($data, new DateTimeZone('UTC'));

            $fmtDate = new \IntlDateFormatter(
                'pt_MZ', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, \IntlDateFormatter::GREGORIAN
            );

            $fmtTime = new \IntlDateFormatter(
                'pt_MZ', \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT,null, \IntlDateFormatter::GREGORIAN 
            );

            $formattedDate = $fmtDate->format($date); 
            $formattedTime = $fmtTime->format($date);

            $formattedDateTime = $formattedDate . ' às ' . $formattedTime;

            return $formattedDateTime;
        }

        public static function getFormattedDataOnly($data){
            $date = new DateTime($data, new DateTimeZone('UTC'));

            $fmtDate = new \IntlDateFormatter(
                'pt_MZ', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, null, \IntlDateFormatter::GREGORIAN
            );

            $formattedDate = $fmtDate->format($date); 
            return $formattedDate;
        }
        #==========================================================================
        # Fim das funcoes que lidam com as formatacoes das datas
        #==========================================================================


        #=====================================================
        # Formatacao dos valores
        #======================================================

        public static function formatarNumero($numero) {
            // Verifica se o número é nulo ou não é um número válido
            if ($numero == null) {
                return '0,00'; // Retorna o valor "0,00" caso o saldo seja null
            }
            // Formata o número com separador de milhar (.) e separador decimal (,)
            return number_format($numero, 2, ',', '.');
        }


    }
?>