<?php
    namespace App\Controller\Dashboard;
    use App\Controller\Alert;
    use App\Utils\ViewManager;
    //use App\Controller\Dashboard\ErrorController;
    use App\Controller\PageController;
    use App\Model\Entity\EmailEntity;
    use App\Model\Entity\SenhaEntity;
    use App\Model\Entity\TelegramEntity;
    use App\Utils\Funcoes;
    use DateTime;
    use DateTimeZone;

    class ConfigurationsController extends PageController{

        #=========================================================
        # Busca a pagina inicial das Configuracoes
        #=========================================================
        public static function setNewConfiguration($request){
            if(Funcoes::Permition(0)){
                $postVars = $request->getPostVars();
                #==========================================================================
                # Cadastro e actualizacao da senha de reset
                #==========================================================================
                if(isset($postVars['text_senha_descricao']) && isset($postVars['text_password']) != ''){

                    $objSenha = SenhaEntity::getSenhaById(1);
                    if($objSenha == null){
                        if($postVars['text_password'] !=  $postVars['text_password_repeat']){
                            $request->getRouter()->redirect('/configs?status=error_match');
                        }else{
                            if($postVars['text_senha_descricao'] == ''){
                                $objSenha = new SenhaEntity;
                                $objSenha->descricao            = "Senha Padrao de reset e cadastro";
                                $objSenha->senha                = $postVars['text_password'];
                                $objSenha->criado_em            = parent::getNowDateTime();
                                $objSenha->atualizado_em        = parent::getNowDateTime();
    
                                $objSenha->cadastrar();
                                $request->getRouter()->redirect('/configs?status=created_password');
                            }else{
                                $objSenha = new SenhaEntity;
                                $objSenha->descricao            = $postVars['text_senha_descricao'];
                                $objSenha->senha                = $postVars['text_password'];
                                $objSenha->criado_em            = parent::getNowDateTime();
                                $objSenha->atualizado_em        = parent::getNowDateTime();
    
                                $objSenha->cadastrar();
                                $request->getRouter()->redirect('/configs?status=created_password');
                            }
                        }
                    }else{
                        if($postVars['text_password'] !=  $postVars['text_password_repeat']){
                            $request->getRouter()->redirect('/configs?status=error_match');
                        }else{
                            if($postVars['text_senha_descricao'] == ''){
                                $objSenha = new SenhaEntity;
                                $objSenha->codigo_senha_config  = 1;
                                $objSenha->descricao            = "Senha Padrao de reset e cadastro";
                                $objSenha->senha                = $postVars['text_password'];
                                $objSenha->atualizado_em        = parent::getNowDateTime();
    
                                $objSenha->actualizar();
                                $request->getRouter()->redirect('/configs?status=updated_password');
                            }else{
                                $objSenha = new SenhaEntity;
                                $objSenha->codigo_senha_config  = 1;
                                $objSenha->descricao            = $postVars['text_senha_descricao'];
                                $objSenha->senha                = $postVars['text_password'];
                                $objSenha->atualizado_em        = parent::getNowDateTime();
    
                                $objSenha->actualizar();
                                $request->getRouter()->redirect('/configs?status=updated_password');
                            }
                        }
                    } 
                }
                #==========================================================================
                # Cadastro e actualizacao do Email
                #==========================================================================
                elseif(isset($postVars['text_email_config']) && isset($postVars['text_email_password']) != ''){
                    
                    $objEmail = EmailEntity::getEmailById(1);

                    if($objEmail == null){
                        $objEmail = new EmailEntity;
                        $protocolo_tls = 0;
                        $protocolo_ssl = 0;

                        if(isset($postVars['protocolo_tls'])){
                            $protocolo_tls = 1;
                            $protocolo_ssl = 0;
                        }else if(isset($postVars['protocolo_ssl'])){
                            $protocolo_tls = 0;
                            $protocolo_ssl = 1;
                        }

                        $objEmail->email                = $postVars['text_email_config'];
                        $objEmail->senha                = $postVars['text_email_password'];
                        $objEmail->host_mail            = $postVars['text_host_mail'];
                        $objEmail->porta                = $postVars['text_port_mail'];
                        $objEmail->protocolo_tls        = $protocolo_tls;
                        $objEmail->protocolo_ssl        = $protocolo_ssl;
                        $objEmail->criado_em            = parent::getNowDateTime();
                        $objEmail->atualizado_em        = parent::getNowDateTime();

                        $objEmail->cadastrar();

                        $request->getRouter()->redirect('/configs?status=created_email');
                    }else{
                        $objEmail = new EmailEntity;
                        $protocolo_tls = 0;
                        $protocolo_ssl = 0;

                        if(isset($postVars['protocolo_tls'])){
                            $protocolo_tls = 1;
                            $protocolo_ssl = 0;
                        }else if(isset($postVars['protocolo_ssl'])){
                            $protocolo_tls = 0;
                            $protocolo_ssl = 1;
                        }

                        $objEmail->codigo_email_config  = 1;
                        $objEmail->email                = $postVars['text_email_config'];
                        $objEmail->senha                = $postVars['text_email_password'];
                        $objEmail->host_mail            = $postVars['text_host_mail'];
                        $objEmail->porta                = $postVars['text_port_mail'];
                        $objEmail->protocolo_tls        = $protocolo_tls;
                        $objEmail->protocolo_ssl        = $protocolo_ssl;
                        $objEmail->atualizado_em        = parent::getNowDateTime();

                        $objEmail->actualizar();
                        $request->getRouter()->redirect('/configs?status=updated_email');
                    }
                }

                else if(isset($postVars['text_bot_token']) && isset($postVars['text_bot_username']) != ''){
                    
                    $objTelegram = TelegramEntity::getTelegramById(1);
                
                    if($objTelegram == null){
                        $objTelegram = new TelegramEntity;
                        $objTelegram->bot_token            = $postVars['text_bot_token'];
                        $objTelegram->bot_username         = $postVars['text_bot_username'];
                        $objTelegram->criado_em            = parent::getNowDateTime();
                        $objTelegram->atualizado_em        = parent::getNowDateTime();

                        $objTelegram->cadastrar();
                        $request->getRouter()->redirect('/configs?status=created_telegram');
                    }else{
                        $objTelegram = new TelegramEntity;
                        $objTelegram->codigo_telegram_config    = 1;
                        $objTelegram->bot_token                 = $postVars['text_bot_token'];
                        $objTelegram->bot_username              = $postVars['text_bot_username'];
                        $objTelegram->atualizado_em             = parent::getNowDateTime();

                        $objTelegram->actualizar();
                        $request->getRouter()->redirect('/configs?status=updated_telegram');
                    }

                }
            }/*else{
                return ErrorController::getError($request);
            }*/
        }


        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){ 
                case 'error_match':
                    return Alert::getError('A senha e  a sua repeticao nao coenscidem.');
                    break;
                case 'created_password':
                    return Alert::getSuccess('A senha de configuracao criada com sucesso.');
                    break;
                case 'updated_password':
                    return Alert::getSuccess('A senha de configuracao actualizada com sucesso.');
                    break;
                case 'created_email':
                    return Alert::getSuccess('O Email de configuracao criado com sucesso.');
                    break;
                case 'updated_email':
                    return Alert::getSuccess('O Email de configuracao actualizado com sucesso.');
                    break;
                case 'created_telegram':
                    return Alert::getSuccess('O Telegram de configuracao criado com sucesso.');
                    break;
                case 'updated_telegram':
                    return Alert::getSuccess('O Telegram de configuracao actualizado com sucesso.');
                    break;
                    
            }
        } 



        public static function getConfigurationsPage($request)
        {
            if (Funcoes::Permition(0)) {
                # Variaves da senha
                $descricao = '';
                $senha = "";

                # variaveis do email
                $email = "";
                $email_senha = "";
                $host = "";
                $port = "";
                $tls = "";
                $ssl = "";

                # variaveis do bot
                $bot_token    = "";
                $bot_username = "";


                $objSenha = SenhaEntity::getSenhaById(1);
                if($objSenha != null){
                    $descricao = $objSenha->descricao;
                    $senha     = $objSenha->senha;
                }

                $objEmail = EmailEntity::getEmailById(1);
                if($objEmail != null){
                    $email          = $objEmail->email;
                    $email_senha    = $objEmail->senha;
                    $host           = $objEmail->host_mail;
                    $port           = $objEmail->porta;
                    
                    if($objEmail->protocolo_tls == 1){
                        $tls = 'chacked';  
                    }
                    if($objEmail->protocolo_ssl == 1){
                        $ssl            = 'chacked';
                    }
                }

                $objTelegram = TelegramEntity::getTelegramById(1);
                if($objTelegram != null){
                    $bot_token        = $objTelegram->bot_token;
                    $bot_username     = $objTelegram->bot_username;
                }

                $content = ViewManager::render('dashboard/modules/configs/configs', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'status'        => self::getStatus($request),
                    'descricao'     => $descricao,
                    'senha'         => $senha,
                    'email'         => $email,
                    'email_senha'   => $email_senha,
                    'host'          => $host,
                    'porta'         => $port,
                    'tls'           => $tls,
                    'ssl'           => $ssl,
                    'bot_token'     => $bot_token,
                    'bot_username'  => $bot_username

                ]);

                return parent::getPage('FINTECH | Configuracoes', $content);
            } 
        }

    }
?>