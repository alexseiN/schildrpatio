<?php


/**
 * Google ReCAPTURE v3 Helper
 * @docs https://developers.google.com/recaptcha/docs/v3
 *
 * INSTALLATION INSTRUCTIONS
 * 1. Register account and website with Google Recaptcha to receive a Site Key and Secret Key - https://www.google.com/recaptcha/admin
      NOTE: Ensure you select reCAPTCHA v3 .. NOT ..  reCAPTCHA v2
* 2. Copy this file into the application/helpers directory
 * 2. Copy the Site Key and Secret Key to the constants below
 * 3. Edit config/autoload.php  - $autoload['helper'] to include 'recaptcha'
 * 4. add frontend code before the </head> tag
<style>
    .grecaptcha-badge{visibility: hidden}
</style>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'form_submission'}).then(function(token) {
            document.querySelector('.g-recaptcha-response').value = token;
        });
    });
</script>
 * 5. add hidden field to each form
<input type="hidden" class="g-recaptcha-response" name="g-recaptcha-response">
 *
 * 6. in your server side form handler code use (your $_POST variable may vary):
 *    $score = get_recapture_score($_POST['g-recaptcha-response']);
 *
 *    if($score < RECAPTCHA_ACCEPTABLE_SPAM_SCORE){
 *        // return an error of your choosing
 *    }
 *
 */
defined('RECAPTCHA_SITE_KEY')                 OR define('RECAPTCHA_SITE_KEY', '6LfCdtgaAAAAALBd-tKVQvclyP_iasnO_7pOeyIl');
defined('RECAPTCHA_SITE_SECRET')              OR define('RECAPTCHA_SITE_SECRET', '6LfCdtgaAAAAALtEpKIevQbyRt2sgLlZlYEhffzz');
defined('RECAPTCHA_ACCEPTABLE_SPAM_SCORE')    OR define('RECAPTCHA_ACCEPTABLE_SPAM_SCORE', 0.5);


if(!function_exists('get_recapture_score')) {
    /**
     *
     * Returns a float from 0 - 1 indicating the likelihood that the request is a from a human
     * 0 is considered a robot
     * 1 is considered a human
     *
     * @param $secret
     * @return float
     */
    function get_recapture_score($secret){
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $request = $url .'?secret='.RECAPTCHA_SITE_SECRET.'&response='.$secret.'';
        $response = file_get_contents($request);
        $response = json_decode($response);

        // handle any errors
        if($response->success == false){
            foreach($response->{'error-codes'} as $code){
                switch ($code){
                    case 'missing-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is missing. ' . $request);
                        break;
                    case 'invalid-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is invalid or malformed. '. $request);
                        break;
                    case 'missing-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is missing. '. $request);
                        break;
                    case 'invalid-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is invalid or malformed. ' . $request);
                        break;
                    case 'bad-request':
                        log_message('error', 'RECAPTCHA: The request is invalid or malformed. ' . $request);
                        break;
                    case 'timeout-or-duplicate':
                        log_message('error', 'RECAPTCHA: The response is no longer valid: either is too old or has been used previously.');
                        break;
                    default:
                        log_message('error', 'RECAPTCHA: Unknown error');
                }
            }
            return 0; // treat it as spam?
        }

        return $response->score;
    }
}