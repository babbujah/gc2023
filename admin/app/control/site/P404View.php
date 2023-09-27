<?php
class P404View{
    public function getContent(){
        $html = new THtmlRenderer('app/resources/site/pages/404view.html');
        $html->enableSection('main');
        return $html->getContents();
    }

}

?>