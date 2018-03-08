<?php
require_once 'custom/include/Google/google-api-php-client/src/Google_Client.php';
require_once 'custom/include/Google/lib/GoogleOauthHandler.php';

try {
    $auth_handler = new GoogleOauthHandler();
    global $sugar_config, $current_user;
    $client = new Google_Client();

    $client->setClientId($sugar_config['GOOGLE']['CLIENT_ID']);
    $client->setClientSecret($sugar_config['GOOGLE']['CLIENT_SECRET']);
    $client->setRedirectUri($sugar_config['GOOGLE']['REDIRECT_URI']);
    $client->setScopes($sugar_config['GOOGLE']['SCOPES']);
    $client->setState($sugar_config['GOOGLE']['STATE']);

    $authUrl = $client->createAuthUrl();
    $authUrl .= "&user_id=" . $current_user->gmail_id;//creating auth url according to current setting
    if (isset($_GET['code'])) {

        $jsonCredentials = json_decode($client->authenticate());
        if (!empty($jsonCredentials) && $auth_handler->saveOauth2Credentials($current_user->id, $jsonCredentials, $_GET['code'])) {
            //show message authentication done and redirect user where you want
            echo "You have done ....</a>";
            global $current_user;
            SugarApplication::redirect("index.php?module=Users&action=DetailView&record=" . $current_user->id);
        } else {
            //show message authentication fail and redirect user to auth url so that auth code can be grabbed once again
            echo "Error occurred please <a href='$authUrl'>try again</a>";
        }
    } else {
        if (isset($_GET['error'])) {
            echo "Error occurred please <a href='$authUrl'>try again</a>";
        } else {
            //Request authorization
            $GLOBALS['log']->fatal("redirecting to ....");
            $script = "<script type='text/javascript'>";
            $script .= "window.open('$authUrl');";
            $script .= "parent.SUGAR.App.router.navigate(parent.SUGAR.App.router.buildRoute('Home'),{trigger: true});";
            $script .= "</script>";
            echo $script;
            die();
        }
    }
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'invalid_grant') !== false) {
        echo "Already, you have authorized.";
        SugarApplication::redirect("index.php");
    } else {
        echo "Error occurred, try later on...";
    }
    $GLOBALS['log']->fatal("Exception Occurred: " . $e->getMessage());
}
?>
