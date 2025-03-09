<?php
    #=================================================
    # REQUEST QUE NAO SUPORTA API
    #=================================================
    namespace App\Http;

    class Request{
        private $httpMethod;
        private $uri;
        private $queryParams = [];
        private $postVars = [];
        private $headers = [];
        private $router;
        private $file;
        private $file_fiador;
        private $file_fiel;

        public function __construct($router)
        {
            $this->router          = $router;
            $this->httpMethod      = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->setUri();
            $this->queryParams     = $_GET ?? [];
            $this->setPostVars();
            $this->headers         = getallheaders();
        }

        private function setPostVars(){
            if(isset($_FILES['imagem'])){
                $img_name = $_FILES['imagem']['name'];
                $tmp_name = $_FILES['imagem']['tmp_name'];

                $time = time();
                $new_image_name = $time.$img_name;
                move_uploaded_file($tmp_name, "images/depositos/".$new_image_name);

                $this->file = $new_image_name;
                $this->postVars        = $_POST ?? [];
            }elseif(isset($_FILES['file_documento'])){
                #=========================================================
                # Condicao responsavel por guardar as assinaturas
                #=========================================================
                $img_name = $_FILES['file_documento']['name'];
                $tmp_name = $_FILES['file_documento']['tmp_name'];

                $time = time();
                $new_image_name = $time.$img_name;
                move_uploaded_file($tmp_name, "images/documentos/".$new_image_name);

                $this->file = $new_image_name;
                $this->postVars        = $_POST ?? [];

            } else{
                $this->postVars        = $_POST ?? [];
            }

        }
        
        private function setUri(){
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
            $xURI = explode('?', $this->uri);
            $this->uri = $xURI[0];
        }

        public function getHttpMethod(){
            return $this->httpMethod;
        }

        public function getUri(){
            return $this->uri;
        }

        public function getQueryParams(){
            return $this->queryParams;
        }

        public function getPostVars(){
            return $this->postVars;
        }

        public function getHeaders(){
            return $this->headers;
        }

        public function getRouter(){
            return $this->router;
        }

        public function getFile(){
            return $this->file;
        }
        public function getFile_fiador(){
            return $this->file_fiador;
        }
        public function getFile_fiel(){
            return $this->file_fiel;
        }
    }

?>
