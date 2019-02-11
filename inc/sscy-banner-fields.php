<?php

function sscy_banner_link( $post ) {
    wp_nonce_field( basename(__FILE__), 'sscy_banner_nonce' );
    $url = get_post_meta( $post->ID, 'banner_url', true );
    $url_text = get_post_meta( $post->ID, 'banner_url_text', true );

    ?>
        <p>
            <label for="banner_url">URL for the button on the banner</label><br />
            <input type="text" name="banner_url" id="banner_url" style="width: 100%;" value="<?php echo esc_url( $url ); ?>" placeholder="Leave blank for no button" />
        </p>

        <p>
            <label for="banner_url_text">Button Text</label><br />
            <input type="text" name="banner_url_text" id="banner_url_text" style="width: 100%;" value="<?php echo $url_text; ?>" placeholder="Default: Learn More " />
        </p>
    <?php
}

