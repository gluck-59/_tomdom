<?php
    echo __FILE__;
    require_once __DIR__.'/vendor/autoload.php';

    session_start();

    $client = new Google_Client();
    $client->setAuthConfigFile('/Users/gluck/Sites/Helga.ru/config/gluck-demo.json');
echo 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
    $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube.readonly',
    ]);
    $client->setApprovalPrompt('force');
    $client->setAccessType("offline");

    if (!isset($_GET['code'])) {
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    } else {
        $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }