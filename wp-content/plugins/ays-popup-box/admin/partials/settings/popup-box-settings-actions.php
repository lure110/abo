<?php
class Ays_PopupBox_Settings_Actions {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function store_data($data){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        if( isset($data["settings_action"]) && wp_verify_nonce( $data["settings_action"], 'settings_action' ) ){
            $success = 0;
            
            $ays_pb_sound = isset($data['ays_pb_sound']) ? $data['ays_pb_sound'] : '';
            $ays_pb_close_sound = isset($data['ays_pb_close_sound']) ? $data['ays_pb_close_sound'] : '';

            $options = array(
                "ays_pb_sound"       => $ays_pb_sound,
                "ays_pb_close_sound" => $ays_pb_close_sound,
            );
            
            $result = $this->ays_update_setting('options', json_encode($options));
            if ($result) {
                $success++;
            }

            $message = "saved";
            if($success > 0){
                $tab = "";
                if(isset($data['ays_pb_tab'])){
                    $tab = "&ays_pb_tab=".$data['ays_pb_tab'];
                }
                $url = admin_url('admin.php') . "?page=ays-pb-settings" . $tab . '&status=' . $message . $del_stat;
                wp_redirect( $url );
            }
        }
        
    }

    public function get_db_data(){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        $sql = "SELECT * FROM ".$settings_table;
        $results = $wpdb->get_results($sql, ARRAY_A);
        if(count($results) > 0){
            return $results;
        }else{
            return array();
        }
    }

    public function ays_get_setting($meta_key){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        $sql = "SELECT meta_value FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
        $result = $wpdb->get_var($sql);
        if($result != ""){
            return $result;
        }
        return false;
    }

    public function ays_add_setting($meta_key, $meta_value, $note = "", $options = ""){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        $result = $wpdb->insert(
            $settings_table,
            array(
                'meta_key'    => $meta_key,
                'meta_value'  => $meta_value,
                'note'        => $note,
                'options'     => $options
            ),
            array( '%s', '%s', '%s', '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }

    public function ays_update_setting($meta_key, $meta_value, $note = null, $options = null){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        $value = array(
            'meta_value'  => $meta_value,
        );
        $value_s = array( '%s' );
        if($note != null){
            $value['note'] = $note;
            $value_s[] = '%s';
        }
        if($options != null){
            $value['options'] = $options;
            $value_s[] = '%s';
        }
        $result = $wpdb->update(
            $settings_table,
            $value,
            array( 'meta_key' => $meta_key, ),
            $value_s,
            array( '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }

    public function ays_delete_setting($meta_key){
        global $wpdb;
        $settings_table = $wpdb->prefix . "ays_pb_settings";
        $wpdb->delete(
            $settings_table,
            array( 'meta_key' => $meta_key ),
            array( '%s' )
        );
    }


    public function pb_settings_notices($status){

        if ( empty( $status ) )
            return;

        if ( 'saved' == $status )
            $updated_message = esc_html( __( 'Changes saved.', $this->plugin_name ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'PopupBox attribute .', $this->plugin_name ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'PopupBox attribute deleted.', $this->plugin_name ) );

        if ( empty( $updated_message ) )
            return;

        ?>
        <div class="notice notice-success is-dismissible">
            <p> <?php echo $updated_message; ?> </p>
        </div>
        <?php
    }

}