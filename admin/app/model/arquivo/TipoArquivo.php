<?php
/**
 * TipoArquivo Active Record
 * @author  <your-name-here>
 */
class TipoArquivo extends TRecord
{
    const TABLENAME = 'gc_tipo_arquivo';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
     // foto, vídeo_atividade, video_entrevista, boletim, diversos
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
    }


}
