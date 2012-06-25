<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'openid.php';


/*
$_GET = array(
 'openid_ns' => 'http://specs.openid.net/auth/2.0',
 'openid_mode' => 'id_res',
 'openid_op_endpoint' => 'https://www.google.com/accounts/o8/ud',
 'openid_response_nonce' => '2012-05-31T07:31:22Z4en4AoS6MDJppQ',
 'openid_return_to' => 'http://cincihomeless.local/lightopenid/example-google.php?login',
 'openid_assoc_handle' => 'AMlYA9UH1YsTcjo0DDADQOmDnUr1rRrS_XW52LPpAfqAfTm7-WYYYo3t',
 'openid_signed' => 'op_endpoint,claimed_id,identity,return_to,response_nonce,assoc_handle,ns.ext1,ext1.mode,ext1.type.contact_email,ext1.value.contact_email',
 'openid_sig' => '0sOw9N076YyXopwGvrQcRKgQqWw=',
 'openid_identity' => 'https://www.google.com/accounts/o8/id?id=AItOawlckXIIshtZGGaVo2GHg_5T_lrvCNZHwbM',
 'openid_claimed_id' => 'https://www.google.com/accounts/o8/id?id=AItOawlckXIIshtZGGaVo2GHg_5T_lrvCNZHwbM',
 'openid_ns_ext1' => 'http://openid.net/srv/ax/1.0',
 'openid_ext1_mode' => 'fetch_response',
 'openid_ext1_type_contact_email' => 'http://axschema.org/contact/email',
 'openid_ext1_value_contact_email' => 'joe.purcell@zipscene.com'
 );
*/


$openid = new LightOpenID('openid.local/example-google.php');


/*
 * $openid->identity = 'https://www.google.com/accounts/o8/id?id=AItOawkYylQWgcBE20K49Uca-2-SDn8E6SKV4C0';
 */

try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('openid.local/example-google.php');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->required = array('namePerson/friendly', 'contact/email');
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            header('Location: ' . $openid->authUrl());
        }
?>
<form action="?login" method="post">
    <button>Login with Google</button>
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
