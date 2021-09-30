<?php
$actions = $this->settings_obj;

if (isset($_REQUEST['ays_submit'])) {
    $actions->store_data($_REQUEST);
}
if (isset($_GET['ays_pb_tab'])) {
    $ays_pb_tab = sanitize_text_field($_GET['ays_pb_tab']);
} else {
    $ays_pb_tab = 'tab1';
}

if(isset($_GET['action']) && $_GET['action'] == 'update_duration'){
    $actions->update_duration_data();
}
$loader_iamge = "<span class='display_none ays_quiz_loader_box'><img src=". AYS_PB_ADMIN_URL ."/images/loaders/loading.gif></span>";
$db_data = $actions->get_db_data();

$options = ($actions->ays_get_setting('options') === false) ? array() : json_decode($actions->ays_get_setting('options'), true);

$ays_pb_sound = (isset($options['ays_pb_sound']) && $options['ays_pb_sound'] != '') ? $options['ays_pb_sound'] : '';
$ays_pb_close_sound = (isset($options['ays_pb_close_sound']) && $options['ays_pb_close_sound'] != '') ? $options['ays_pb_close_sound'] : '';

global $wpdb;

//opening src from wp posts
$sound_src = "SELECT guid FROM {$wpdb->posts} WHERE guid='$ays_pb_sound'";
$sound_src_result = $wpdb->get_results($sound_src, "ARRAY_A");

//closing src from wp posts
$sound_closing_src = "SELECT guid FROM {$wpdb->posts} WHERE guid='$ays_pb_close_sound'";
$closing_sound_src_result = $wpdb->get_results($sound_closing_src, "ARRAY_A");

//delete ays pb close sound
if($closing_sound_src_result == null){
    $ays_pb_close_sound = '';
}

//delete ays pb opening sound
if($sound_src_result == null){
    $ays_pb_sound = ''; 
}

?>
<div class="wrap" style="position:relative;">
    <div class="container-fluid">
        <form method="post" >
            <input type="hidden" name="ays_pb_tab" value="<?php echo $ays_pb_tab; ?>">
            <h1 class="wp-heading-inline">
                <?php
                echo __('Settings', $this->plugin_name);
                ?>
            </h1>
            <?php
            if (isset($_REQUEST['status'])) {
                $actions->pb_settings_notices($_REQUEST['status']);
            }
            ?>
            <hr/>
            <div class="ays-settings-wrapper">
                <div>
                    <div class="nav-tab-wrapper" style="position:sticky; top:35px;">
                        <a href="#tab1" data-tab="tab1"
                           class="nav-tab <?php echo ($ays_pb_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("General", $this->plugin_name); ?>
                        </a>
                    </div>
                </div>
                <div class="ays-pb-tabs-wrapper">
                    <div id="tab1"
                         class="ays-pb-tab-content <?php echo ($ays_pb_tab == 'tab1') ? 'ays-pb-tab-content-active' : ''; ?>">
                        <p class="ays-pb-subtitle"><?php echo __('General Settings', $this->plugin_name) ?></p>
                        <hr/>
                        <div class="form-group row" style="padding:15px;">
                            <fieldset>
                                <legend>
                                    <strong style="font-size:30px;"><i class="ays_fa ays_fa-music"></i></strong>
                                    <h5><?php echo __('Popup sound',$this->plugin_name)?></h5>
                                </legend>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="">
                                            <span>
                                                <?php echo  __('Opening and closing sounds',$this->plugin_name) ?>
                                                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose your preferred sounds both for opening and closing (or either one of them) of the Popup Box.', $this->plugin_name); ?>">
                                                    <i class="ays_fa ays_fa-info-circle"></i>
                                                </a>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="ays_pb_opening_sound">
                                                    <?php echo __( "Opening sound", $this->plugin_name ); ?>
                                                </label>
                                                <div class="ays-bg-music-container">
                                                    <a class="add-pb-bg-music" href="javascript:void(0);"><?php echo __("Select sound", $this->plugin_name); ?></a>
                                                    <audio controls src="<?php echo $ays_pb_sound; ?>" class="ays-bg-opening-music-audio"></audio>
                                                    <input type="hidden" name="ays_pb_sound" class="ays_pb_bg_music ays_pb_bg_music_opening_input" value="<?php echo $ays_pb_sound; ?>" id="ays_pb_opening_sound">
                                                    <i class="ays_fa ays_fa_times ays_pb_sound_close_btn ays_pb_sound_opening_btn" style="<?php echo ($ays_pb_sound == '') ? 'display:none' : 'display:block'; ?>"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- close sound start -->
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="ays_pb_closing_sound">
                                                    <?php echo __( "Closing sound", $this->plugin_name ); ?>
                                                </label>
                                                <div class="ays-bg-music-container">
                                                    <a class="add-pb-bg-music" href="javascript:void(0);"><?php echo __("Select sound", $this->plugin_name); ?></a>
                                                    <audio controls src="<?php echo $ays_pb_close_sound; ?>" class="ays-bg-closing-music-audio"></audio>
                                                    <input type="hidden" name="ays_pb_close_sound" class="ays_pb_bg_music ays_pb_bg_music_closing_input" value="<?php echo $ays_pb_close_sound; ?>" id="ays_pb_closing_sound">
                                                    <i class="ays_fa ays_fa_times ays_pb_sound_close_btn ays_pb_sound_closing_btn"  style="<?php echo ($ays_pb_close_sound == '') ? 'display:none' : 'display:block'; ?>" ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- close sound end -->
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="only_pro who_have_permission"> 
                                 <div class="pro_features">
                                                <div>
                                                    <p>
                                                        <?php echo __("This feature is available only in ", $this->plugin_name); ?>
                                                        <a href="https://ays-pro.com/wordpress/popup-box" target="_blank" title="PRO feature"><?php echo __("PRO version!!!", $this->plugin_name); ?></a>
                                                    </p>
                                                </div>
                                        </div>
                                <legend>
                                    <strong style="font-size:30px;"><i class="ays_fa ays_fa_globe"></i></strong>
                                    <h5><?php echo __('Who will have permission to Popup menu',$this->plugin_name)?></h5>
                                </legend>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="ays_user_roles">
                                            <?php echo __( "Select user role", $this->plugin_name ); ?>
                                            <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Ability to manage Popup Box plugin only for selected user roles.',$this->plugin_name)?>">
                                                <i class="ays_fa ays_fa_info_circle"></i>
                                            </a>
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select name="ays_pb_user_roles[]" id="ays_pb_user_roles" multiple>
                                           
                                        </select>
                                    </div>
                                </div>
                                <blockquote>
                                    <?php echo __( "Ability to manage Popup Box plugin only for selected user roles.", $this->plugin_name ); ?>
                                </blockquote>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <h1>
            <?php
            wp_nonce_field('settings_action', 'settings_action');
            $other_attributes = array("id" => 'ays_submit_settings');
            submit_button(__('Save changes', $this->plugin_name), 'primary ays-button', 'ays_submit', false, $other_attributes);
            echo $loader_iamge;
            ?>
            </h1>
        </form>
    </div>
</div>
<script>
    jQuery(document).ready(function($){
        $('[data-toggle="tooltip"]').tooltip();
    });    
</script>