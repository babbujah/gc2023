<?php
class Galeria{
    public function getContent(){
        $html = new THtmlRenderer('app/resources/site/pages/galeria.html');
        $html->enableSection('main');
        return $html->getContents();
    }

}

?>