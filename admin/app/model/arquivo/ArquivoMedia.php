<?php
abstract class ArquivoMedia extends TRecord{
    const TABLENAME = 'gc_arquivo_media';
    const PRIMARYKEY = 'id';
    const IDPOLICE = 'serial';

    const CREATEDAT = 'data_criado';
    
    private $tipo;

    public function __construct( $id = NULL, $callObjectLoad = TRUE ){
        parent::__construct( $id, $callObjectLoad );

        parent::addAttribute( 'nome' );
        parent::addAttribute( 'descricao' );
        parent::addAttribute( 'caminho_arquivo' );
        parent::addAttribute( 'tipo_id' );
        parent::addAttribute( 'data_criado' );
        parent::addAttribute( 'hash' );

    }
    
    public function get_tipo(){
        if( empty( $this->tipo ) ){
            $this->tipo = new TipoArquivo( $this->tipo_id );
            
        }
        
        return $this->tipo;
    }

}
?>