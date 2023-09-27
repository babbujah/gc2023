<?php
class User extends TRecord{

    const TABLENAME = 'system_user';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max'; //{max, serial}
    
    public function __construct($id = null, $callObjectLoad = true){
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute('name');
        parent::addAttribute('login');
        parent::addAttribute('password');
        parent::addAttribute('email');
        
    }

    public static function getUsuarioByLogin( $login ){
        $criteria = new TCriteria;
        $criteria->add( new TFilter( 'login', '=', $login ) );
        
        $repository = new TRepository( __CLASS__ );
        $userArray = $repository->load( $criteria );
        $user = reset( $userArray );

        return $user;

    }
}
