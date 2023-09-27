<?php
/**
 * ArquivoMediaList Listing
 * @author  <your name here>
 */
class ArquivoMediaList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('permission');            // defines the database
        $this->setActiveRecord('ArquivoMedia');   // defines the active record
        $this->setDefaultOrder('id', 'asc');         // defines the default order
        $this->setLimit(10);
        // $this->setCriteria($criteria) // define a standard filter

        $this->addFilterField('id', '=', 'id'); // filterField, operator, formField
        $this->addFilterField('nome', 'like', 'nome'); // filterField, operator, formField
        $this->addFilterField('descricao', 'like', 'descricao'); // filterField, operator, formField
        $this->addFilterField('caminho_arquivo', 'like', 'caminho_arquivo'); // filterField, operator, formField
        $this->addFilterField('tipo', 'like', 'tipo'); // filterField, operator, formField
        $this->addFilterField('data_criado', 'like', 'data_criado'); // filterField, operator, formField
        $this->addFilterField('hash', 'like', 'hash'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_ArquivoMedia');
        $this->form->setFormTitle('ArquivoMedia');
        

        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $descricao = new TEntry('descricao');
        $caminho_arquivo = new TEntry('caminho_arquivo');
        $tipo = new TEntry('tipo');
        $data_criado = new TEntry('data_criado');
        $hash = new TEntry('hash');


        // add the fields
        $this->form->addFields( [ new TLabel('Id') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Nome') ], [ $nome ] );
        $this->form->addFields( [ new TLabel('Descricao') ], [ $descricao ] );
        $this->form->addFields( [ new TLabel('Caminho Arquivo') ], [ $caminho_arquivo ] );
        $this->form->addFields( [ new TLabel('Tipo') ], [ $tipo ] );
        $this->form->addFields( [ new TLabel('Data Criado') ], [ $data_criado ] );
        $this->form->addFields( [ new TLabel('Hash') ], [ $hash ] );


        // set sizes
        $id->setSize('100%');
        $nome->setSize('100%');
        $descricao->setSize('100%');
        $caminho_arquivo->setSize('100%');
        $tipo->setSize('100%');
        $data_criado->setSize('100%');
        $hash->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction(['ArquivoMediaForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'right');
        $column_nome = new TDataGridColumn('nome', 'Nome', 'left');
        $column_descricao = new TDataGridColumn('descricao', 'Descricao', 'left');
        $column_caminho_arquivo = new TDataGridColumn('caminho_arquivo', 'Caminho Arquivo', 'left');
        $column_tipo = new TDataGridColumn('tipo', 'Tipo', 'left');
        $column_data_criado = new TDataGridColumn('data_criado', 'Data Criado', 'left');
        $column_hash = new TDataGridColumn('hash', 'Hash', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_descricao);
        $this->datagrid->addColumn($column_caminho_arquivo);
        $this->datagrid->addColumn($column_tipo);
        $this->datagrid->addColumn($column_data_criado);
        $this->datagrid->addColumn($column_hash);

        
        $action1 = new TDataGridAction(['ArquivoMediaForm', 'onEdit'], ['id'=>'{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}']);
        
        $this->datagrid->addAction($action1, _t('Edit'),   'far:edit blue');
        $this->datagrid->addAction($action2 ,_t('Delete'), 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup('', 'white');
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        // header actions
        $dropdown = new TDropDown(_t('Export'), 'fa:list');
        $dropdown->setPullSide('right');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction( _t('Save as CSV'), new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table blue' );
        $dropdown->addAction( _t('Save as PDF'), new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf red' );
        $panel->addHeaderWidget( $dropdown );
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
}
