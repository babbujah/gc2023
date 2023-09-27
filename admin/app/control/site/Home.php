<?php
class Home{
    public function getContent(){
        $html = new THtmlRenderer('app/resources/site/pages/home.html');
        $html->enableSection('main');
        return $html->getContents();
    }

}

?>