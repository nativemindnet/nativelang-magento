<?php
// Configure your additional domains here. Some examples:
cybo_add_extra_domain( 'nativemind.net', 1 );
cybo_add_extra_domain( 'en.nativemind.net', 1 );
cybo_add_extra_domain( 'ru.nativemind.net', 1 );
cybo_add_extra_domain( 'hi.nativemind.net', 1 );
cybo_add_extra_domain( 'th.nativemind.net', 1 );
cybo_add_extra_domain( 'cn.nativemind.net', 1 );

/**
 * Map additional domain to blog / subsite in multisite setup
 * 
 * @param string $domain  The additional domain
 * @param int $id         The blog_id 
 */
function cybo_add_extra_domain( $domain, $id ) {
    if ( ! isset( $_SERVER['HTTP_HOST'] ) ) {
        return;
    }
    
    $mask_domain = strtolower( $_SERVER['HTTP_HOST'] );
    
    if ( $mask_domain !== $domain ) {
        return;
    }

    global $blog_id, $current_blog, $current_site;

    // Set globals
    $blog_id      = $id; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
    $current_blog = get_site( $blog_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

    // This should always be 1, unless you are running multiple WordPress networks.
    $current_site = get_network( 1 ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

    $origin_domain = $current_blog->domain . untrailingslashit( $current_blog->path );

    $domain_replace_fn = function( $url ) use ( $mask_domain, $origin_domain ) {
        return str_ireplace( $origin_domain, $mask_domain, $url );
    };

    add_filter( 'home_url', $domain_replace_fn, 1 );
    add_filter( 'site_url', $domain_replace_fn, 1 );
    add_filter( 'content_url', $domain_replace_fn, 1 );
    add_filter( 'plugins_url', $domain_replace_fn, 1 );
    add_filter( 'upload_dir', function( $uploads ) use ( $domain_replace_fn ) { 
        if ( ! empty( $uploads['url'] ) && is_string( $uploads['url'] ) ) { 
            $uploads['url'] = $domain_replace_fn( $uploads['url'] );
        }   
        if ( ! empty( $uploads['baseurl'] ) && is_string( $uploads['baseurl'] ) ) { 
            $uploads['baseurl'] = $domain_replace_fn( $uploads['baseurl'] );
        }

        return $uploads;
    }, 1 );

}