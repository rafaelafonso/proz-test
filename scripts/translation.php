<?php

class Translation {

    private $table = "Translation";

    // addTranslation
    //
    public function addTranslation($miniGlossaryID, $term, $content, $language) {

        $network = new Network();
        $network->writeTranslation($miniGlossaryID, $content, $term, $language);
    }

    // listTranslations
    //
    public function listTranslations($miniGlossaryID) {

        $network = new Network();
        $allTranslations = $network->search($this->table, "miniGlossaryID", $miniGlossaryID);

        return $allTranslations;
    }
}

?>
