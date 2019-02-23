<?php

class Language {

    private $table = 'Language';

    public function allLanguages() {
        $network = new Network();
        $allLanguages = $network->read($this->table);

        return $allLanguages;
    }
}
?>
