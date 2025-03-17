<?php
    namespace App\Controller\Dashboard;

use App\Controller\Alert;
use App\Controller\PageController;
    use App\Model\Entity\ClienteEntity;
    use App\Model\Entity\ContasEntity;
use App\Model\Entity\DepositosEntity;
use App\Model\Entity\GroupEntity;
use App\Model\Entity\SenhaEntity;
use App\Utils\ViewManager;
    use App\Utils\Funcoes;

    class CollaboratorController extends PageController
    {

        private static function getgrupoItem(){
            $itens = '';
            $results = GroupEntity::getGrupos(null, 'codigo_grupo', null);
            While ($objGrupo = $results->fetchObject(GroupEntity::class)){
                $itens .=ViewManager::render('dashboard/modules/collaborator/grupoItem', [
                    'codigo'              => $objGrupo->codigo_grupo,
                    'grupo'               => $objGrupo->nome_grupo,
                ]);
            }
            return $itens;
        }

        private static function getSenhaItem(){
            $itens = '';
            $results = SenhaEntity::getSenha(null, 'codigo_senha_config', null);
            While ($objSenha = $results->fetchObject(SenhaEntity::class)){
                $itens .=ViewManager::render('dashboard/modules/collaborator/senhaItem', [
                    'senha'              => $objSenha->senha
                ]);
            }
            return $itens;
        }


        public static function setNewCollabPage($request){
            if(Funcoes::Permition(0)){
                $file = $request->getFile();
                $postVars = $request->getPostVars();

                $objCliente = new ClienteEntity;
                $objCliente->nome_completo              = $postVars['text_fullname'];
                $objCliente->data_nascimento            = $postVars['text_data_nascimento'];
                $objCliente->genero                     = $postVars['text_genero'];
                $objCliente->tipo_documento             = $postVars['tipo_documento'];
                $objCliente->documento_identidade       = $postVars['text_numero_documento'];
                $objCliente->local_de_emissao           = $postVars['text_local_emissao'];
                $objCliente->data_emissao               = $postVars['text_data_emissao'];
                $objCliente->data_expiracao             = $postVars['text_data_expiracao'];
                $objCliente->distrito_residencia        = $postVars['text_distrito'];
                $objCliente->cidade_residencia          = $postVars['text_cidade'];
                $objCliente->endereco                   = $postVars['text_endereco'];
                $objCliente->celular                    = $postVars['text_celular'];
                $objCliente->celular_alt                = $postVars['text_celular_alt'];
                $objCliente->email                      = $postVars['text_email'];
                $objCliente->palavra_passe              = md5($postVars['text_password']);
                $objCliente->anexo_documento            = $file;
                $objCliente->grupos                     = $postVars['text_grupo'];
                $objCliente->data_admissao              = parent::getNowDate();
                $objCliente->criado_em                  = parent::getNowDateTime();
                $objCliente->atualizado_em              = parent::getNowDateTime();

                $objCliente->cadastrar();
                $request->getRouter()->redirect('/new-collaborator?status=created');
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        public static function getNewCollabPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/collaborator/newCollaborator', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'grupos'        => self::getgrupoItem(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getCollabItem(),
                    'senha'         => self::getSenhaItem(),
                    'status'        => self::getStatus($request) 
                ]);

                return parent::getPage('FINTECH | Clientes', $content);
            } 
        }



        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){ 
                case 'created':
                    return Alert::getSuccess('O cliente foi cadastrado com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('O cliente foi actualizado com sucesso.');
                    break;
                case 'deposit':
                    return Alert::getSuccess('Deposito realizado com sucesso.');
                    break;
            }
        } 


        private static function getCollabItem(){
            $itens = '';
            $results = ClienteEntity::getCliente(null, 'codigo_cliente DESC', null);
            While ($objCliente = $results->fetchObject(ClienteEntity::class)){
                $objConta = ContasEntity::getContaByclienteId($objCliente->codigo_cliente);

                $itens .=ViewManager::render('dashboard/modules/collaborator/item', [
                    'codigo'              => $objCliente->codigo_cliente,
                    'numero_conta'        => $objConta->numero_conta,
                    'nome_completo'       => $objCliente->nome_completo,
                    'contacto'            => $objCliente->celular,
                    'estado'              => $objConta->status,
                    'cor'                 => 'bg-success'
                ]);
            }
            return $itens;
        }


        public static function getCollabPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/collaborator/collaborator', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getCollabItem(),
                    'status'        => self::getStatus($request)
                ]);

                return parent::getPage('FINTECH | Clientes', $content);
            } 
        }


        private static function getIEmptyListCollab($request){
            $itens = ''; 
            $itens = '<tr><td colspan="6" class="text-center">Nenhum dado pesquisado</td></tr>';
            return $itens;
        }
       
        public static function getListCollab($request, )
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/collaborator/listCollabs', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getIEmptyListCollab($request),
                    'status'        => self::getStatus($request)
                ]);

                return parent::getPage('FINTECH | Cliente', $content);
            } 
        }

        

    }
?>