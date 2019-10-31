<?php

/**
 * This is the main view for the instagram post cards
 *
 * 
 * @link       lucasgerroir.com
 * @since      1.0.0
 *
 * @package    Instapull
 * @subpackage Instapull/public/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="card">
    <div class="card-image_container">
        <img class="card-image" src="<?php echo $post_data['image'];  ?>" />
    </div>
    <div class="card-content">
        <h4 class="card-title"><?php echo $post_data['title'];  ?></h4>
        <p><?php echo $post_data['description'];  ?></p>
        <span><?php echo $post_data['date'];  ?></span>
    </div>
</div>