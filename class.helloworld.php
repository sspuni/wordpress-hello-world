<?php
/**
 * File class.HelloWorld.php
 * php version 7.4.2
 * 
 * @category File
 * @package  HelloWorld
 * @author   Sandeep Singh <sandeep.singh.pooni@gmail.com>
 * @license  GPLv2 <https://www.gnu.org/licenses/gpl-2.0.html>
 * @link     n/a
 */

/**
 * HelloWorld class to handle all plugin functions
 * 
 * @category Class
 * @package  HelloWorld
 * @author   Sandeep Singh <sandeep.singh.pooni@gmail.com>
 * @license  GPLv2 <https://www.gnu.org/licenses/gpl-2.0.html>
 * @link     n/a
 */
class HelloWorld
{
    // Keep tracks whether the plugin has been initialised or not
    private static $_initialised = false;

    /**
     * Handles initialisation logic
     * 
     * @static
     * @return void
     */
    public static function init()
    {
        if (!self::$_initialised) {
            self::_initHooks();
        }
    }

    /**
     * Handles attaching necessary hooks
     * 
     * @static
     * @return void
     */
    private static function _initHooks()
    {
        self::$_initialised = true;

        wp_register_script(
            "hello-world",
            plugin_dir_url(__FILE__)."assets/hello-world.js"
        );

        add_action("wp_head", array("HelloWorld", "checkForNewestPost"));
    }

    /**
     * Executes on "the_post" hooks
     * Checks whether the current post is newest or not
     * 
     * @static
     * @return void
     */
    public static function checkForNewestPost()
    {
        $latest_post = get_posts(
            [
            'numberposts' => 1,
            'fields' => 'ids'
            ]
        );
        
        $postID = get_queried_object_id();
        $post = get_post($postID);
        
        if (in_array($post->ID, $latest_post)) {
            wp_enqueue_script('hello-world');
            wp_add_inline_script(
                'hello-world',
                'HelloWorld("'.$post->post_title.'")'
            );
        }
    }

    /**
     * Handles plugin activation
     *
     * @static
     * @return void
     */
    public static function pluginActivation()
    {
        $wpVersion = $GLOBALS['wp_version'];
        if (version_compare($wpVersion, HELLOWORLD__MINIMUM_WP_VERSION, '<')) {
            load_plugin_textdomain('hello-world');

            $message = '<strong>' . 
                sprintf(
                    esc_html__(
                        'HelloWorld %s requires WordPress %s or higher.',
                        'hello-world'
                    ),
                    HELLOWORLD_VERSION,
                    HELLOWORLD__MINIMUM_WP_VERSION
                ) . 
                '</strong> ' . 
                sprintf(
                    __(
                        'Please <a href="%1$s">upgrade WordPress</a> to new version',
                        'hello-world'
                    ),
                    'https://codex.wordpress.org/Upgrading_WordPress'
                );

            HelloWorld::_bailOnActivation($message);
        }
    }

    /**
     * Handles plugin deactivation
     *
     * @static
     * @return void
     */
    public static function pluginDeactivation()
    {
        // TODO: add deactivation logic
    }


    /**
     * Handle activation errors
     * 
     * @param $message    Message to show user
     * @param $deactivate Whether to deactivate plugin
     * 
     * @return void
     */
    private static function _bailOnActivation($message, $deactivate = true)
    {
        ?>
        <!doctype html>
        <html>

        <head>
            <meta charset="<?php bloginfo('charset'); ?>" />
            <style>
                * {
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    font-family: Verdana, Arial, sans-serif;
                }

                p {
                    margin-top: 1em;
                    font-size: 18px;
                }
            </style>
        </head>

        <body>
            <p><?php echo esc_html($message); ?></p>
        </body>

        </html>
        <?php
        if ($deactivate) {
            $plugins = get_option('active_plugins');
            $akismet = plugin_basename(HELLOWORLD__PLUGIN_DIR . 'hello-world.php');
            $update  = false;
            foreach ($plugins as $i => $plugin) {
                if ($plugin === $akismet) {
                    $plugins[$i] = false;
                    $update = true;
                }
            }

            if ($update) {
                update_option('active_plugins', array_filter($plugins));
            }
        }
        exit;
    }
}
