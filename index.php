<?php
include("./scripts/network.php");
include("./scripts/buildHtml.php");

if(isset($_GET['a'])) {
	$action = $_GET['a'];
}
else {
	$action = "";
}

$head = '<!doctype html>
           <html lang="en">
               <head>
                   <meta charset="utf-8">
                   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                   <title>Proz.com Test</title>
                   <link href="./css/bootstrap.min.css" rel="stylesheet">
                   <link href="./css/signin.css" rel="stylesheet">
               </head>
               <body class="text-center">
               ';

$loginForm = '
               <form class="form-signin" action="./index.php?a=login" method="post">
                    <h1 class="h3 mb-3 font-weight-normal">ProZ.com test</h1>
                   <label for="inputUsername" class="sr-only">Username</label>
                   <input type="username" id="inputUsername" name="username" class="form-control" placeholder="Username" required autofocus>
                   <label for="inputPassword" class="sr-only">Password</label>
                   <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                   <button class="btn btn-lg btn-primary btn-block" type="submit" >Login</button>
                   <button class="btn btn-lg btn-secondary btn-block" formaction="./index.php?a=register" type="submit">Register</button>
             </form>';

$closeHtml = '
            </body>
            </html>';

$body = $loginForm;

$logout = '<header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a class="text-muted" href="./index.php">Logout</a>
                </div>
                </div>
          </header>
          ';

//-----------
// Actions
//-----------
switch ($action) {

    // Login
    case 'login':

        include("./scripts/user.php");

        $user = new User();
        $logged = $user->login($_POST['username'], $_POST['password']);

        if ($logged) {

            $buildHtml = new BuildHtml();
            $list = $buildHtml->glossariesList();
            $body = $list;
        }
        else {
            // show error on login
            echo "<p>error on login";
        }

    break;

    // Register
    case 'register':

        include("./scripts/user.php");
        $user = new User();
        $registered = $user->register($_POST['username'], $_POST['password']);

        if ($registered) {
                }
        else {
            // show error on registration
            echo "<p>error on registration";
        }

    break;

    // show Add Glossary form
    case 'showAddGlossary':

        include("./scripts/user.php");
        $buildHtml = new BuildHtml();
        $mainScreen = $buildHtml->mainScreen();
        $body = $mainScreen;

    break;

    // Add Glossary
    case 'addGlossary':

        $miniGlossary = new MiniGlossary();
        $miniGlossary->create($_POST['topic'], $_POST['term1'], $_POST['term2'], $_POST['term3'], $_POST['term4'], $_POST['term5']);

        $buildHtml = new BuildHtml();
        $mainScreen = $buildHtml->glossariesList();
        $body = $mainScreen;

    break;

    // show translations from a mini glossary
    case 'translations':

        $translation = new Translation();
        $miniGlossaryID = $_GET["mini"];

        $allTranslations = $translation->listTranslations($miniGlossaryID);

        $buildHtml = new BuildHtml();
        $mainScreen = $buildHtml->translationsList($allTranslations);
        $body = $mainScreen;

    break;

    // show Add Translation form
    case 'showAddTranslation':

        $miniGlossaryID = $_GET["mini"];

        $buildHtml = new BuildHtml();
        $mainScreen = $buildHtml->addTranslationForm($miniGlossaryID);
        $body = $mainScreen;

    break;

    // Add Translation
    case 'addTranslation':

        $translation = new Translation();
        $miniGlossaryID = $_GET["mini"];
        $term = $_GET["term"];
        $content = $_POST["content"];
        $language = $_POST["language"];

        $translation->addTranslation($miniGlossaryID, $term, $content, $language);

        $buildHtml = new BuildHtml();
        $mainScreen = $buildHtml->glossariesList();
        $body = $mainScreen;

    break;


    default:
    $logout = "";
    break;
}

$html = $head.$logout.$body.$closeHtml;

echo $html;

?>
