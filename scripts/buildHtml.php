<?php

include("miniglossary.php");
include("translation.php");
include("language.php");

class BuildHtml {

    public function glossariesList() {

        $miniGlossary = new MiniGlossary();
        $glossaries = $miniGlossary->listMiniGlossaries();

        $list = '';

        while ($row = $glossaries->fetch_assoc()) {

            $terms = $row["term1"].", ".$row["term2"].", ".$row["term3"].", ".$row["term4"].", ".$row["term5"];

            $list = $list.
                    '        <li class="list-group-item d-flex justify-content-between lh-condensed">
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

        $divList = '<div class="col-md-5 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-left mb-3">
        <span class="text-muted">Mini Glossaries</span>
      </h4>
      <ul class="list-group mb-3">'.$list.'
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

        $divForm = '<div class="col-md-3 order-md-1">
          <h4 class="mb-3">Add Mini Glossary</h4>
          <form class="needs-validation" novalidate method="post" action="./index.php?a=addGlossary">

          <div class="mb-3">
            <label for="topic">Topic</label>
            <div class="input-group">
              <input type="text" class="form-control" id="topic" name="topic" placeholder="Topic" required>
              <div class="invalid-feedback" style="width: 100%;">
                Topic is required.
              </div>
            </div>
          </div>

            <div class="mb-3">
              <label for="term1">First term</label>
              <div class="input-group">
                <input type="text" class="form-control" id="term1" name="term1" placeholder="First term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  First term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="term2">Second term</label>
              <div class="input-group">
                <input type="text" class="form-control" id="term2" name="term2" placeholder="Second term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Second term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="term3">Third term</label>
              <div class="input-group">
                <input type="text" class="form-control" id="term3" name="term3" placeholder="Third term" required>
                <div class="invalid-feedback" style="width: 100%;">
                  Third term is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="term4">Fourth term (Optional)</label>
              <div class="input-group">
                <input type="text" class="form-control" id="term4" name="term4" placeholder="Fourth term">
              </div>
            </div>

            <div class="mb-3">
              <label for="term5">Fifth term (Optional)</label>
              <div class="input-group">
                <input type="text" class="form-control" id="term5" name="term5" placeholder="Fifth term">
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

        $divForm = '<div class="col-md-3 order-md-1">
          <h4 class="mb-3">Add Translation on '.$row["topic"].'</h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="mb-3">
              <label for="term1">'.$row["term1"].'</label>
              <div>
                <form method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term1"].'">
                <input type="text" class="form-control" name="content" placeholder="'.$row["term1"].' translation">
                '.$languageSelector.'
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>

              </div>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="mb-3">
              <label for="term2">'.$row["term2"].'</label>
              <div>
                <form method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term2"].'">
                <input type="text" class="form-control" name="content" placeholder="'.$row["term2"].' translation">
                '.$languageSelector.'
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>

              </div>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="mb-3">
              <label for="term3">'.$row["term3"].'</label>
              <div>
                <form method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term3"].'">
                <input type="text" class="form-control" name="content" placeholder="'.$row["term3"].' translation">
                '.$languageSelector.'
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>

              </div>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <label for="term1">'.$row["term4"].'</label>
              <div>
                <form method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term4"].'">
                <input type="text" class="form-control" name="content" placeholder="'.$row["term4"].' translation">
                '.$languageSelector.'
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
              </div>
            </div>
            </li>

            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div class="mb-3">
              <label for="term1">'.$row["term5"].'</label>
              <div>
                <form method="post" action="./index.php?a=addTranslation&mini='.$row["id"].'&term='.$row["term5"].'">
                <input type="text" class="form-control" name="content" placeholder="'.$row["term5"].' translation">
                '.$languageSelector.'
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
              </div>
            </div>
          </div>
          </li>';

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

        return $logout.$divForm.$divList;
    }
}
?>
