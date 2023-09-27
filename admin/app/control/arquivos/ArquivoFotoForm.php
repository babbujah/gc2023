<?php
/**
 * ArquivoFotoForm Form
 * @version    1.0
 * @package    control/produto
 * @author     brunosilva
 */
class ArquivoFotoForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    //public function __construct( $param )
    public function __construct( $param = null )
    {
        parent::__construct();

        //var_dump($param);
        
        //TPage::include_css('app/resources/site/css/styles.css');
        //TPage::getLoadedCSS();

        // creates the form
        $this->form = new BootstrapFormBuilder('form_ArquivoFoto');
        $this->form->setFormTitle('Fotos');
        

        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $descricao = new TText('descricao');
        
        $foto_nova = new TFile('foto_nova');
        $foto_nova->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $foto_nova->setCompleteAction( new TAction( [$this, 'onChangeFoto'] ) );
        
        
        //$tipo_id = new THidden('tipo_id');
        $tipo = new TDBCombo( 'tipo_id', 'permission', 'TipoArquivo', 'id', 'nome' );
        $tipo->enableSearch();
        
        $fotoView = new TImage('app/images/noimage.png');
        $fotoView->id = 'foto_view';
        $fotoView->width = '200';


        // add the fields
        $this->form->addFields( [ new TLabel('Id') , $id ] );
        $this->form->addFields( [ new TLabel('Nome'), $nome ] );
        $this->form->addFields( [ new TLabel('Descricao'), $descricao ] );
        $this->form->addFields( [ new TLabel('Tipo'), $tipo ] );
        $this->form->addFields( [ new TLabel('Foto'), $foto_nova ] );
        $this->form->addContent( [$fotoView] );

        // set sizes
        $id->setSize('100%');
        $nome->setSize('100%');
        $descricao->setSize('100%');
        $tipo->setSize('100%');
        $foto_nova->setSize('100%');

        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
        
        $nome->addValidation( 'Nome', new TMinLengthValidator, [2] );
        $tipo->addValidation( 'TipoArquivo', new TRequiredValidator );
        
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }
    
    public static function onChangeFoto($param){
        
        if( !empty($param['foto_nova']) ){
            var_dump($param);
            //$foto = empty($param['use_path']) ? './tmp/'.$param['foto_nova'] : $param['foto_nova'];
            $foto = './tmp/'.$param['foto_nova'];
            TScript::create( "
                    $('#foto_view').attr('src', '".$foto."');
            " );
        }
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            TTransaction::open('permission'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array
            
            $object = empty($data->id) ? new ArquivoFoto : new ArquivoFoto($data->id);  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            if( !empty($data->foto_nova) ){
                $nome_foto = md5(rand()).'.png';
                rename( 'tmp/'.$data->foto_nova, '../../file/foto/'.$nome_foto );
                $object->caminho_arquivo = '../../file/foto/'.$nome_foto;
                $object->store();
                unset( $data->foto_nova );
            }
            
            // get the generated id
            $data->id = $object->id;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            if( !empty($object->caminho_arquivo) ){
                self::onChangeFoto( ['foto_nova' => URL_BASE.$object->caminho_arquivo, 'use_path' => true ] );
            }
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('permission'); // open a transaction
                $object = new ArquivoFoto($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction

                if( !empty($object->caminho_arquivo) ){
                    self::onChangeFoto( ['foto_nova' => URL_BASE.$object->caminho_arquivo, 'use_path' => true] );
                }
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
