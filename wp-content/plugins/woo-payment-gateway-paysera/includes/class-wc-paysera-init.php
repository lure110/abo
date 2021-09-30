<?php
defined('ABSPATH') or exit;

class Wc_Paysera_Init
{
    protected $errors;

    const PAYSERA_DOC_LINK = 'https://developers.paysera.com/en/checkout/basic';
    
    const ADMIN_SETTINGS_LINK = 'admin.php?page=wc-settings&tab=checkout&section=paysera';

    const QUALITY_SIGN_JS = 'https://bank.paysera.net/new/js/project/wtpQualitySigns.js';

    const ERRORS_GLUE_STRING = PHP_EOL;

    public function __construct()
    {
        $this->errors = array();
    }

    public function hooks()
    {
        add_action('plugins_loaded', array($this, 'loadPayseraGateway'));

        add_action('admin_notices', array($this, 'displayAdminNotices'));

        add_filter('woocommerce_payment_gateways', array($this, 'addPayseraGatewayMethod'));

        add_filter(
            'plugin_action_links_'.WCGatewayPayseraPluginPath.'/paysera.php',
            array($this, 'addPayseraGatewayActionLinks')
        );

        add_action('wp_head', [$this, 'addMetaTags']);

        add_action('wp_head', [$this, 'addQualitySign']);
    }

    public function loadPayseraGateway()
    {
        load_plugin_textdomain(
            'woo-payment-gateway-paysera',
            FALSE,
            WCGatewayPayseraPluginPath. '/languages/'
        );

        if(!class_exists('woocommerce')) {
            $this->addError('WooCommerce is not active');
            return false;
        }

        require_once "class-wc-paysera-gateway.php";

        return true;
    }

    public function getInstallErrors()
    {
        $messages = null;

        $messages_prefix = __('WooCommerce Payment Gateway - Paysera', 'woo-payment-gateway-paysera');

        $errors = $this->getErrors();

        $errorsSplitString = $this::ERRORS_GLUE_STRING;
        $messages = implode($errorsSplitString, $errors);

        return array(
            'prefix'   => $messages_prefix,
            'messages' => $messages
        );
    }

    public function displayAdminNotices()
    {
        $notices = $this->getInstallErrors();

        if (!empty($notices['messages'])) {
            echo '<div class="error"><p><b>'.$notices['prefix'].': </b><br>'.$notices['messages'].'</p></div>';
        }
    }

    public function addPayseraGatewayMethod($methods)
    {
        $methods[] = 'WC_Paysera_Gateway';

        return $methods;
    }

    public function addPayseraGatewayActionLinks($links)
    {
        wp_enqueue_style('custom-frontend-style', WCGatewayPayseraPluginUrl . 'assets/css/paysera.css');

        $adminSettingsLink = admin_url($this::ADMIN_SETTINGS_LINK);

        $htmlDocumentationLink = '<a href="' . $this::PAYSERA_DOC_LINK . '" target="_blank">Docs</a>';

        if (class_exists('woocommerce')) {
            $adminSettingsTranslations = __('Main Settings', 'woo-payment-gateway-paysera');

            $htmlSettingsLink = '<a href="' . $adminSettingsLink . '">' . $adminSettingsTranslations . '</a>';
        } else {
            $htmlSettingsLink = '<a class="paysera-error-link" ">WooCommerce is not active</a>';
        }

        array_unshift($links, $htmlSettingsLink, $htmlDocumentationLink);

        return $links;
    }

    public function addMetaTags()
    {
        $settings = get_option('woocommerce_paysera_settings');

        if (
            (isset($settings['enableOwnershipCode']) && isset($settings['ownershipCode']))
            && ($settings['enableOwnershipCode'] === 'yes')
        ) {
            echo '<meta name="verify-paysera" content="' . $settings['ownershipCode'] . '">';
        }
    }

    public function addQualitySign()
    {
        $settings = get_option('woocommerce_paysera_settings');

        if (isset($settings['enableQualitySign']) && ($settings['enableQualitySign'] === 'yes')) {
            echo $this->buildQualitySignScript($settings['projectid'] );
        }
    }

    /**
     * @param array $errors
     *
     * @return $self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param string $errorText
     * @param string $pluginPath
     *
     * @return $self
     */
    public function addError($errorText, $pluginPath = 'woo-payment-gateway-paysera')
    {
        $error = __($errorText, $pluginPath);

        $this->errors[] = $error;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    private function getLang()
    {
        $lang = explode('_', get_locale());

        return $lang[0];
    }

    /**
     * @param int $projectId
     * @return string
     */
    private function buildQualitySignScript($projectId)
    {
        $script = '<script type="text/javascript" charset="utf-8">
                    let wtpQualitySign_projectId = "' . $projectId .'";
                    let wtpQualitySign_language = "' . $this->getLang() . '";
                  </script>'
        ;

        $script .= '<script src="' . $this::QUALITY_SIGN_JS . '" type="text/javascript" charset="utf-8"></script>';

        return $script;
    }
}
