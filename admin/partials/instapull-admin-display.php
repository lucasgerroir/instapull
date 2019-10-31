<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       lucasgerroir.com
 * @since      1.0.0
 *
 * @package    Instapull
 * @subpackage Instapull/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="instapull_options" action="options.php">

    <?php

        // Grab all options
        $options = get_option($this->plugin_name);

        // all the options for the admin settings.
        // set them up to check if they are set.
        $feed = $options['feed'];
        $limit = $options['limit'];
        $title = $options['title'];

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

        <fieldset>
            <legend class="screen-reader-text"><span>Instagram User</span></legend>
            <p><?php esc_attr_e('Please  enter a valid instagram user', $this->plugin_name); ?></p>
            <label for="<?php echo $this->plugin_name; ?>-feed">
                <input placeholder="Enter instagram user here..." class="regular-text insta-input" type="text" id="<?php echo $this->plugin_name; ?>-feed" name="<?php echo $this->plugin_name; ?>[feed]" value="<?php if(!empty($feed)) echo $feed; ?>"/>
                <span></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span> Title </span></legend>
            <p><?php esc_attr_e('Title that is displayed above the feed', $this->plugin_name); ?></p>
            <label for="<?php echo $this->plugin_name; ?>-title">
                <input placeholder="Enter title here.." class="regular-text insta-input" type="text" id="<?php echo $this->plugin_name; ?>-title" name="<?php echo $this->plugin_name; ?>[title]" value="<?php if(!empty($title)) echo $title; ?>"/>
                <span></span>
            </label>
        </fieldset>

        <fieldset>
            <legend class="screen-reader-text"><span>Amount of posts</span></legend>
            <p><?php esc_attr_e('Amount of items to appear in feed', $this->plugin_name); ?></p>
            <label for="<?php echo $this->plugin_name; ?>-limit">
                <select class="insta-input" id="<?php echo $this->plugin_name; ?>-limit" name="<?php echo $this->plugin_name; ?>[limit]">
                <?php for($i = 1; $i <= $limit_max; $i++) { ?>
                    <option <?php if($limit == $i) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                </select>
                <span></span>
            </label>
        </fieldset>

        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>