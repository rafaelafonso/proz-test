<?php

include("miniglossary.php");
include("translation.php");
include("language.php");

class BuildHtml {

    public function glossariesList() {

        $miniGlossary = new MiniGlossary();
        $glossaries = $miniGlossary->listMiniGlossaries();

        $list = '';
        $position = 1;
        $terms = '';

        while ($row = $glossaries->fetch_assoc()) {

            $terms = $row["term1"].", ".$row["term2"].", ".$row["term3"];
            if (!empty($row["term4"])) {
                $terms = $terms.", ".$row["term4"];
            }
            if (!empty($row["term5"])) {
                $terms = $terms.", ".$row["term5"];
            }

$list = $list.'
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                              <div>
                                <h6 class="my-0">'.$row["topic"].'</h6>
                                <small class="text-muted">'.$terms.'</small>
                              </div>
                              <span class="text-muted">
                                <form method="post" action="./index.php?a=showAddTranslation&mini='.$row["id"].'">
                                    <button type="submit" class="btn btn-primary">Add translation</button>
                                    <button type="submit" class="btn btn-secondary" formaction="./index.php?a=translations&mini='.$row["id"].'">See translations</button>
                                </form>
                                </span>
                            </li>';
        }

        $divList = '
        <div class="col-md-6 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-left mb-3">
        <span class="text-muted">Mini Glossaries</span>
      </h4>
      <ul class="list-group mb-3" id="myList">'.$list.'
      </ul>

      <form class="card p-2" action="./index.php?a=showAddGlossary" method="post">
        <div class="input-group">
          <div class="input-group-append">
            <button type="submit" class="btn btn-primary">Add mini glossary</button>
          </div>
        </div>
      </form>
    </div>';

        return $divList;
    }

    public function addGlossaryForm() {

        $divForm = '
        <div class="col-md-3 order-md-1">
          <h4 class="mb-3">Add Mini Glossary</h4>
          <form class="needs-validation" novalidate method="post" action="./index.php?a=addGlossary">

          <div class="mb-3">
            <div class="input-group">
              <input type="text" class="form-control" id="topic" name="topic" placeholder="Topic" required>
              <div class="invalid-feedback" style="width: 100%;">
                Topic is required.
              </div>
            </div>
          </div>

            <div class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" id="term1" name="term1" placeholder="First term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  First term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" id="term2" name="term2" placeholder="Second term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Second term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" id="term3" name="term3" placeholder="Third term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Third term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" id="term4" name="term4" placeholder="Fourth term (optional)">
              </div>
            </div>

            <div class="mb-3">
              <div class="input-group">
                <input type="text" class="form-control" id="term5" name="term5" placeholder="Fifth term (optional)">
              </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Add</button>
          </form>
          </div>';

          return $divForm;
    }

    public function addTranslationForm($miniGlossaryID) {

        // languages selector
        $language = new Language();
        $allLanguages = $language->allLanguages();

        $languageSelector = '<select name="language">';

        while ($row = $allLanguages->fetch_assoc()) {
            $languageSelector = $languageSelector.'
                <option value="'.$row["language"].'">'.$row["language"].'</option>';
        }

        $languageSelector = $languageSelector.'
        </select>';

        $miniGlossary = new MiniGlossary();
        $glossary = $miniGlossary->selectMiniGlossary($miniGlossaryID);

        $row = $glossary->fetch_assoc();

        $divForm = '<div class="col-md-5 order-md-1">
          <h4 class="mb-3">Add Translation on '.$row["topic"].'</h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <form class="form-inline" method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term1"].'">
                <div class="form-group mb-6">
                    <input type="text" class="form-control" name="content" placeholder="'.$row["term1"].' translation">
                </div>
                <div class="form-group mb-6 mx-sm-3">
                '.$languageSelector.'
                </div>
                <div class="form-group mb-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <form class="form-inline" method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term2"].'">
                <div class="form-group mb-6">
                    <input type="text" class="form-control" name="content" placeholder="'.$row["term2"].' translation">
                </div>
                <div class="form-group mb-6 mx-sm-3">
                '.$languageSelector.'
                </div>
                <div class="form-group mb-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <form class="form-inline" method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term3"].'">
                <div class="form-group mb-6">
                    <input type="text" class="form-control" name="content" placeholder="'.$row["term3"].' translation">
                </div>
                <div class="form-group mb-6 mx-sm-3">
                '.$languageSelector.'
                </div>
                <div class="form-group mb-6">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </li>';
            $firstOptionalTranslation = "";
            $secondOptionalTranslation = "";

            if (!empty($row["term4"])) {

                $firstOptionalTranslation = '
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                    <form class="form-inline" method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term4"].'">
                    <div class="form-group mb-6">
                        <input type="text" class="form-control" name="content" placeholder="'.$row["term4"].' translation">
                    </div>
                    <div class="form-group mb-6 mx-sm-3">
                    '.$languageSelector.'
                    </div>
                    <div class="form-group mb-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    </form>
                </div>
                </li>';
            }

            if (!empty($row["term5"])) {

                $secondOptionalTranslation = '
                 <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <form class="form-inline" method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term5"].'">
                                <div class="form-group mb-6">
                                    <input type="text" class="form-control" name="content" placeholder="'.$row["term5"].' translation">
                                </div>
                                <div class="form-group mb-6 mx-sm-3">
                                '.$languageSelector.'
                                </div>
                                <div class="form-group mb-6">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                            </li>';
            }

            $divForm = $divForm.$firstOptionalTranslation.$secondOptionalTranslation.'
            </ul>
        </div>';

          $divList = $this->glossariesList();
          return $divForm.$divList;
    }

    public function translationsList($translations) {

        $list = '';

        while ($row = $translations->fetch_assoc()) {

            $list = $list.
                    '        <li class="list-group-item d-flex justify-content-between lh-condensed">
                              <div>
                                <h6 class="my-0">Term: '.$row["term"].'</h6>
                                <small class="text-muted">Translation: '.$row["content"].' ('.$row["language"].')</small>
                              </div>
                            </li>';
        }

        $divList = '<div class="col-md-5 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-left mb-3">
        <span class="text-muted">Translations</span>
      </h4>
      <ul class="list-group mb-3">'.$list.'
      </ul>
    </div>';

        $glossaries = $this->glossariesList();
        return $glossaries.$divList;
    }

    public function mainScreen() {

        $divList = $this->glossariesList();
        $divForm = $this->addGlossaryForm();

        return $logout.$divList.$divForm;
    }
}
?>
