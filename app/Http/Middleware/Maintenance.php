<?php
    namespace App\Http\Middleware;

    use App\Controller\PageController;
    use App\Utils\ViewManager;

    class Maintenance extends PageController{
        public function handle($request, $next){
            $content = ViewManager::render('dashboard/modules/maintenance/maintenance', []);

            if(getenv('MAINTENANCE') == 'true'){
                throw new \Exception(parent::getPage('FINTECH | Manutencao', $content), 200);
            }
           return $next($request);
        }
    }
?>