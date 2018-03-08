<?php
require_once 'custom/include/Google/lib/oauth_credentials.php';
require_once 'modules/Users/User.php';

class GoogleOauthHandler
{

    function getOauth2Credentials($credentials)
    {
        global $sugar_config;
        $oauthCredentials = new OauthCredentials(
            $credentials['access_token'],
            isset($credentials['refresh_token']) ? ($credentials['refresh_token']) : null,
            $credentials['created'],
            $credentials['expires_in'],
            $sugar_config['GOOGLE']['CLIENT_ID'],
            $sugar_config['GOOGLE']['CLIENT_SECRET']
        );

        return $oauthCredentials;
    }

    function saveOauth2Credentials($user_id, $jsonCredentials, $authCode)
    {
        $user = new User();
        $user->retrieve($user_id);
        if (empty($user->id)) {
            $GLOBALS['log']->fatal("Unable to fetch current user to save google auth");
            return false;
        } else {
            $user->gdrive_auth_code = $authCode;
            $user->gdrive_access_code = $jsonCredentials->access_token;
            $user->gdrive_refresh_code = isset($jsonCredentials->refresh_token) ? ($jsonCredentials->refresh_token) : '';
            $user->gdrive_auth_created = $jsonCredentials->created;
            $user->gdrive_auth_expires_in = $jsonCredentials->expires_in;
            if ($user->save()) {
                $GLOBALS['log']->fatal("Google Auth settings has been updated for user : " . $user->name . " to sync docs");
                return true;
            } else {
                $GLOBALS['log']->fatal("Unable to save Google Auth settings for user : " . $user->name . " to sync docs");
                return false;
            }
        }
    }

    function getStoredCredentials($user_id)
    {
        $credentials = array();
        $user = new User();
        $user->retrieve($user_id);
        if (empty($user->id)) {
            $GLOBALS['log']->fatal("Unable to fetch current user's google auth credentials");
            return false;
        } else {
            if (!empty($user->gdrive_refresh_code)) {
                $credentials = array(

                    'access_token' => $user->gdrive_access_code,
                    'refresh_token' => $user->gdrive_refresh_code,
                    'created' => $user->gdrive_auth_created,
                    'expires_in' => $user->gdrive_auth_expires_in,

                );
                return $credentials;
            } else {
                return false;
            }
        }
    }

}

?>