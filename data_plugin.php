<?php
/**
 * Plugin name: Data Plugin
 * Description: Plugin for transferring Data
 * Version: 1.0.0
 * Text Domain: data_plugin
 * Author: CC dev
 */

// Include Composer-generated autoload file

require_once plugin_dir_path(__FILE__) . './vendor/autoload.php';

class DataPlugin {
    private $collection;

    public function __construct() {
        add_action('admin_menu', array($this, 'linkOption'));
        $this->init_mongo();
    }

    private function init_mongo() {
        $uri = 'mongodb+srv://chrislpoy:HxZ7j5SoqeDmlPCF@clpdb.io2p2g4.mongodb.net/';
        $this->collection = new MongoDB\Driver\Manager($uri);
    }

    public function linkOption() {
        add_options_page('Plugin to API', 'Plugin to API Options', 'manage_options', 'data_plugin_options', array($this, 'wporg_options_page'));
    }

    public function wporg_options_page() {
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->process_form_data();
        }

        $query = new MongoDB\Driver\Query([]);
        $results = $this->executeQuery($query);

        // Display the retrieved data
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Plugin to API', 'data_plugin'); ?></h1>

            <form method="post" action="">
                <label for="name"><?php esc_html_e('API name:', 'data_plugin'); ?></label>
                <input type="text" name="name" required>
                <br>

                <label for="ID"><?php esc_html_e('Unique ID:', 'data_plugin'); ?></label>
                <input type="text" name="ID" required>
                <br>

                <label for="url"><?php esc_html_e('Base URL:', 'data_plugin'); ?></label>
                <input type="url" name="url" required>
                <br>

                <?php submit_button(__('Submit', 'data_plugin')); ?>
            </form>

            <h2><?php esc_html_e('Stored Data', 'data_plugin'); ?></h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                <tr>
                    <th><?php esc_html_e('API name', 'data_plugin'); ?></th>
                    <th><?php esc_html_e('Unique ID', 'data_plugin'); ?></th>
                    <th><?php esc_html_e('Base URL', 'data_plugin'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td>' . esc_html($result->name) . '</td>';
                    echo '<td>' . esc_html($result->id) . '</td>';
                    echo '<td>' . esc_url($result->url) . '</td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private function process_form_data() {
        // Get the submitted values
        $name = sanitize_text_field($_POST['name']);
        $ID = sanitize_text_field($_POST['ID']);
        $url = esc_url($_POST['url']);

        // You should insert data using MongoDB\Driver\BulkWrite
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert([
            'name' => $name,
            'id' => $ID,
            'url' => $url
        ]);

        // Use the executeBulkWrite method with the MongoDB\Driver\Manager
        try {
            $this->collection->executeBulkWrite('INFO3604wpAPI.wpAPI', $bulk);
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, display a user-friendly message)
            echo 'Error: ' . $e->getMessage();
        }
    }

    private function executeQuery($query) {
        // Execute the query and return the results
        return $this->collection->executeQuery('INFO3604wpAPI.wpAPI', $query);
    }
}

$data_plugin = new DataPlugin();
