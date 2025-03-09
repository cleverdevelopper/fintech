<?php
    namespace App\Controller\Dashboard;;

use App\Controller\Alert;
use App\Utils\ViewManager;
    use App\Model\Entity\GroupEntity as EntityGrupos;
    //use App\Controller\Dashboard\ErrorController;
    use App\Controller\PageController;
    use App\Utils\Funcoes;
    use DateTime;
    use DateTimeZone;

    class GroupsController extends PageController{
        #=========================================================
        # Cadastro de uma nova permissao
        #=========================================================

        private static function getPermissoes($start, $limit, $situation){
            $itens = "";
            $permissoes = include(__DIR__.'/../../Model/Entity/Permissoes.php');
            for($i=$start; $i < $limit; $i++) {
                $itens .=ViewManager::render('dashboard/modules/groups/itemPermition', [
                    'id__permissao' => $i,
                    'permissao'     => $permissoes[$i]['permissao'],
                    'descricao'     => $permissoes[$i]['funcionalidade'],
                    'situation'     => $situation
                ]);
            }
            return $itens;
        }


        public static function setNewGrupo($request){
            if(Funcoes::Permition(0)){
                $date = new DateTime('now', new DateTimeZone('Africa/Maputo')); 
                $formattedDate = $date->format('Y-m-d H:i:s');

                $permissoes = [];
                $total__permissoes = count(include(__DIR__.'/../../Model/Entity/Permissoes.php'));
                $postVars = $request->getPostVars();

                if(isset($postVars['check_permissao'])){
                    $permissoes = $postVars['check_permissao'];
                }
                
                $permissoes__finais = "";
                for( $i = 0; $i < 100; $i++){
                    if ($i < $total__permissoes){
                        if(in_array($i, $permissoes)){
                            $permissoes__finais .= '1';
                        }else{
                            $permissoes__finais .= '0';
                        }
                    }else{
                        $permissoes__finais .= '0';
                    }
                }


                $objGrupo = new EntityGrupos;
                $objGrupo->nome_grupo       = $postVars['text_group_name'];
                $objGrupo->descricao        = $postVars['text_descricao'];
                $objGrupo->permissoes       = $permissoes__finais;
                $objGrupo->criado_em        = $formattedDate;
                $objGrupo->atualizado_em    = $formattedDate;

                $objGrupo->cadastrar();
                $request->getRouter()->redirect('/groups?status=created');
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        public static function getNewGrupo($request){
            if(Funcoes::Permition(0)){
                $content = ViewManager::render('dashboard/modules/groups/newgroup',[
                    'navbar'            => parent::getNavbar(),
                    'sidebar'           => parent::getMenu(),
                    'footer'            => parent::getFooter(),
                    'itemAdmin'         => self::getPermissoes(0, 4, 'disabled'),
                    'itemOperador'      => self::getPermissoes(4, 8, ''),
                    'itemColaborador'   => self::getPermissoes(8, 11, ''),
                ]);

                return parent::getPage('FINTECH | Cadastrar Grupo', $content);
            }/*else{
                return ErrorController::getError($request);
            }*/
        }

        #=========================================================
        # Fim Cadastro de uma nova permissao
        #=========================================================
















        /*private static function getPermissoesBD($start, $limit, $id){
            $itens = "";
            $objGrupo =  EntityGrupos::getGrupoById($id); 

            if(!$objGrupo instanceof EntityGrupos){
                $request->getRouter()->redirect('/grupos');
            }

            $permissao_temporaria = substr($objGrupo->permissoes, $start, 1);
            $checked = $permissao_temporaria == '1' ? 'checked' : '';
            $permissoes = include(__DIR__.'/../../Model/Entity/Permissoes.php');
            for($i=$start; $i < $limit; $i++) {
                $itens .=ViewManager::render('dashboard/modules/grupos/itemPermissao', [
                    'id__permissao' => $i,
                    'permissao'     => $permissoes[$i]['permissao'],
                    'descricao'     => $permissoes[$i]['funcionalidade'],
                    'check'         => $checked
                ]);
            }
            return $itens;
        }*/

     
        


        /*public static function getEditGrupo($request, $id){
            if(Funcoes::Permition(0)){
                $objGrupo =  EntityGrupos::getGrupoById($id); 

                if(!$objGrupo instanceof EntityGrupos){
                    $request->getRouter()->redirect('/grupos');
                }

                $content = ViewManager::render('dashboard/modules/grupos/cadastro',[
                    'navbar'                => parent::getNavbar(),
                    'indicate'              => 'Editar grupo de utilizadores',
                    'description'           => $objGrupo->descricao,
                    //'itemAdmin'             => self::getPermissoesBD(0, 5, $id),
                    //'itemClinica'           => self::getPermissoesBD(5, 9, $id),
                    //'itemFarmacia'          => self::getPermissoesBD(9, 11, $id),
                    'button'                => 'Actualizar'
                ]);

                return parent::getPage('Centro-medico - Grupos editar', $content);
            }else{
                return ErrorController::getError($request);
            }
        }


        public static function setEditGrupo($request, $id){
            if(Funcoes::Permition(0)){
                $objGrupo =  EntityGrupos::getGrupoById($id); 

                if(!$objGrupo instanceof EntityGrupos){
                    $request->getRouter()->redirect('/grupos');
                }

                $permissoes = [];
                $total__permissoes = count(include(__DIR__.'/../../Model/Entity/Permissoes.php'));
                $postVars = $request->getPostVars();

                if(isset($postVars['check_permissao'])){
                    $permissoes = $postVars['check_permissao'];
                }
                
                $permissoes__finais = "";
                for( $i = 0; $i < 100; $i++){
                    if ($i < $total__permissoes){
                        if(in_array($i, $permissoes)){
                            $permissoes__finais .= '1';
                        }else{
                            $permissoes__finais .= '0';
                        }
                    }else{
                        $permissoes__finais .= '0';
                    }
                }

                $objGrupo->descricao        = $postVars['text_descricao'] ?? $objGrupo->descricao;
                $objGrupo->permissoes       = $permissoes__finais ?? $objGrupo->permissoes;

                $objGrupo->actualizar();

                $request->getRouter()->redirect('/grupos?status=updated');
            }else{
                return ErrorController::getError($request);
            }
        }

 
        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){
                case 'created':
                    return Alert::getSuccess('Grupo cadastrado com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('Grupo actualizada com sucesso.');
                    break;
                case 'deleted':
                    return Alert::getSuccess('Grupo excluido com sucesso.');
                    break;
            }
        } */
        

        private static function getStatus($request){
            $queryParams = $request->getQueryParams();
            
            if(!isset($queryParams['status'])) return '';

            switch($queryParams['status']){ 
                case 'created':
                    return Alert::getSuccess('O grupo foi criado com sucesso.');
                    break;
                case 'updated':
                    return Alert::getSuccess('O grupo foi actualizado com sucesso.');
                    break;
            }
        } 



        #=========================================================
        # Busca a pagina inicial dos Grupos
        #=========================================================
        private static function getGrupoItens(){
            $itens = '';
            $results = EntityGrupos::getGrupos(null, 'codigo_grupo', null);
            While ($objGrupo = $results->fetchObject(EntityGrupos::class)){                
                $itens .=ViewManager::render('dashboard/modules/groups/item', [
                    'codigo'              => $objGrupo->codigo_grupo,
                    'nome_grupo'          => $objGrupo->nome_grupo,
                    'descricao'           => $objGrupo->descricao,
                    'estado'              => 'Activo', //$objGrupo->status
                ]);
            }
            return $itens;
        }

        public static function getGroupsPage($request)
        {
            if (Funcoes::Permition(0)) {
                $content = ViewManager::render('dashboard/modules/groups/groups', [
                    'navbar'        => parent::getNavbar(),
                    'sidebar'       => parent::getMenu(),
                    'footer'        => parent::getFooter(),
                    'items'         => self::getGrupoItens(),
                    'status'        => self::getStatus($request)
                ]);

                return parent::getPage('FINTECH | Grupos', $content);
            } 
        }

    }
?>