<?php
/**
 * Example of retrieving the products list using Customer account via Magento REST API. OAuth authorization is used
 * Preconditions:
 * 1. Install php oauth extension
 * 2. If you were authorized as an Admin before this step, clear browser cookies for 'yourhost'
 * 3. Create at least one product in Magento and enable it for viewing in the frontend
 * 4. Configure resource permissions for Customer REST user for retrieving all product data for Customer
 * 5. Create a Consumer
 */
// $callbackUrl is a path to your file with OAuth authentication example for the Customer user
$callbackUrl = "http://www.skincarebyalana.com/oauth_customer.php";
$temporaryCredentialsRequestUrl = "http://www.skincarebyalana.com/oauth/initiate?oauth_callback=" . urlencode($callbackUrl);
$customerAuthorizationUrl = 'http://www.skincarebyalana.com/oauth/authorize';
$accessTokenRequestUrl = 'http://www.skincarebyalana.com/oauth/token';
$apiUrl = 'http://www.skincarebyalana.com/api/rest';
$consumerKey = 'iupt90m61nrw9y63on1u14ixfz750pny';
$consumerSecret = 'zti9llqjeldixop7ajqjfk1d6d2oswbg';

session_start();
if (!isset($_GET['oauth_token']) && isset($_SESSION['state']) && $_SESSION['state'] == 1) {
    $_SESSION['state'] = 0;
}
try {
    $authType = ($_SESSION['state'] == 2) ? OAUTH_AUTH_TYPE_AUTHORIZATION : OAUTH_AUTH_TYPE_URI;
    $oauthClient = new OAuth($consumerKey, $consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, $authType);
    $oauthClient->enableDebug();

    if (!isset($_GET['oauth_token']) && !$_SESSION['state']) {
        $requestToken = $oauthClient->getRequestToken($temporaryCredentialsRequestUrl);
        $_SESSION['secret'] = $requestToken['oauth_token_secret'];
        $_SESSION['state'] = 1;
        header('Location: ' . $customerAuthorizationUrl . '?oauth_token=' . $requestToken['oauth_token']);
        exit;
    } else if ($_SESSION['state'] == 1) {
        $oauthClient->setToken($_GET['oauth_token'], $_SESSION['secret']);
        $accessToken = $oauthClient->getAccessToken($accessTokenRequestUrl);
        $_SESSION['state'] = 2;
        $_SESSION['token'] = $accessToken['oauth_token'];
        $_SESSION['secret'] = $accessToken['oauth_token_secret'];
        header('Location: ' . $callbackUrl);
        exit;
    } else {
        $oauthClient->setToken($_SESSION['token'], $_SESSION['secret']);

        $resourceUrl = "$apiUrl/products";
        $oauthClient->fetch($resourceUrl, array(), 'GET', array('Content-Type' => 'application/json'));
        $productsList = json_decode($oauthClient->getLastResponse());
        print_r($productsList);
    }
} catch (OAuthException $e) {
    print_r($e->getMessage());
    echo "<br/>";
    print_r($e->lastResponse);
}