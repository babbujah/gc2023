<?php
class ArquivoFoto extends ArquivoMedia{

    public function __construct(){
        parent::__construct();

        $this->tipo_id = 1;
    }

    /*public function get_tipo(){
        if( empty($this->tipo) ){
            $this->tipo = new TipoArquivo( $this->tipo_id );

        }

        return $this->tipo;
    }*/

    public function store(){
        parent::store();
        if( empty($this->hash) ){
            $this->hash = FormatarDados::hash(6, '', $this->id);
            parent::store();
        }
    }

    public function get_url(){
        return URL_BASE.'foto?code='.$this->hash;
    }
}
?>