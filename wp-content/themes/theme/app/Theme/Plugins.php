<?php

namespace Theme\Theme;

use Dxw\Iguana\Registerable;

class Plugins implements Registerable
{
    protected array $required;
    protected string $path_to_wordpress;

    public function __construct(array $required = [])
    {
        $this->required = $required;
        $this->path_to_wordpress = ABSPATH;
    }

    public function register() : void
    {
        add_action('after_switch_theme', [$this, 'checkDependencies']);
    }

    public function checkDependencies() : void
    {
        $pluginsToActivate = $this->findPluginsToActivate();
        if (empty($pluginsToActivate)) {
            return;
        }
        if (!function_exists('get_plugin_data')) {
            require_once($this->path_to_wordpress . 'wp-admin/includes/plugin.php');
        }
        array_map([$this, 'addNotice'], $pluginsToActivate);
    }

    public function addNotice(string $plugin) : void
    {
        $pluginData = get_plugin_data(WP_PLUGIN_DIR.'/'.$plugin);
        $pluginName = !empty($pluginData['Name']) ? $pluginData['Name'] : $plugin; ?>
        <div class="notice notice-warning">
            <p><strong><?php echo esc_html($pluginName) ?></strong> is a required plugin and is not active.
                You must activate it for this theme to work.
                <a href="<?php echo admin_url('plugins.php') ?>">Visit plugins page</a>
            </p>
        </div>
        <?php
    }

    private function findPluginsToActivate() : array
    {
        $pluginsToActivate = array_diff(
            $this->required,
            apply_filters('active_plugins', get_option('active_plugins'))
        );
        return $pluginsToActivate;
    }
}
