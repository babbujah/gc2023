<?php
/**
 * ArquivoMediaForm Form
 * @author  <your name here>
 */
class ArquivoMediaForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = NULL )
    {
        parent::__construct();
        
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_ArquivoMedia');
        $this->form->setFormTitle('ArquivoMedia');
        

        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $descricao = new TEntry('descricao');
        //$caminho_arquivo = new TEntry('caminho_arquivo');
        $caminho_arquivo = new TFile('caminho_arquivo');
        $caminho_arquivo->setAllowedExtensions( ['jpg', 'jpeg', 'mp4', 'pdf'] );
        //$caminho_arquivo->setCompleteAction( new TAction( [$this, 'method'] ) );
        
        $tipo = new TDBCombo('tipo', 'permission', 'TipoArquivo', 'id', 'nome');
        //$data_criado = new TDate('data_criado');
        //$hash = new TEntry('hash');


        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $nome ] );
        $this->form->addFields( [ new TLabel('Descricao') ], [ $descricao ] );
        $this->form->addFields( [ new TLabel('Caminho Arquivo') ], [ $caminho_arquivo ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $tipo ] );
        //$this->form->addFields( [ new TLabel('Data Criado') ], [ $data_criado ] );
        //$this->form->addFields( [ new TLabel('Hash') ], [ $hash ] );



        // set sizes
        $id->setSize('100%');
        $nome->setSize('100%');
        $descricao->setSize('100%');
        $caminho_arquivo->setSize('100%');
        $tipo->setSize('100%');
        //$data_criado->setSize('100%');
        //$hash->setSize('100%');



        if (!empty($id))
        {
            $id->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
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
            
            $object = new ArquivoMedia;  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated id
            $data->id = $object->id;
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
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
                $object = new ArquivoMedia($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
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
