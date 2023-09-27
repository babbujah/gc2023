<?php
class ArquivoVideoAtividade extends ArquivoMedia{

    public function __construct(){
        parent::__construct();

        $this->tipo_id = 2;
    }
}
?>