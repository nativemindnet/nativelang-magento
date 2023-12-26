<?php




/**
 * Map additional domain to blog / subsite in multisite setup
 * 
 * @param string $domain  The additional domain
 * @param int $id         The blog_id 
 */
function cybo_add_extra_domain( $domain, $path, $id ) {
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
    $mask_full = $mask_domain . untrailingslashit( $path );

/*
    echo("origin_domain:$origin_domain\n");
    echo("mask_domain:$mask_domain\n");
    echo("mask_full:$mask_full\n");
    echo("current_blog->domain:$current_blog->domain\n");
    echo("current_blog->path:$current_blog->path\n");
    die("DIE");
*/

    $domain_replace_fn = function( $url ) use ( $mask_full, $origin_domain ) {
        return str_ireplace( $origin_domain, $mask_full, $url );
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

// Configure your additional domains here. Some examples:

require("my_domains.php");