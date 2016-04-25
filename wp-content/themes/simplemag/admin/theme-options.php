<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "ti_option";


    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /*
     *
     * --> Action hook examples
     *
     */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');


    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyBCNNmid7eOngJUTGogTM9pd_O_SJUOSJE',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );


    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/ThemesIndep',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/themesindep',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    
    // Panel Intro text -> before the form
/*
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
    } else {
        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
    }

    // Add content after the form.
    $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );
    */

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );
    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
    Redux::setHelpSidebar( $opt_name, $content );
    */

    

    /**
     * ---> DECLARATION OF SECTIONS
    **/

    // ---> Header
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-eye-open',
        'title'     => __('Header', 'redux-framework-demo'),
        'heading'   => __('Site Header Options', 'redux-framework-demo'),
        'fields'    => array(
            
            /* Top Strip */
            array(
                'id'        => 'site_top_strip_start',
                'type'      => 'section',
                'title'     => __('Top Strip', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_top_strip',
                        'type'      => 'switch',
                        'title'     => __('Strip Visibility', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the top strip', 'redux-framework-demo'),
                        'default'   => 1,
                    ),
                    array(
                        'id'        => 'site_top_strip_logo',
                        'type'      => 'media',
                        'required'  => array('site_top_strip', '=', '1'),
                        'title'     => __('Logo', 'redux-framework-demo'),
                        'subtitle'  => __('Upload a logo to be shown in top strip', 'redux-framework-demo')
                    ),
            array(
                'id'        => 'site_top_strip_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
            /* Main Logo Area */
            array(
                'id'        => 'main_logo_start',
                'type'      => 'section',
                'title'     => __('Main Logo Area', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_main_area',
                        'type'      => 'switch',
                        'title'     => __('Area Visibility', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable main logo area', 'redux-framework-demo'),
                        'default'   => 1,
                    ),
                    array(
                        'id'        => 'site_logo',
                        'type'      => 'media',
                        'required'  => array('site_main_area', '=', '1'),
                        'title'     => __('Main Logo', 'redux-framework-demo'),
                        'subtitle'  => __('Upload your site logo. Default logo will be used unless you upload your own', 'redux-framework-demo'),
                        'default'   => array(
                            'url'   => get_template_directory_uri() .'/images/logo.png',
                            'width' => '367',
                            'height' => '66',
                        )
                    ),
                    array(
                        'id'        => 'site_tagline',
                        'type'      => 'switch',
                        'required'  => array('site_main_area', '=', '1'),
                        'title'     => __('Tagline', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the tagline under the logo', 'redux-framework-demo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'site_header',
                        'type'      => 'image_select',
                        'required'  => array('site_main_area', '=', '1'),
                        'title'     => __('Area Type', 'redux-framework-demo'),
                        'subtitle'  => __('1. Logo<br />2. Logo, social profiles and search<br />3. Logo and ad unit. To add the ad unit click on the Ad Units tab.', 'redux-framework-demo'),
                        'options'   => array(
                            'header_default' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-logo-centered.png'),
                            'header_search' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-logo-social-search.png'),
                            'header_banner' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-logo-ad.png'),
                        ), 
                        'default' => 'header_default'
                    ),
            array(
                'id'        => 'main_logo_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
            /* Main Menu */
            array(
                'id'        => 'site_main_menu_start',
                'type'      => 'section',
                'title'     => __('Main Menu', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_main_menu',
                        'type'      => 'switch',
                        'title'     => __('Main Menu', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the main menu', 'redux-framework-demo'),
                        'default'   => 1,
                    ),
                    array(
                        'id'        => 'site_mega_menu',
                        'type'      => 'switch',
                        'required'  => array('site_main_menu', '=', '1'),
                        'title'     => __('Mega Menu', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the mega menu', 'redux-framework-demo'),
                        'default'   => 1,
                    ),
            array(
                'id'        => 'site_main_menu_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            array(
                'id'        => 'header_features_start',
                'type'      => 'section',
                'title'     => __('Header Features', 'redux-framework-demo'),
                'subtitle'      => __('All options below are applicable for top strip and main logo area', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_fixed_menu',
                        'type'      => 'image_select',
                        'title'     => __('Fixed Element', 'redux-framework-demo'),
                        'subtitle'  => __('Select header fixed element:<br />None, Top Strip, Main Menu', 'redux-framework-demo'),
                        'options'   => array(
                            '1' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-fixed-none.png'),
                            '2' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-fixed-top-menu.png'),
                            '3' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-fixed-main-menu.png'),
                        ), 
                        'default' => '1'
                    ),
                    array(
                        'id'        => 'site_search_visibility',
                        'type'      => 'switch',
                        'title'     => __('Search Visibility', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable the search', 'redux-framework-demo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'top_social_profiles',
                        'type'      => 'switch',
                        'title'     => __('Social Profiles', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or Disable top strip socical profiles', 'redux-framework-demo'),
                    ),
                    array(
                        'id'        => 'social_profile_url',
                        'title'     => __('Social Profiles URLs', 'redux-framework-demo'),
                        'subtitle'  => __('Enter full URLs of your social profiles', 'redux-framework-demo'),
                        'required'  => array('top_social_profiles', '=', '1'),
                        'type'      => 'text',
                        'placeholder'      => '',
                        'options'   => array(
                            'feed' => 'RSS Feed',
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter',
                            'google-plus' => 'Google+',
                            'linkedin' => 'LinkedIn',
                            'pinterest' => 'Pinterest',
                            'bloglovin' => 'Bloglovin',
                            'tumblr' => 'Tumblr',
                            'instagram' => 'Instagram', 
                            'flickr' => 'Flickr',
                            'vimeo' => 'Vimeo',
                            'youtube' => 'Youtube',
                            'behance' => 'Behance',
                            'dribbble' => 'Dribbble',
                            'soundcloud' => 'Soundcloud',
                            'lastfm' => 'LastFM'
                        ),
                        'default' => array(
                            'feed' => '',
                            'facebook' => '',
                            'twitter' => '',
                            'google-plus' => '',
                            'linkedin' => '', 
                            'pinterest' => '',
                            'bloglovin' => '',
                            'tumblr' => '',
                            'instagram' => '', 
                            'flickr' => '',
                            'vimeo' => '',
                            'youtube' => '',
                            'behance' => '',
                            'dribbble' => '',
                            'soundcloud' => '',
                            'lastfm' => ''
                        ),
                array(
                    'id'        => 'header_features_end',
                    'type'      => 'section',
                    'indent'    => false,
                ),
            )
        ) 
    ) );


    // ---> General Settings
    Redux::setSection( $opt_name, array(
        'title'  => __('General Settings', 'redux-framework-demo'),
        'icon'   => 'el-icon-cogs',
        'fields' => array(
            array(
                'id'        => 'site_sidebar_fixed',
                'type'      => 'switch',
                'title'     => __('Fixed Sidebar', 'redux-framework-demo'),
                'subtitle'  => __('Make sidebar fixed site wide', 'redux-framework-demo'),
                'default'   => false,
            ),
            array(
                'id'        => 'site_custom_gallery',
                'type'      => 'switch',
                'title'     => __('Custom Gallery', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable theme custom WordPress gallery', 'redux-framework-demo'),
                'default'   => false,
            ),
            array(
                'id'        => 'site_carousel_height',
                'type'      => 'text',
                'title'     => __('Gallery Carousel Height', 'redux-framework-demo'),
                'subtitle'  => __('Set the height of the gallery carousel. Applies to Posts Carousel section and Gallery Format post.', 'redux-framework-demo'),
                'desc'      => __('After changing the height you need to run the Force Regenerate Thumbnails plugin.', 'redux-framework-demo'),
                'validate'  => 'numeric',
                'default'   => '580',
            ),
            array(
                'id'        => 'site_page_comments',
                'type'      => 'switch',
                'title'     => __('Comments in static pages', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable comments in all static pages.', 'redux-framework-demo'),
                'default'   => false,
            ),
            array(
                'id'        => 'full_width_widget',
                'type'      => 'switch',
                'title'     => __('Footer Full Width Widget', 'redux-framework-demo'),
                'subtitle'  => __('Footer widget full browser width', 'redux-framework-demo'),
                'default'   => true,
            ),
            array(
                'id'        => 'copyright_text',
                'type'      => 'textarea',
                'title'     => __('Footer Text', 'redux-framework-demo'),
                'subtitle'  => __('Your site footer copyright text', 'redux-framework-demo'),
                'default'   => 'Powered by WordPress. <a href="http://www.themesindep.com">Created by ThemesIndep</a>',
            ),
        )
    ) );

    // ---> Typography
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-fontsize',
        'title'     => __('Typography', 'redux-framework-demo'),
        'fields'    => array(
            
             array(
                'id'        => 'typography_info',
                'type'      => 'info',
                'desc'      => __('Standard System Fonts and Google Webfonts are avaialble in each Font Family dropdown', 'redux-framework-demo')
             ),
            
            
            /* Secondary and Main menus */
            array(
                'id'        => 'menu_font_start',
                'type'      => 'section',
                'title'     => __('Site Menus', 'redux-framework-demo'),
                'indent'    => false,
            ),
            
                    array(
                        'id'        => 'site_menus_font',
                        'type'      => 'typography',
                        'title'     => __('Menus', 'redux-framework-demo'),
                        'subtitle'  => __('Specify font style for top strip secondary and main menus', 'redux-framework-demo'),
                        'google'    => true,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-size' => false,
                        'default'   => array(
                            'font-family' => 'Roboto',
                            'font-weight' => '500',
                        ),
                        'output' => array('.menu-item a, #s, .entry-meta, .see-more span, .read-more, .read-more-link, .nav-title, .related-posts-tabs li a, #submit, input, textarea, .copyright, .copyright a'),
                    ),
            
                    array(
                        'id'        => 'top_menu_font_size',
                        'type'      => 'typography',
                        'title'     => __('Top Strip', 'redux-framework-demo'),
                        'subtitle'  => __('Top strip menu font size', 'redux-framework-demo'),
                        'google'    => false,
                        'font-family' => false,
                        'font-style' => false,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'default'   => array(
                            'font-size' => '12px'
                        ),
                        'output' => array('.secondary-menu > ul > li')
                    ),
                    array(
                        'id'        => 'main_menu_font_size',
                        'type'      => 'typography',
                        'title'     => __('Main Menu', 'redux-framework-demo'),
                        'subtitle'  => __('Main menu font size', 'redux-framework-demo'),
                        'google'    => false,
                        'font-family' => false,
                        'font-style' => false,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'default'   => array(
                            'font-size' => '18px'
                        ),
                        'output' => array('.main-menu > ul > li')
                    ),
            
            array(
                'id'        => 'menu_font_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
             /* Titles and Heading */
            array(
                'id'        => 'titles_font_start',
                'type'      => 'section',
                'title'     => __('Titles and Heading', 'redux-framework-demo'),
                'indent'    => false,
            ),
            
                    array(
                        'id'        => 'font_titles',
                        'type'      => 'typography',
                        'title'     => __('Titles and Headings', 'redux-framework-demo'),
                        'subtitle'  => __('Specify font style for titles and headings', 'redux-framework-demo'),
                        'google'    => true,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-size' => false,
                        'default'   => array(
                            'font-family' => 'Playfair Display',
                            'font-weight' => '700',
                            
                        ),
                        'output' => array('h1, h2, h3, h4, h5, h6, .main-menu .item-title a, .widget_pages, .widget_categories, .widget_nav_menu, .tagline, .sub-title, .entry-note, .manual-excerpt, .ltr:not(.woocommerce) .entry-content > p:first-of-type:first-letter, .sc-dropcap, .single-author-box .vcard, .comment-author, .comment-meta, .comment-reply-link, #respond label, #wp-calendar tbody, .latest-reviews .score-line i, .score-box .total'),
                    ),

                    /* Page Composer Titles */
                    array(
                        'id'        => 'titles_size',
                        'type'      => 'typography',
                        'title'     => __('Composer Main Titles Size', 'redux-framework-demo'),
                        'subtitle'  => __('Specify sections titles size', 'redux-framework-demo'),
                        'google'    => false,
                        'font-family' => false,
                        'font-style' => false,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'default'   => array(
                            'font-size' => '42px',
                        ),
                        'output' => array('.section-title, .classic-layout .entry-title')
                    ),
                   
                    /* Post Item */
                    array(
                        'id'        => 'post_item_titles_size',
                        'type'      => 'typography',
                        'title'     => __('Post Item', 'redux-framework-demo'),
                        'subtitle'  => __('Apllies to: composer, posts page, category or other archives', 'redux-framework-demo'),
                        'google'    => false,
                        'font-family' => false,
                        'font-style' => false,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'default'   => array(
                            'font-size' => '24px'
                        ),
                        'output' => array('.entries .post-item .entry-title, .media-post-item .entry-title')
                    ),
                        
                    /* Single Post and Static Page */
                    array(
                        'id'        => 'single_font_size',
                        'type'      => 'typography',
                        'title'     => __('Single Post and Page', 'redux-framework-demo'),
                        'subtitle'  => __('Titles size for Single Post and Static Page', 'redux-framework-demo'),
                        'google'    => false,
                        'font-family' => false,
                        'font-style' => false,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'default'   => array(
                            'font-size' => '52px',
                        ),
                        'output' => array('.page-title')
                    ),
                    array(
                        'id'        => 'post_title_style',
                        'type'      => 'button_set',
                        'title'     => __('Titles Style', 'redux-framework-demo'),
                        'subtitle'  => __('Titles styling. Applies to Post Item, Single Post and Static Page', 'redux-framework-demo'),
                        'options'   => array( 
                            'capitalize' => 'Capitalize',
                            'uppercase' => 'Uppercase',
                            'none' => 'Regular'
                        ), 
                        'default'   => 'capitalize'
                    ),
            
            array(
                'id'        => 'titles_font_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
            /* Body Font */
            array(
                'id'        => 'body_font_start',
                'type'      => 'section',
                'title'     => __('Editor Text', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'font_text',
                        'type'      => 'typography',
                        'title'     => __('Font Family', 'redux-framework-demo'),
                        'subtitle'  => __('Editor text font familty', 'redux-framework-demo'),
                        'google'    => true,
                        'color'     => false,
                        'text-align' => false,
                        'line-height' => 'false',
                        'font-size'     => 'false',
                        'default'   => array(
                            'font-family'   => 'Georgia, serif',
                            'font-weight'   => 'normal'
                        ),
                        'output' => array('body, p'),
                    ),
                    array(
                        'id'        => 'entry_content_font',
                        'type'      => 'typography',
                        'title'     => __('Font Size', 'redux-framework-demo'),
                        'subtitle'  => __('Editor text font size', 'redux-framework-demo'),
                        'google'    => true,
                        'font-family' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'color'     => false,
                        'text-align' => false,
                        'default'   => array(
                            'font-size'   => '18px',
                            'line-height' => '28px',
                        ),
                        'output' => array('.page .entry-content, .single .entry-content, .home-section div.entry-summary'),
                    ),
            
             array(
                'id'        => 'body_font_end',
                'type'      => 'section',
                'indent'    => false,
            ),
        ) 
    ) );


    // ---> Design Options
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-magic',
        'title'     => __('Design Options', 'redux-framework-demo'),
        'fields'    => array(
            /* Text Alignment */
            array(
                'id'        => 'text_alignment',
                'type'      => 'image_select',
                'title'     => __('Text alignment', 'redux-framework-demo'),
                'subtitle'  => __('Select your site text alignment. Centered or Left.', 'redux-framework-demo'),
                'options'   => array(
                    '1' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-align-center.png'),
                    '2' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-align-left.png'),
                ), 
                'default' => '1'
            ),
            
            /* Site Layout */
            array(
                'id'        => 'site_layout',
                'type'      => 'image_select',
                'title'     => __('Site Layout', 'redux-framework-demo'),
                'subtitle'  => __('Select site layout. Fullwidth or Boxed.', 'redux-framework-demo'),
                'options'   => array(
                    '1' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-layout-full.png'),
                    '2' => array('img' => get_template_directory_uri() .'/admin/images/to-icon-layout-boxed.png'),
                ), 
                'default' => '1'
            ),
            
            /* Body Background */
            array(
                'id'        => 'site_body_bg',
                'type'      => 'background',
                'title'     => __('Body Background', 'redux-framework-demo'),
                'subtitle'  => __('Pick a body background color or upload an image', 'redux-framework-demo'),
                'default'  => array('background-color' => '#fff'),
                'output'  => array('background-color' => 'body, .site-content, .layout-full .title-with-sep .title, .layout-full .title-with-sep .entry-title'),
            ),
            
            /* Main Colors. For Comments avatar, rating bar, rating cirlce */
            array(
                'id'        => 'main_colors_start',
                'type'      => 'section',
                'title'     => __('Main Colors', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'main_site_color',
                        'type'      => 'color',
                        'title'     => __('Main Color', 'redux-framework-demo'),
                        'subtitle'  => __('Color for comments avatar, ratings, etc.', 'redux-framework-demo'),
                        'default'   => '#ffcc0d',
                        'output'    => array( 'background-color' => '.score-line span, .rating-total-indicator .sides span, .widget_ti_most_commented span', 'border-color' => '.comment-list .bypostauthor .avatar', 'border-top-color' => '.widget_ti_most_commented span i:before' ),
                    ),
                    array(
                        'id'        => 'secondary_site_color',
                        'type'      => 'color',
                        'title'     => __('Secondary Color', 'redux-framework-demo'),
                        'subtitle'  => __('Color for rating bar text, etc.', 'redux-framework-demo'),
                        'default'   => '#000',
                        'output'    => array( 'color' => '.score-line span i, .widget_ti_most_commented span i' ),
                    ),
            array(
                'id'        => 'main_colors_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            

            /* Header */  
            array(
                'id'        => 'header_colors_start',
                'type'      => 'section',
                'title'     => __('Header', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'header_site_color',
                        'type'      => 'color',
                        'title'     => __('Header Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick the header background color', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'output'    => array( 'background-color' => '#masthead' ),
                    ),
            array(
                'id'        => 'header_colors_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Top Strip */
            array(
                'id'        => 'top_strip_start',
                'type'      => 'section',
                'title'     => __('Top Strip', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_top_strip_bg',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Top strip background color.', 'redux-framework-demo'),
                        'default'   => '#000',
                        'output'  => array( 'background-color' => '.top-strip, .secondary-menu .sub-menu, .top-strip #searchform input[type="text"], .top-strip .social li ul' ),
                    ),
                    array(
                        'id'        => 'site_top_strip_bottom_border',
                        'type'      => 'border',
                        'title'     => __('Bottom Border', 'redux-framework-demo'),
                        'subtitle'  => __('Bottom border color', 'redux-framework-demo'),
                        'output'  => array('.top-strip'),
                        'all'       => false,
                        'right'     => false,
                        'top'       => false,
                        'left'      => false,
                        'default'   => array(
                            'border-color'  => '#000',
                            'border-style'  => 'solid', 
                            'border-bottom' => '0px',
                        )
                    ),
                    array(
                        'id'        => 'site_top_strip_links',
                        'type'      => 'link_color',
                        'title'     => __('Menu Links', 'redux-framework-demo'),
                        'subtitle'  => __('Menu links color', 'redux-framework-demo'),
                        'output'  => array('.secondary-menu a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffcc0d'
                        )
                    ),
                    array(
                        'id'        => 'site_top_strip_social',
                        'type'      => 'color',
                        'title'     => __('Social Icons', 'redux-framework-demo'),
                        'subtitle'  => __('Social icons styling', 'redux-framework-demo'),
                        'default'   => '#8c919b',
                        'output'    => array( 'color' => '.top-strip .social li a' ),
                    ),
            array(
                'id'        => 'top_strip_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Main Menu */
            array(
                'id'        => 'main_menu_start',
                'type'      => 'section',
                'title'     => __('Main Menu', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'main_menu_color',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Main menu background color', 'redux-framework-demo'),
                        'default'   => '#fff',
                        'output'    => array( 'background-color' => '.main-menu-container,.sticky-active .main-menu-fixed' ),
                    ),
                    array(
                        'id'        => 'main_menu_links_color',
                        'type'      => 'link_color',
                        'title'     => __('Menu Links', 'redux-framework-demo'),
                        'subtitle'  => __('Main menu links color', 'redux-framework-demo'),
                        'output'  => array('.main-menu > ul > li'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#000',
                            'hover'     => '#333'
                        )
                    ),
                    array(
                        'id'        => 'main_menu_separator',
                        'type'      => 'color',
                        'title'     => __('Links Separator', 'redux-framework-demo'),
                        'subtitle'  => __('Links seprator color', 'redux-framework-demo'),
                        'default'   => '#eee',
                        'output'    => array( 'color' => '.main-menu > ul > li > a > span:after' ),
                    ),
                    array(
                        'id'        => 'main_menu_top_border',
                        'type'      => 'border',
                        'title'     => __('Top Border', 'redux-framework-demo'),
                        'subtitle'  => __('Main Menu top border', 'redux-framework-demo'),
                        'output'  => array('.main-menu-container'),
                        'all'       => false,
                        'right'     => false,
                        'bottom'    => false,
                        'left'      => false,
                        'default'   => array(
                            'border-color'  => '#000', 
                            'border-style'  => 'solid', 
                            'border-top'    => '1px',
                        )
                    ),
                    array(
                        'id'        => 'main_menu_bottom_border',
                        'type'      => 'border',
                        'title'     => __('Bottom Border', 'redux-framework-demo'),
                        'subtitle'  => __('Main Menu bottom border', 'redux-framework-demo'),
                        'output'  => array('.main-menu-container'),
                        'all'       => false,
                        'right'     => false,
                        'top'       => false,
                        'left'      => false,
                        'default'   => array(
                            'border-color'  => '#000', 
                            'border-style'  => 'solid', 
                            'border-bottom' => '2px',
                        )
                    ),
            array(
                'id'        => 'main_menu_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Main Menu Dropdown */
            array(
                'id'        => 'main_dropdown_start',
                'type'      => 'section',
                'title'     => __('Main Menu Dropdown', 'redux-framework-demo'),
                'indent'    => false,
            ),
            
                    // General Settings
                    array(
                        'id'        => 'main_sub_menu_pointer',
                        'type'      => 'color',
                        'title'     => __('Pointer &amp; Top Border', 'redux-framework-demo'),
                        'subtitle'  => __('Pointer and top border color', 'redux-framework-demo'),
                        'default'   => '#ffcc0d',
                    ),

                    // Colors
                    array(
                        'id'        => 'main_sub_bg_left',
                        'type'      => 'color',
                        'title'     => __('Background Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick menu background color', 'redux-framework-demo'),
                        'default'   => '#000',
                        'output'  => array( 'background-color' => '.main-menu .sub-menu' ),
                    ),
                    array(
                        'id'        => 'main_sub_links_left',
                        'type'      => 'link_color',
                        'title'     => __('Links Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick menu links color', 'redux-framework-demo'),
                        'output'  => array('.main-menu .sub-menu li a, .main-menu .mega-menu-container .mega-menu-posts-title'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#ffffff',
                            'hover'     => '#ffcc0d'
                        )
                    ),

            array(
                'id'        => 'main_dropdown_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Titles Background */
            array(
                'id'        => 'titles_bg_start',
                'type'      => 'section',
                'title'     => __('Titles Background', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'titles_background_switch',
                        'type'      => 'switch',
                        'title'     => __('On/Off', 'redux-framework-demo'),
                        'subtitle'  => __('Turn the background image on or off', 'redux-framework-demo'),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'titles_background_image',
                        'type'      => 'switch',
                        'title'     => __('Background Type', 'redux-framework-demo'),
                        'subtitle'  => __('Use deafult background or upload custom', 'redux-framework-demo'),
                        'required'  => array('titles_background_switch', '=', '1'),
                        'default'   => '1',
                        'on'        => 'Use Default',
                        'off'       => 'Upload Custom'
                    ),
                    array(
                        'id'        => 'titles_background_upload',
                        'type'      => 'media',
                        'url'       => true,
                        'required'  => array('titles_background_image', '=', '0'),
                        'title'     => __('Upload Custom', 'redux-framework-demo'),
                        'subtitle'  => __('Upload custom background', 'redux-framework-demo'),
                        'default'   => '',
                    ),
            array(
                'id'        => 'titles_bg_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            /* Slider Tint */
            array(
                'id'        => 'slider_tint_start',
                'type'      => 'section',
                'title'     => __('Slider', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'slider_tint',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Slider background color', 'redux-framework-demo'),
                        'default'   => '#000',
                        'output'    => array( 'background-color' => '.modern .content-over-image-tint .entry-image:before, .modern .content-over-image-tint.full-width-image:before' ),
                    ),
                    array(
                        'id'            => 'slider_tint_strength',
                        'type'          => 'slider',
                        'title'         => __('Tint strength', 'redux-framework-demo'),
                        'subtitle'      => __('Slider tint regular strength', 'redux-framework-demo'),
                        'default'       => .1,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 0,
                        'resolution'    => 0.1,
                        'display_value' => 'text',
                    ),
                    array(
                        'id'            => 'slider_tint_strength_hover',
                        'type'          => 'slider',
                        'title'         => __('Tint strength hover', 'redux-framework-demo'),
                        'subtitle'      => __('Slider tint regular strength mouse over', 'redux-framework-demo'),
                        'default'       => .7,
                        'min'           => 0,
                        'step'          => .1,
                        'max'           => 0,
                        'resolution'    => 0.1,
                        'display_value' => 'text',
                    ),
            array(
                'id'        => 'slider_tint_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Sidebar */
            array(
                'id'        => 'sidebar_border_start',
                'type'      => 'section',
                'title'     => __('Sidebar', 'redux-framework-demo'),
                'indent'    => false,
            ),
                array(
                    'id'        => 'sidebar_border',
                    'type'      => 'border',
                    'title'     => __('Sidebar Border', 'redux-framework-demo'),
                    'subtitle'  => __('Select sidebar border styling', 'redux-framework-demo'),
                    'default'   => array(
                        'border-color'  => '#000',
                        'border-style'  => 'solid',
                        'border-top'    => '1px', 
                        'border-right'  => '1px',
                        'border-bottom' => '1px', 
                        'border-left'   => '1px'
                    ),
                    'output' => array( 'border' => '.sidebar' ),
                ),
            array(
                'id'        => 'sidebar_border_end',
                'type'      => 'section',
                'indent'    => false,
            ),
                
            
            /* Slide Dock */
            array(
                'id'        => 'slide_dock_start',
                'type'      => 'section',
                'title'     => __('Single Post Slide Dock', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'slide_dock_color',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the backgound', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'output'    => array( 'background-color' => '.slide-dock' ),
                    ),
                    array(
                        'id'        => 'slide_dock_elements',
                        'type'      => 'color',
                        'title'     => __('Text Elements', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for dock title and post text', 'redux-framework-demo'),
                        'default'   => '#000000',
                        'output'    => array( 'color' => '.slide-dock h3, .slide-dock p' ),
                    ),
                    array(
                        'id'        => 'slide_dock_title',
                        'type'      => 'color',
                        'title'     => __('Post title', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the post title', 'redux-framework-demo'),
                        'default'   => '#000000',
                        'output'    => array( 'color' => '.slide-dock .entry-meta a, .slide-dock h4 a' ),
                    ),
            array(
                'id'        => 'slide_dock_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
            /* Author */
            array(
                'id'        => 'author_box_start',
                'type'      => 'section',
                'title'     => __('Author Box', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'author_box_color',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the backgound', 'redux-framework-demo'),
                        'default'   => '#f7f7f7',
                        'output'    => array( 'background-color' => '.author-box' ),
                    ),
                    array(
                        'id'        => 'author_box_text',
                        'type'      => 'color',
                        'title'     => __('Text and Links', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for titles, text and links', 'redux-framework-demo'),
                        'default'   => '#000000',
                        'output'    => array( 'color' => '.author-box, .author-box a' ),
                    ),
            array(
                'id'        => 'author_box_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            /* Widgetized Footer */
            array(
                'id'        => 'widgets_footer_start',
                'type'      => 'section',
                'title'     => __('Widgetized Footer', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'footer_color',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the backgound', 'redux-framework-demo'),
                        'default'   => '#111111',
                        'output'    => array( 'background-color' => '.footer-sidebar, .footer-sidebar .widget_ti_most_commented li a, .footer-sidebar .widget-slider .widget-post-details .widget-post-category, .footer-sidebar .widget-posts-classic-entries .widget-post-details .widget-post-category, .footer-sidebar .widget-posts-entries .widget-post-item:not(:nth-child(1)) .widget-post-details', 'border-bottom-color' => '.footer-sidebar .widget_ti_latest_comments .comment-text:after', 'color' => '.footer-sidebar .widget_ti_most_commented span i' ),
                    ),
                    array(
                        'id'        => 'footer_titles',
                        'type'      => 'color',
                        'title'     => __('Titles', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for widget titles', 'redux-framework-demo'),
                        'default'   => '#ffcc0d',
                        'output'    => array( 'color' => '.footer-sidebar .widget h3', 'background-color' => '.footer-sidebar .rating-total-indicator .sides span, .footer-sidebar .widget_ti_most_commented span', 'border-top-color' => '.footer-sidebar .widget_ti_most_commented span i:before' ),
                    ),
                    array(
                        'id'        => 'footer_text',
                        'type'      => 'color',
                        'title'     => __('Text', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for widget text', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'output'    => array( 'color' => '.footer-sidebar, .footer-sidebar button, .footer-sidebar input,  .footer-sidebar input[type="submit"]', 'border-color' => '.footer-sidebar input, .footer-sidebar input[type="submit"]', 'border-bottom-color' => '.footer-sidebar .widget_ti_latest_comments .comment-text:before' ),
                    ),
                    array(
                        'id'        => 'footer_links',
                        'type'      => 'link_color',
                        'title'     => __('Links Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for widget links', 'redux-framework-demo'),
                        'output'  => array('.footer-sidebar .widget a'),
                        'active'    => false,
                        'default'   => array(
                            'regular'   => '#8c919b',
                            'hover'     => '#ffcc0d'
                        )
                    ),
                    array(
                        'id'        => 'footer_border',
                        'type'      => 'border',
                        'title'     => __('Borders Color', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for borders', 'redux-framework-demo'),
                        'default'   => array(
                            'border-color'  => '#585b61',
                            'border-style'  => 'dotted',
                            'border-top'    => '1px',
                            'border-right'  => '1px',
                            'border-bottom' => '1px',
                            'border-left'   => '1px'
                        ),
                        'output' => array( 'border' => '.widget-area-2, .widget-area-3, .footer-sidebar .widget' ),
                    ),
            array(
                'id'        => 'widgets_footer_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            
            
            /* Footer Full Width Sidebar */
            array(
                'id'        => 'full_width_footer_start',
                'type'      => 'section',
                'title'     => __('Full Width Footer', 'redux-framework-demo'),
                'subtitle'     => __('Can be used for your Instagram feed', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'full_width_footer_bg',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the backgound', 'redux-framework-demo'),               
                        'default'   => '#f8f8f8',
                        'output'    => array( 'background-color' => '.full-width-sidebar' ),
                    ),
                    array(
                        'id'        => 'full_width_footer_text',
                        'type'      => 'color',
                        'title'     => __('Text and Links', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for text and links', 'redux-framework-demo'),
                        'default'   => '#000',
                        'output'    => array( 'color' => '.full-width-sidebar, .full-width-sidebar a' ),
                    ),
            array(
                'id'        => 'full_width_footer_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            

            /* Footer */
            array(
                'id'        => 'site_footer_start',
                'type'      => 'section',
                'title'     => __('Footer Copyright', 'redux-framework-demo'),
                'subtitle'     => __('Footer with your site copyright text', 'redux-framework-demo'),
                'indent'    => false,
            ),
                    array(
                        'id'        => 'site_footer_bg',
                        'type'      => 'color',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for the backgound', 'redux-framework-demo'),               
                        'default'   => '#000000',
                        'output'    => array( 'background-color' => '.copyright' ),
                    ),
                    array(
                        'id'        => 'site_footer_text',
                        'type'      => 'color',
                        'title'     => __('Text and Links', 'redux-framework-demo'),
                        'subtitle'  => __('Pick a color for text and links', 'redux-framework-demo'),
                        'default'   => '#ffffff',
                        'output'    => array( 'color' => '.copyright, .copyright a' ),
                    ),
            array(
                'id'        => 'site_footer_end',
                'type'      => 'section',
                'indent'    => false,
            ),
        )
    ) );



    // ---> Post Item
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-edit',
        'title'     => __('Post Item', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'post_item_info',
                'type'      => 'info',
                'desc'      => __('Controls the post item in categories, archives and posts page.', 'redux-framework-demo')
            ),
            array(
                'id'        => 'post_item_date',
                'type'      => 'switch',
                'title'     => __('Date', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the date', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'post_item_author',
                'type'      => 'switch',
                'title'     => __('Author Name', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the author name', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'post_item_excerpt',
                'type'      => 'switch',
                'title'     => __('Excerpt', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the execrpt', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'site_wide_excerpt_length',
                'type'      => 'text',
                'title'     => __('Excerpt Length', 'redux-framework-demo'),
                'subtitle'  => __('Enter a number of words to limit the exceprt site wide', 'redux-framework-demo'),
                'validate'  => 'numeric',
                'default'   => '24',
            ),
            array(
                'id'        => 'post_item_share',
                'type'      => 'switch',
                'title'     => __('Share Icons', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the share icons', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'post_item_read_more',
                'type'      => 'switch',
                'title'     => __('Read More', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the read more link', 'redux-framework-demo'),
                'default'   => 1,
            ),
        ) 
    ) );


    // Single Post
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-file-edit',
        'title'     => __('Single Post', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'single_media_position',
                'type'      => 'button_set',
                'title'     => __('Media Position', 'redux-framework-demo'),
                'subtitle'  => __('Applies to Featured Image, Gallery, Video or Audio.', 'redux-framework-demo'),
                'desc'      => __('"Full Width" and "Above the Content" will work site wide.<br /> "Define Per Post" enables the "Media Position" option in "Post Options" box in each post.', 'redux-framework-demo'),
                'options'   => array(
                    'fullwidth' => 'Full Width',
                    'abovecontent' => 'Above the Content',
                    'useperpost' => 'Define Per Post'
                ),
                'default'   => 'abovecontent'
            ),
            array(
                'id'        => 'single_title_position',
                'type'      => 'button_set',
                'title'     => __('Title Position', 'redux-framework-demo'),
                'subtitle'  => __('Applies to post main title', 'redux-framework-demo'),
                'desc'      => __('"Full Width" and "Above the Content" will work site wide.<br /> "Define Per Post" enables the "Title Position" option in "Post Options" box in each post.', 'redux-framework-demo'),
                'options'   => array(
                    'fullwidth' => 'Full Width',
                    'abovecontent' => 'Above the Content',
                    'useperpost' => 'Define Per Post'
                ),
                'default'   => 'fullwidth'
            ),
            array(
                'id'        => 'single_featured_image',
                'type'      => 'switch',
                'title'     => __('Featured Image', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable featured image', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_author_name',
                'type'      => 'switch',
                'title'     => __('Author name', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable post author name', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_post_cat_name',
                'type'      => 'switch',
                'title'     => __('Category name', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the post category name', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_post_date',
                'type'      => 'switch',
                'title'     => __('Post Date', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the post date', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_manual_excerpt',
                'type'      => 'switch',
                'title'     => __('Manual Excerpt', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the manual Excerpt', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_manual_excerpt',
                'type'      => 'switch',
                'title'     => __('Manual Excerpt', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the manual Excerpt', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_nav_arrows',
                'type'      => 'switch',
                'title'     => __('Previous and Next Nav', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable Previous Post and Next Post navigation', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_tags_list',
                'type'      => 'switch',
                'title'     => __('Tags', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the tags list', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_social',
                'type'      => 'switch',
                'title'     => __('Social Share Links', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable social share links panel', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_social_style',
                'type'      => 'radio',
                'title'     => __('Social Share Link Style', 'redux-framework-demo'),
                'subtitle'  => __('Specify social share links panel styling', 'redux-framework-demo'),
                'options'   => array(
                    'social_default' => 'Minimal Links',
                    'social_colors' => 'Colorful Links',
                    'social_default_buttons' => 'Minimal Buttons',
                    'social_colors_buttons' => 'Colorful Buttons',
                ), 
                'default'   => 'social_default'
            ),
            array(
                'id'        => 'single_twitter_user',
                'type'      => 'text',
                'title'     => __('Twitter Username', 'redux-framework-demo'),
                'subtitle'  => __('Your Twitter username for Twitter share link, without @', 'redux-framework-demo'),
            ),
            array(
                'id'        => 'single_rating_box',
                'type'      => 'button_set',
                'title'     => __('Rating Box Position', 'redux-framework-demo'),
                'subtitle'  => __('Specify where to show the rating box', 'redux-framework-demo'),
                'options'   => array(
                    'rating_top' => 'Post Content Top', 
                    'rating_bottom' => 'Post Content Bottom',
                ), 
                'default'   => 'rating_top'
            ),
            array(
                'id'        => 'single_author',
                'type'      => 'switch',
                'title'     => __('Author Box', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the author box', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_slide_dock',
                'type'      => 'switch',
                'title'     => __('Slide Dock', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the slide dock in the bottom right corner', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_related',
                'type'      => 'switch',
                'title'     => __('Related Posts', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the Related Posts box', 'redux-framework-demo'),
                'default'   => 1,
            ),
            array(
                'id'        => 'single_related_posts_show_by',
                'type'      => 'button_set',
                'title'     => __('Show Related Posts By', 'redux-framework-demo'),
                'subtitle'  => __('Specify the Related Posts output', 'redux-framework-demo'),
                'options'   => array(
                    'related_cat' => 'Category',
                    'related_tag' => 'Tag',
                ), 
                'default'   => 'related_cat'
            ),
            array(
                'id'        => 'single_related_posts_to_show',
                'type'      => 'button_set',
                'title'     => __('Number of Related Posts', 'redux-framework-demo'),
                'subtitle'  => __('Specify the number Related Posts to output', 'redux-framework-demo'),
                'options'   => array(
                    '3' => '3',
                    '6' => '6',
                    '9' => '9',
                ), 
                'default'   => '3'
            ),
        ) 
    ) );

    
    // ---> Posts Page
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-file',
        'title'     => __('Posts Page', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'posts_page_info',
                'type'      => 'info',
                'desc'      => __('Posts Page is created under Settings &rarr; Reading. For extended info please see "03. Posts Page" in the documentaion.', 'redux-framework-demo')
            ),
            array(
                'id'        => 'posts_page_title',
                'type'      => 'button_set',
                'title'     => __('Page Title', 'redux-framework-demo'),
                'subtitle'  => __('Specify the page title behavior', 'redux-framework-demo'),
                'options'   => array(
                    'no_title' => 'No Title',
                    'full_width_title' => 'Full Width',
                    'above_content_title' => 'Above The Content'
                ),
                'default'   => 'no_title'
            ),
            array(
                'id'        => 'posts_page_slider',
                'type'      => 'switch',
                'title'     => __('Posts Slider', 'redux-framework-demo'),
                'subtitle'  => __('Enable or Disable the slider.', 'redux-framework-demo'),
                'default'   => 0,
            ),
            array(
                'id'        => 'posts_page_layout',
                'type'      => 'image_select',
                'title'     => __('Posts Layout', 'redux-framework-demo'),
                'subtitle'  => __('Select the page layout', 'redux-framework-demo'),
                'options'   => array(
                    'masonry-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-masonry.png'),
                    'grid-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-grid.png'),
                    'list-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-list.png'),
                    'classic-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-classic.png'),
                ), 
                'default' => 'masonry-layout'
            ),
            array(
                'id'        => 'posts_page_columns',
                'type'      => 'button_set',
                'title'     => __('Number Of Columns', 'redux-framework-demo'),
                'subtitle'  => __('Select the number of columns for this layout', 'redux-framework-demo'),
                'required'  => array(
                    array( 'posts_page_layout', '!=', 'list-layout'),
                    array( 'posts_page_layout', '!=', 'classic-layout')
                ),
                'options'   => array(
                    'columns-size-2' => 'Two',
                    'columns-size-3' => 'Three',
                    'columns-size-4' => 'Four'
                ),
                'default'   => 'columns-size-2'
            ),
        ) 
    ) );

    
    // ---> WooCommerce
    /* If WC plugin is installed and activated */
    if ( class_exists( 'WooCommerce' ) ) :
    
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-shopping-cart',
        'title'     => __('WooCommerce', 'redux-framework-demo'),
        'fields'    => array(
            
            array(
				'id'        => 'smwc_enable_cart_ste_wide',
				'type'      => 'switch',
				'title'     => __('Cart', 'redux-framework-demo'),
				'subtitle'  => __('Enable or Disable cart site wide, not only in shop pages', 'redux-framework-demo'),
				'default'   => 0,
			),
            
            array(
				'id'        => 'smwc_enable_sidebar',
				'type'      => 'switch',
				'title'     => __('Sidebar', 'redux-framework-demo'),
				'subtitle'  => __('Enable or Disable Sidebar on Products Categories', 'redux-framework-demo'),
				'default'   => 0,
			),
		
			array(
				'id'        => 'smwc_product_sorting',
				'type'      => 'switch',
				'title'     => __('Product Sorting', 'redux-framework-demo'),
				'subtitle'  => __('Show or Hide Product Sorting', 'redux-framework-demo'),
				'default'   => 0,
			),
           
            /* Product Item */
            array(
                'id'        => 'smwc_product_item_start',
                'type'      => 'section',
                'title'     => __('Product Item', 'redux-framework-demo'),
                'subtitle'  => __('Product item on Shop Page and on Category Page', 'redux-framework-demo'),
                'indent'    => false,
            ),                array(
                    'id'        => 'smwc_page_layout',
                    'type'      => 'image_select',
                    'title'     => __('Layout', 'redux-framework-demo'),
                    'subtitle'  => __('Select products layout<br /><br /> 1. Masonry<br />2. Grid<br />3. List<br />4. Classic<br />5. Asymmetric<br /><br />', 'redux-framework-demo'),
                    'options'   => array(
                        'masonry-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-masonry.png'),
                        'grid-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-grid.png'),
                        'list-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-list.png'),
                        'classic-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-classic.png'),
                        'asym-layout' => array('img' => get_template_directory_uri() . '/admin/images/to-icon-post-asym.png'),
                    ), 
                    'default' => 'grid-layout'
                ),

                array(
                    'id'        => 'smwc_description_on_image',
                    'type'      => 'switch',
                    'title'     => __('Image Overlay', 'redux-framework-demo'),
                    'subtitle'  => __('Enable or Disable product details over the image on mouseover<br />(Applies only to Masonry or Grid layout)<br /><br />', 'redux-framework-demo'),
                    'required'  => array(
                                    array('smwc_page_layout', 'not', 'list-layout'),
                                    array('smwc_page_layout', 'not', 'classic-layout'),
                                    array('smwc_page_layout', 'not', 'asym-layout')
                                ),
                    'default'   => 1,
                ),
		
                array(
                    'id'        => 'smwc_category_name',
                    'type'      => 'switch',
                    'title'     => __('Category name', 'redux-framework-demo'),
                    'subtitle'  => __('Enable or Disable the post category name', 'redux-framework-demo'),
                    'default'   => 0,
                ),

                array(
                    'id'        => 'smwc_rating_stars',
                    'type'      => 'switch',
                    'title'     => __('Rating Stars', 'redux-framework-demo'),
                    'subtitle'  => __('Enable or Disable the rating stars under the title', 'redux-framework-demo'),
                    'default'   => 0,
                ),

                array(
                    'id'        => 'smwc_add_excerpt',
                    'type'      => 'switch',
                    'title'     => __('Excerpt', 'redux-framework-demo'),
                    'subtitle'  => __('Show or Hide the excerpt on product', 'redux-framework-demo'),
                    'default'   => 0,
                ),

                array(
                    'id'        => 'smwc_add_cart_button',
                    'type'      => 'switch',
                    'title'     => __('Add To Cart button', 'redux-framework-demo'),
                    'subtitle'  => __('Show or Hide the Add To Cart button on Archive Page<br />(The button will appear only on Product Page)', 'redux-framework-demo'),
                    'default'   => 1,
                ),
            
            array(
               'id'        => 'smwc_product_item_end',
               'type'      => 'section',
               'indent'    => false,
           ),
           
            /* Single Product Page */
            array(
               'id'        => 'smwc_single_product_start',
               'type'      => 'section',
               'title'     => __('Single Product Page', 'redux-framework-demo'),
               'indent'    => false,
            ),
		
                    array(
                        'id'        => 'smwc_product_page_slider',
                        'type'      => 'button_set',
                        'title'     => __('Slider on Product Page', 'redux-framework-demo'),
                        'subtitle'  => __('Switch between Images List or Slider on Product Page', 'redux-framework-demo'),
                        'options'   => array(
                            'images_list' => 'Images List', 
                            'images_slider' => 'Images Slider'
                        ), 
                        'default'   => 'images_list'
                    ),

                    array(
                        'id'        => 'smwc_single_title_position',
                        'type'      => 'button_set',
                        'title'     => __('Title Position', 'redux-framework-demo'),
                        'subtitle'  => __('Applies to single product main title', 'redux-framework-demo'),
                        'options'   => array(
                            'fullwidth' => 'Full Width',
                            'abovecontent' => 'Above the Content'
                        ),
                        'default'   => 'fullwidth'
                    ),
            array(
               'id'        => 'smwc_single_product_end',
               'type'      => 'section',
               'indent'    => false,
           ),
            
      ) 
    ) );
    endif;

    // ---> Custom Code
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-glasses',
        'title'     => __('Custom Code', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'custom_css',
                'type'      => 'textarea',
                'title'     => __('Custom CSS', 'redux-framework-demo'),
                'subtitle'  => __('Quickly add some CSS by adding it to this block.', 'redux-framework-demo'),
                'rows'      => 20
            ),
            array(
                'id'        => 'custom_js_header',
                'type'      => 'textarea',
                'title'     => __('Custom JavaScript/Analytics Header', 'redux-framework-demo'),
                'subtitle'  => __('Paste here JavaScript and/or Analytics code wich will appear in the Header of your site. DO NOT include opening and closing script tags.', 'redux-framework-demo'),
                'rows'      => 12
            ),
            array(
                'id'        => 'custom_js_footer',
                'type'      => 'textarea',
                'title'     => __('Custom JavaScript/Analytics Footer', 'redux-framework-demo'),
                'subtitle'  => __('Paste JavaScript and/or Analytics code wich will appear in the Footer of your site. DO NOT include opening and closing script tags.', 'redux-framework-demo'),
                'rows'      => 12
            ),
        )
    ) );


    // ---> Ad Units
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-usd',
        'title'     => __('Ad Units', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'ad_units_info',
                'type'      => 'info',
                'desc'      => __('Add ads in one of the two formats: Image Ad or Code Generated Ad.<br />All ads sizes are unless it is says otherwise:<br />1. With sidebar: 770<br />2. Without sidebar: 1170', 'redux-framework-demo')
            ),
            
            // Header Ads
            array(
                'id'        => 'ad_header_start',
                'type'      => 'section',
                'title'     => __('Header Ad', 'redux-framework-demo'),
                'indent'    => false,
            ),
            array(
                'id'        => 'header_image_ad',
                'type'      => 'media',
                'url'       => true,
                'placeholder'  => __('Click the Upload button to upload the ad image', 'redux-framework-demo'),
                'title'     => __('Ad Image', 'redux-framework-demo'),
                'subtitle'  => __('Best size for header ad image is 728x90', 'redux-framework-demo'),
                'default'  => array(
                    'url' => '',
                ),
            ),
            array(
                'id'            => 'header_image_ad_url',
                'type'          => 'text',
                'title'         => __('Ad link', 'redux-framework-demo'),
                'subtitle'      => __('Enter a full URL of ad link', 'redux-framework-demo'),
                'placeholder'   => 'http://'
            ),
            array(
                'id'        => 'header_code_ad',
                'type'      => 'textarea',
                'title'     => __('Ad Code', 'redux-framework-demo'),
                'subtitle'  => __('Paste the code generated ad. Best size is 728x90', 'redux-framework-demo')
            ),
            array(
                'id'        => 'ad_header_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            // Single above the content
            array(
                'id'        => 'ad_single1_start',
                'type'      => 'section',
                'title'     => __('Single Post - Above the content', 'redux-framework-demo'),
                'indent'    => false,
            ),
            array(
                'id'        => 'single_image_top_ad',
                'type'      => 'media',
                'url'       => true,
                'placeholder'  => __('Click the Upload button to upload the ad image', 'redux-framework-demo'),
                'title'     => __('Ad Image', 'redux-framework-demo'),
                'default'  => array(
                    'url' => '',
                ),
            ),
            array(
                'id'            => 'single_image_top_ad_url',
                'type'          => 'text',
                'title'         => __('Ad link', 'redux-framework-demo'),
                'subtitle'      => __('Enter a full URL of ad link', 'redux-framework-demo'),
                'placeholder'   => 'http://'
            ),
            array(
                'id'        => 'single_code_top_ad',
                'type'      => 'textarea',
                'title'     => __('Ad Code', 'redux-framework-demo'),
            ),
            array(
                'id'        => 'ad_single1_end',
                'type'      => 'section',
                'indent'    => false,
            ),
            

            // Single under the content
            array(
                'id'        => 'ad_single2_start',
                'type'      => 'section',
                'title'     => __('Single Post - Under the content', 'redux-framework-demo'),
                'indent'    => false,
            ),
            array(
                'id'        => 'single_image_bottom_ad',
                'type'      => 'media',
                'url'       => true,
                'placeholder'  => __('Click the Upload button to upload the ad image', 'redux-framework-demo'),
                'title'     => __('Ad Image', 'redux-framework-demo'),
                'default'  => array(
                    'url' => '',
                ),
            ),
            array(
                'id'            => 'single_image_bottom_ad_url',
                'type'          => 'text',
                'title'         => __('Ad link', 'redux-framework-demo'),
                'subtitle'      => __('Enter a full URL of ad link', 'redux-framework-demo'),
                'placeholder'   => 'http://'
            ),
            array(
                'id'        => 'single_code_bottom_ad',
                'type'      => 'textarea',
                'title'     => __('Ad Code', 'redux-framework-demo'),
            ),
            array(
                'id'        => 'ad_single2_end',
                'type'      => 'section',
                'indent'    => false,
            ),

            // Footer
            array(
                'id'        => 'ad_footer_start',
                'type'      => 'section',
                'title'     => __('Footer', 'redux-framework-demo'),
                'indent'    => false,
            ),
            array(
                'id'        => 'footer_image_ad',
                'type'      => 'media',
                'url'       => true,
                'placeholder'  => __('Click the Upload button to upload the ad image', 'redux-framework-demo'),
                'title'     => __('Ad Image', 'redux-framework-demo'),
                'default'  => array(
                    'url' => '',
                ),
            ),
            array(
                'id'            => 'footer_image_ad_url',
                'type'          => 'text',
                'title'         => __('Ad link', 'redux-framework-demo'),
                'subtitle'      => __('Enter a full URL of ad link', 'redux-framework-demo'),
                'placeholder'   => 'http://'
            ),
            array(
                'id'        => 'footer_code_ad',
                'type'      => 'textarea',
                'title'     => __('Ad Code', 'redux-framework-demo')
            ),
            array(
                'id'        => 'ad_footer_end',
                'type'      => 'section',
                'indent'    => false,
            ),
        ) 
    ) );


    // ---> 404 Error Page
    Redux::setSection( $opt_name, array(
        'icon'      => 'el-icon-warning-sign',
        'title'     => __('Page 404', 'redux-framework-demo'),
        'fields'    => array(
            array(
                'id'        => 'error_image',
                'type'      => 'media',
                'url'       => true,
                'placeholder'  => __('Click the Upload button to upload the image', 'redux-framework-demo'),
                'title'     => __('Upload Image', 'redux-framework-demo'),
                'subtitle'  => __('Upload an image for the 404 error page', 'redux-framework-demo'),
                'default'  => array(
                    'url' => get_template_directory_uri() . '/images/error-page.png',
                    'width' => '402',
                    'height' => '402',
                ),
            ),
        )
    ) );

    /*
     * <--- END DECLARATION OF SECTIONS
     */


    
    // Custom CSS to improve the design of Theme Options
    function ti_addPanelCSS() {
        wp_register_style(
            'redux-custom-css',
            get_template_directory_uri().'/admin/css/redux-custom.css',
            array( 'redux-admin-css' ), // Be sure to include redux-admin-css so it's appended after the core css is applied
            time(),
            'all'
        );  
        wp_enqueue_style('redux-custom-css');
    }
    add_action( 'redux/page/ti_option/enqueue', 'ti_addPanelCSS' );

    
    /** remove redux menu under the tools **/
    add_action( 'admin_menu', 'remove_redux_menu', 12 );
    function remove_redux_menu() {
        remove_submenu_page('tools.php','redux-about');
    }


    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    function compiler_action( $options, $css, $changed_values ) {
        echo '<h1>The compiler hook has run!</h1>';
        echo "<pre>";
        print_r( $changed_values ); // Values that have changed since the last save
        echo "</pre>";
        //print_r($options); //Option values
        //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    function dynamic_section( $sections ) {
        //$sections = array();
        $sections[] = array(
            'title'  => __( 'Section via hook', 'redux-framework-demo' ),
            'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
            'icon'   => 'el el-paper-clip',
            // Leave this as a blank section, no options just some intro text set above.
            'fields' => array()
        );

        return $sections;
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    function change_arguments( $args ) {
        //$args['dev_mode'] = true;

        return $args;
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    function change_defaults( $defaults ) {
        $defaults['str_replace'] = 'Testing filter hook!';

        return $defaults;
    }
    
    
    // Remove the demo link and the notice of integrated demo from the redux-framework plugin
    function ti_removeDemoModeLink() { // Be sure to rename this function to something more unique
        if ( class_exists('ReduxFrameworkPlugin') ) {
            remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
        }
        if ( class_exists('ReduxFrameworkPlugin') ) {
            remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
        }
    }
    add_action('init', 'ti_removeDemoModeLink');

    // Remove the demo link and the notice of integrated demo from the redux-framework plugin
    function remove_demo() {

        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            remove_filter( 'plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    }