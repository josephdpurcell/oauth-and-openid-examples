<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'openid.php';



$openid = new LightOpenID('openid.local/example-yahoo.php');

//$openid->identity = 'https://me.yahoo.com/a/B9Z0.J58z97WOkpIl6mkPbVilUI8gzHcJ5hX';

try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('openid.local/example-yahoo.php');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            //$openid->required = array('email','firstname','lastname');
            $openid->required = array('namePerson/friendly', 'contact/email');
            $openid->identity = 'http://open.login.yahooapis.com/openid20/www.yahoo.com/xrds';
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post">
    <button>Login with Yahoo</button>
</form>
<?php
    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
        var_dump($openid->getAttributes());
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
