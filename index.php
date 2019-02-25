<?php
include("./scripts/network.php");
include("./scripts/buildHtml.php");

$loggedUsername = $_POST["username"];

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
               <body>
               ';

$loginForm = '
               <form class="form-signin" action="./index.php?a=login" method="post">
                    <h1 class="h3 mb-3 font-weight-normal text-center">ProZ.com test</h1>
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


$logout = '			<div class="fixed-top">
				<div class="text-right">
					<p>Welcome, '.$loggedUsername.'. <a href="./index.php">Logout</a></p>
				</div>
			</div>';

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
			$result = "";
        }
        else {
            // show error on login
			$result = '
						<div class="fixed-bottom">
							<div class="alert alert-danger" role="alert">
								<strong>Invalid credentials!</strong> Please check again your username/password.
							</div>
						</div>';
			$logout = "";
        }
		$body = $body.$result;

    break;

    // Register
    case 'register':

        include("./scripts/user.php");
        $user = new User();
        $registered = $user->register($_POST['username'], $_POST['password']);

        if ($registered) {

			$result = '
			<div class="fixed-bottom">
				<div class="alert alert-success" role="alert">
					<strong>Registration done!</strong> Welcome <strong>'.$_POST["username"].'</strong>. You can now login.
				</div>
			</div>';
		}
        else {
            // show error on registration
			$result = '
			<div class="fixed-bottom">
				<div class="alert alert-danger" role="alert">
					<strong>Registration error!</strong> Username <strong>'.$_POST["username"].'</strong> is already registered. Please choose a different one.
				</div>
			</div>';
        }
		$logout = "";
		$body = $body.$result;

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
