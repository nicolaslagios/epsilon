<?php
/**
 * Plugin Name: Epsilon Net - Epsilon Smart
 * Plugin URI: https://nicolaslagios.com
 * Description: A plugin for integrating Epsilon Net - Epsilon Smart with WooCommerce.
 * Version: 0.8
 * Author: Nicolas Lagios
 * Author URI: https://nicolaslagios.com
 */

/**
 * Add the plugin settings page as a submenu of WooCommerce in the admin menu.
 */
add_action('admin_menu', 'epsilon_net_epsilon_smart_add_settings_page');
function epsilon_net_epsilon_smart_add_settings_page() {
    add_submenu_page(
        'woocommerce',
        'Epsilon Net - Epsilon Smart Settings',
        'Epsilon Net - Epsilon Smart',
        'manage_options',
        'epsilon-net-epsilon-smart-settings',
        'epsilon_net_epsilon_smart_render_settings_page'
    );
}

/**
 * Add a settings link to the plugin's entry in the Plugins screen.
 */
add_filter('plugin_action_links', 'epsilon_net_epsilon_smart_add_settings_link', 10, 2);
function epsilon_net_epsilon_smart_add_settings_link($links, $file) {
    if (plugin_basename(__FILE__) === $file) {
        $url = admin_url('admin.php?page=epsilon-net-epsilon-smart-settings');
        $links[] = '<a href="' . esc_url($url) . '">' . __('Settings') . '</a>';
    }
    return $links;
}

/**
 * Render the plugin settings page.
 */
function epsilon_net_epsilon_smart_render_settings_page() {
    ?>
    <style>
    .span {
        color: red;
        font-weight: 600;
    }
</style>

<div class="wrap">
    <h1>Epsilon Net - Epsilon Smart v0.8 by Nicolas Lagios</h1>
	<p class="span">Important: You must add all information to all tabs</p>

    <ul class="nav nav-tabs" id="settings-tabs">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-license">Plugin License</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-epsilon-keys">Epsilon Smart Keys</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-woocommerce-keys">WooCommerce Keys</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#options">Options</a></li>
    </ul>

    <form method="post" action="options.php">
        <?php settings_fields('epsilon-net-epsilon-smart-settings-group'); ?>
        <?php do_settings_sections('epsilon-net-epsilon-smart-settings-group'); ?>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-license">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="key">Key</label></th>
                            <td>
                                <input name="key" type="text" id="key" value="<?php echo esc_attr(get_option('key')); ?>" class="regular-text">
                                <span class="span"> <- Add plugin key here (request one by emailing <a href="mailto:nick.lagios@gmail.com">nick.lagios@gmail.com</a>)</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="domain">Domain</label></th>
                            <td><input name="domain" type="text" id="domain" value="<?php echo esc_attr(get_option('domain', $_SERVER['HTTP_HOST'])); ?>" class="regular-text" readonly></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="tab-epsilon-keys">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="subscriptionKey">Subscription Key</label></th>
                            <td>
                                <input name="subscriptionKey" type="text" id="subscriptionKey" value="<?php echo esc_attr(get_option('subscriptionKey')); ?>" class="regular-text">
                                <span class="span"> <- Add your Epsilon Smart Subscription key here</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="email">Email</label></th>
                            <td>
                                <input name="email" type="text" id="email" value="<?php echo esc_attr(get_option('email')); ?>" class="regular-text">
                                <span class="span"> <- Add your Epsilon Smart Email Address here</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="password">Password</label></th>
                            <td>
                                <input name="password" type="password" id="password" value="<?php echo esc_attr(get_option('password')); ?>" class="regular-text">
                                <span class="span"> <- Add your Epsilon Smart Password here</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="tab-woocommerce-keys">
                <br>
                <a style="font-size:20px;" href="//<?php echo esc_attr(get_option('domain', $_SERVER['HTTP_HOST'])); ?>/wp-admin/admin.php?page=wc-settings&tab=advanced&section=keys&create-key=1" target="_blank">Click here to create your Woocommerce keys</a>
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="woocommerceConsumerKey">WooCommerce Consumer Key</label></th>
                            <td><input name="woocommerceConsumerKey" type="text" id="woocommerceConsumerKey" value="<?php echo esc_attr(get_option('woocommerceConsumerKey')); ?>" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="woocommerceConsumerSecret">WooCommerce Consumer Secret</label></th>
                            <td><input name="woocommerceConsumerSecret" type="text" id="woocommerceConsumerSecret" value="<?php echo esc_attr(get_option('woocommerceConsumerSecret')); ?>" class="regular-text"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="options">
                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="typosParastatikou">Τύπος Παραστατικού</label></th>
                            <td>
                                <select name="typosParastatikou" id="typosParastatikou" class="regular-text">
                                    <option value="false" <?php selected(get_option('typosParastatikou'), 'false'); ?>>Λιανική</option>
                                    <option value="true" <?php selected(get_option('typosParastatikou'), 'true'); ?>>Χονδρική</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="AFM" style="display: none;">
                            <th scope="row">Παρακαλώ συμπληρώστε το ΑΦΜ σας. Απαραίτητο.</th>
                            <td><input type="text" name="AFM" class="regular-text"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="plhrwmh">Τρόπος Πληρωμής</label></th>
                            <td>
                                <select name="plhrwmh" id="plhrwmh" class="regular-text">
                                    <option value="0" <?php selected(get_option('plhrwmh'), '0'); ?>>Μετρητά</option>
                                    <option value="1" <?php selected(get_option('plhrwmh'), '1'); ?>>Επί Πιστώσει</option>
                            		<option value="2" <?php selected(get_option('plhrwmh'), '2'); ?>>Πιστωτική Κάρτα</option>
                            		<option value="4" <?php selected(get_option('plhrwmh'), '4'); ?>>Paypal</option>
                            		<option value="5" <?php selected(get_option('plhrwmh'), '5'); ?>>Τραπεζική Κατάθεση</option>
                                </select>
                            	<span class="span"> <- Προς το παρόν το ορίζετε χειροκίνητα. Σύντομα θα γίνεται αυτόματα δυναμικά.</span>
                            </td>
                        </tr>
						<tr id="onomamethodoyplhrwmhs">
                            <th scope="row">Όνομα μεθόδου πληρωμής. Όνομα κάρτας όπως είναι καταχωρημένη, πχ Visa</th>
                            <td><input type="text" name="onomamethodoyplhrwmhs" value="<?php echo esc_attr(get_option('onomamethodoyplhrwmhs')); ?>" class="regular-text">
                            <span class="span"> <- Προς το παρόν αν πολλαπλές κάρτες, μπορείτε να γράψετε μόνο ένα όνομα, πχ Visa. Θα το βρείτε στην συνδρομή σας epsilon smart</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="kathestos">Καθεστός ΦΠΑ</label></th>
                            <td>
                                <select name="kathestos" id="kathestos" class="regular-text">
                                    <option value="0" <?php selected(get_option('kathestos'), '0'); ?>>Κανονικό 24%</option>
                                    <option value="1" <?php selected(get_option('kathestos'), '1'); ?>>Μειωμένο</option>
                            		<option value="false" <?php selected(get_option('kathestos'), 'false'); ?>>Απαλλασσόμενο</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="kwdikosproiontos">
                            <th scope="row">Κωδικός προιόντος στο Epsilon Smart όπου θα αντιστοιχηθεί το παραστατικό</th>
                            <td><input type="text" name="kwdikosproiontos" value="<?php echo esc_attr(get_option('kwdikosproiontos')); ?>" class="regular-text">
                            <span class="span"> <- Προς το παρόν βγαίνουν όλα σε ένα. Σύντομα θα μπορείτε περισσότερα.</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="kentriko_nomisma">Νόμισμα καταστήματος</label></th>
                            <td>
                                <select name="kentriko_nomisma" id="kentriko_nomisma" class="regular-text">
                                    <option value="EUR" <?php selected(get_option('kentriko_nomisma'), 'EUR'); ?>>EUR</option>
                                    <option value="USD" <?php selected(get_option('kentriko_nomisma'), 'USD'); ?>>USD</option>
                                </select>
                            	<span class="span"> <- Αν επιλέξετε οποιοδήποτε άλλο εκτός από EUR, θα ενεργοποιηθεί αυτόματα μηχανισμός ισοτιμίας</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php submit_button(); ?>
    </form>
</div>

<!-- Include the Bootstrap CSS and JavaScript -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
    // Initialize the Bootstrap tabs
    $(function() {
        $('#settings-tabs a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
	// Handle AFM dropdown change event
    $('#typosParastatikou').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue === 'true') {
            $('#AFM').show();
        } else {
            $('#AFM').hide();
        }
    });
</script>
<?php

}

/* Register the plugin settings. */
add_action('admin_init', 'epsilon_net_epsilon_smart_register_settings');
function epsilon_net_epsilon_smart_register_settings() {
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'key'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'subscriptionKey'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'email'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'password'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'domain'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'woocommerceConsumerKey'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'woocommerceConsumerSecret'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'typosParastatikou'
    );
    register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'AFM'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'plhrwmh'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'kathestos'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'kwdikosproiontos'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'kentriko_nomisma'
    );
	register_setting(
        'epsilon-net-epsilon-smart-settings-group',
        'onomamethodoyplhrwmhs'
    );
}

/**
 * Add the timologio function to the woocommerce_order_status_completed action.
 */
add_action('woocommerce_order_status_completed', 'epsilon_net_epsilon_smart_timologio');
add_action('woocommerce_order_status_completed', 'epsilon_net_epsilon_smart_timologio');
function epsilon_net_epsilon_smart_timologio($order_id) {
    $key = get_option('key');
    $subscriptionKey = get_option('subscriptionKey');
    $email = get_option('email');
    $password = get_option('password');
    $domain = get_option('domain', $_SERVER['HTTP_HOST']);
    $woocommerceConsumerKey = get_option('woocommerceConsumerKey');
    $woocommerceConsumerSecret = get_option('woocommerceConsumerSecret');
	$typosParastatikou = get_option('typosParastatikou');
	if ($typosParastatikou == "true") {$AFM = get_option('AFM');}
	$plhrwmh = get_option('plhrwmh');
	if (get_option('kathestos') == "false") {
    	$kathestos = get_option('kathestos');
    	$kathestostype = "0";
    } else {
    	$kathestos = "true";
    	$kathestostype = get_option('kathestos');
    }
	$kwdikosproiontos = get_option('kwdikosproiontos');
	$kentriko_nomisma = get_option('kentriko_nomisma');
	$onomamethodoyplhrwmhs = get_option('onomamethodoyplhrwmhs');

    $url = 'https://dev.maxservices.gr/bridges/epsilonnet/epsilonsmart/?';
    $url .= 'key=' . urlencode($key);
    $url .= '&method=remote';
    $url .= '&subscriptionKey=' . urlencode($subscriptionKey);
    $url .= '&email=' . urlencode($email);
    $url .= '&password=' . urlencode($password);
    $url .= '&domain=' . urlencode($domain);
    $url .= '&woocommerceConsumerKey=' . urlencode($woocommerceConsumerKey);
    $url .= '&woocommerceConsumerSecret=' . urlencode($woocommerceConsumerSecret);
	$url .= '&typosParastatikou=' . urlencode($typosParastatikou);
	if ($typosParastatikou == "true") { $url .= '&AFM=' . urlencode($AFM); }
	$url .= '&plhrwmh=' . urlencode($plhrwmh);
	$url .= '&kathestos=' . urlencode($kathestos);
	$url .= '&kathestostype=' . urlencode($kathestostype);
	$url .= '&kwdikosproiontos=' . urlencode($kwdikosproiontos);
	$url .= '&kentriko_nomisma=' . urlencode($kentriko_nomisma);
	$url .= '&onomamethodoyplhrwmhs=' . urlencode($onomamethodoyplhrwmhs);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    curl_close($ch);
}
