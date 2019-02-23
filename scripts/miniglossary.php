<?php

class MiniGlossary {

    public $minTerms = 3;
    public $maxTerms = 5;
    private $table = 'MiniGlossary';

    // selectMiniGlossary
    //
    public function selectMiniGlossary($miniGlossaryID) {

        $network = new Network();
        $storedMiniGlossary = $network->search($this->table, "id", $miniGlossaryID);

        return $storedMiniGlossary;
    }

    // listMiniGlossaries
    //
    public function listMiniGlossaries() {

        $network = new Network();
        $allMiniGlossaries = $network->read($this->table);

        return $allMiniGlossaries;
    }

    // checkTerms
    //
    private function checkTerms($terms) {

        return ((count($terms) >= $this->minTerms) && (count($terms) <= $this->maxTerms));
    }

    // create
    //
    public function create($topic, $term1, $term2, $term3, $term4, $term5) {

        // checking if number of terms is correct
        $rawTerms = array(
            $term1, $term2, $term3, $term4, $term5,
        );
        $terms = array();

        for($x = 0; $x < count($rawTerms); $x++) {
            if (!is_null($rawTerms[$x])) {
                array_push($terms, $rawTerms[$x]);
            }
        }

        // writing mini glossary
        if ($this->checkTerms($terms)) {

            $network = new Network();
            $network->writeMiniGlossary($topic, $term1, $term2, $term3, $term4, $term5, $userID);
        }
        else {
            // show error in terms number
        }
    }
}

?>
