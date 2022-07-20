<?php
/*
=== Load parent Styles ===
*/
function dc_enqueue_styles() {
	wp_enqueue_style( 'divi-parent', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'divi-parent' ) );
	wp_enqueue_style( 'child-bootstrap', get_stylesheet_directory_uri() . '/css/slick.css');
	wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri() . '/css/slick-theme.css');
    wp_enqueue_style( 'child-color-box', get_stylesheet_directory_uri() . '/css/colorbox.css', false, time() , 'all');
	wp_enqueue_style( 'child-theme-style', get_stylesheet_directory_uri() . '/css/theme-style.css',false, time() , 'all');

    wp_enqueue_script( 'child-theme-slick-js', get_stylesheet_directory_uri() . '/js/slick.min.js', time());
    // wp_enqueue_script( 'child-color-box-js', get_stylesheet_directory_uri() . '/js/jquery.colorbox.js');
    wp_enqueue_script( 'child-theme-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', time());
}
add_action( 'wp_enqueue_scripts', 'dc_enqueue_styles' );

// function myscript() {
// }
// add_action( 'wp_footer', 'myscript' );



function create_posttype() {
    register_post_type( 'case-studies',
        array(
            'labels' => array(
                'name' => __( 'Case Studies' ),
                'singular_name' => __( 'case-studies' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'menu_position' => 53
        )
    );

    register_post_type( 'our-team',
        array(
            'labels' => array(
                'name' => __( 'Our Team' ),
                'singular_name' => __( 'our-team' )
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
            'menu_position' => 53
        )
    );


    register_post_type( 'our-affiliate',
        array(
            'labels' => array(
                'name' => __( 'Our Affiliations' ),
                'singular_name' => __('our-affiliate')
            ),
            'public' => true,
            'supports' => array( 'title', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'has_archive' => true,
            'rewrite' => array('slug' => 'our-affiliate'),
            'show_in_rest' => true,
        )
    );

    register_post_type( 'career',
        array(
            'labels' => array(
                'name' => __( 'Career' ),
                'singular_name' => __('career')
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'has_archive' => true,
            'rewrite' => array('slug' => 'career'),
            'show_in_rest' => true,
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );


function wpb_demo_shortcode() { 
    $html = '';
    $args = array( 'post_type' => 'case-studies', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args ); 

		$html .= '<div class="case-studies case_slider">';
	if ( $the_query->have_posts() ){
	while ( $the_query->have_posts() ){
	$the_query->the_post(); 
		$html .= '<div class="case-studies-col">';
		$html .= '<div class="case_logo '.get_the_title().'">';
		$html .= get_the_post_thumbnail();
		$html .= '</div>';
		$html .= '<h3 class="title"><a href="'.get_the_permalink().'">'. get_the_title() .'</a></h3>';
		$html .= '<p class="designation">'. get_field('case_categories') .'</p>';
		$html .= '<p class="excerpt">'. get_the_excerpt() .'</p>';
		
		$html .= '<a href="'.get_the_permalink().'" class="people_link">Read Case</a>';
		$html .= '</div>';
	}
	wp_reset_postdata(); 
	}
		$html .= '</div>';
    return $html;
	} 
add_shortcode('case_studies', 'wpb_demo_shortcode'); 

function our_affiliate() { 
    $html = '';
    $args = array( 'post_type' => 'our-affiliate', 'posts_per_page' => 3 );
    $the_query = new WP_Query( $args ); 

	if ( $the_query->have_posts() ){
		$html .= '<div class="our-affiliate">';
	while ( $the_query->have_posts() ){
	$the_query->the_post(); 
		$html .= '<div class="our-affiliate-col">';
		$html .= '<div class="our-affiliate-parent '.get_the_title().'">';
		$html .= '<a href="'.get_field('affiliate_url').'" class="aff_link" target="_blank">';
		$html .= get_the_post_thumbnail();
		$html .= '</a>';
		$html .= '<div class="bg_abs">';
		$html .= '<h3 class="title">'. get_the_title() .'</h3>';
		$html .= '<a class="permalink_af" href="'.get_field('affiliate_url').'" target="_blank">Learn More</a>';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';

		
	}
		$html .= '</div>';
	wp_reset_postdata(); 
	}
    return $html;
	} 
add_shortcode('our_affiliate', 'our_affiliate'); 

// function case_studies() { 
 
//     $html = '';
//     $args = array( 'post_type' => 'our-team', 'posts_per_page' => -1 );
//     $the_query = new WP_Query( $args ); 

// 	if ( $the_query->have_posts() ){
// 		$html .= '<div class="team_row">';
// 	while ( $the_query->have_posts() ){
// 	$the_query->the_post(); 
// 		$html .= '<div class="people_col main_page_col">';
// 		$html .= '<h3 class="title"><a>'. get_the_title() .'</a></h3>';
// 		$html .= '<p class="designation">'. get_field('designation') .'</p>';
// 		$wp_auto_p = get_the_content();
// 		$html .= '<div class="content_team">'. wpautop($wp_auto_p) .'</div>';
// 		$html .= '</div>';
// 	}
// 		$html .= '</div>';
// 	wp_reset_postdata(); 
// 	}
//     return $html;
// 	} 
// add_shortcode('case_studies', 'case_studies'); 

function sp_carosel() { 
    $html = '';
    $args = array( 'post_type' => 'sp_logo_carousel', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args ); 

	if ( $the_query->have_posts() ){
		$html .= '<div class="team_row">';
	while ( $the_query->have_posts() ){
	$the_query->the_post(); 
		$html .= '<div class="people_col">';
		$html .= get_the_post_thumbnail();
		$html .= '</div>';
	}
		$html .= '</div>';
	wp_reset_postdata(); 
	}
    return $html;
	} 
add_shortcode('sp_carosel', 'sp_carosel'); 



function kidney_health_blogs() {
            $html = '';
            $html .= '<div class="kidney_row">';
                $html .= '<div class="col8">';
                    $args = array( 
                        'post_type' => 'post',
                        'posts_per_page' => 2,
                        'order' => 'date'
                    );
                        $the_query = new WP_Query( $args ); 
                        if ( $the_query->have_posts() ){
                            while ($the_query->have_posts() ){
                                $the_query->the_post(); 
                                $html .= '<div class="customgrid-left">';
                                $pst_id = get_the_ID();
                                $category_detail = get_the_category($pst_id);//$post->ID
                              

                                $html .= '<div class="img_blg">
                                <a href='. get_the_permalink() .'>' . get_the_post_thumbnail(null , 'blg_sqaure') .'</a></div>';
                                    $html .= "<div class='blg_content'>";
                                    $html .= "<div class='cate_p'>";
                                    $html .= $category_detail[0]->name;
                                    $html .= "</div>";
                                 $html .= '<h3 class="title"><a href='. get_the_permalink() .'>'. get_the_title() .'</a></h3>';

                                $html .= '<p class="kidney_row_excerpt">';
                                $html .= get_the_excerpt();
                                $html .= '</p>';
                                    $html .= "</div>";
                                $html .= '</div>';
                            }
                        wp_reset_postdata(); 

                        }
                $html .= '</div>';
                $html .= '<div class="col4">';
                $args = array( 
                        'post_type' => 'post',
                        'posts_per_page' => 5,
                        'order' => 'date'
                    );
                        $the_query = new WP_Query( $args ); 
                        if ( $the_query->have_posts() ){
                            $i = 1;
                            while ($the_query->have_posts() ){
                                $the_query->the_post(); 
                                $count = $i++;
                                if ($count == 1 || $count == 2) {
                                } else{
                                $html .= '<div class="customgrid-right">';
                                $html .= "<div class='cate_p'>";
                                $html .= $category_detail[0]->name;
                                $html .= "</div>";
                                 $html .= '<h3 class="title"><a href='. get_the_permalink() .'>'. get_the_title() .'</a></h3>';

                                $html .= '</div>';
                                }
                            }
                        wp_reset_postdata(); 

                        }
                $html .= '</div>';

            $html .= '</div>';
    
                	return $html;
}
add_shortcode('kidney_health_blogs', 'kidney_health_blogs'); 

add_image_size( 'blg_sqaure', 200, 200, true ); // Hard Crop Mode


function careers_shortcode() { 
    $html = '';
    $args = array( 'post_type' => 'career', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args ); 

	if ( $the_query->have_posts() ){
		$html .= '<div class="our-careers">';
	while ( $the_query->have_posts() ){
	$the_query->the_post(); 
		$html .= '<div class="our-careers-col">';
		$html .= '<div class="our-careers-parent '.get_the_title().'">';
		$html .= get_the_post_thumbnail();
		$html .= '<div class="bg_abs">';
		$html .= '<h3 class="title">'. get_the_title() .'</h3>';
		$html .= '<p class="excertp">'. get_the_content() .'</p>';
		$html .= '<a class="permalink_af" href="'.get_field('apply_now_button_url').'" target="_blank">APPLY NOW</a>';
		$html .= '</div>';

		$html .= '</div>';
		$html .= '</div>';

		
	}
		$html .= '</div>';
	wp_reset_postdata(); 
	}
    return $html;
	} 
add_shortcode('careers_shortcode', 'careers_shortcode'); 

function newcase() { 
    $html = '';
    $args = array( 'post_type' => 'case-studies', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args ); 

        $html .= '<div class="case-studies case_page clearfix">';
    if ( $the_query->have_posts() ){
    while ( $the_query->have_posts() ){
    $the_query->the_post(); 
        $html .= '<div class="case-studies-col">';
        $html .= '<div class="case_logo '.get_the_title().'">';
        $html .= get_the_post_thumbnail();
        $html .= '</div>';
        $html .= '<h3 class="title"><a href="'.get_the_permalink().'">'. get_the_title() .'</a></h3>';
        $html .= '<p class="designation">'. get_field('case_categories') .'</p>';
        $html .= '<p class="excerpt">'. get_the_excerpt() .'</p>';
        $html .= '<a href="'.get_the_permalink().'" class="people_link">Read Case</a>';
        $html .= '</div>';
    }
    wp_reset_postdata(); 
    }
        $html .= '</div>';
    return $html;
    } 
add_shortcode('case_main', 'newcase'); 


add_image_size( 'team-image-size', 299, 299, true ); // Hard Crop Mode

function our_team12() { 
    $html = '';
    $args = array( 'post_type' => 'our-team', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args ); 

        $html .= '<div class="our_team-div">';
    if ( $the_query->have_posts() ){
    while ( $the_query->have_posts() ){
    $the_query->the_post(); 
        $html .= '<div class="our_team-div-col">';
        $html .= '<div class="our_team-div-img '.get_the_title().'">';
        $html .= get_the_post_thumbnail(null, 'team-image-size');
        $html .= '</div>';
        $html .= '<h3 class="title"><a href="'.get_the_permalink().'">'. get_the_title() .'</a></h3>';
        $html .= '<p class="designation">'. get_field('case_categories') .'</p>';
        $html .= '<p class="excerpt">'. get_the_excerpt() .'</p>';
        $html .= '</div>';
    }
    wp_reset_postdata(); 
    }
        $html .= '</div>';
    return $html;
    } 
// add_shortcode('our_team', 'our_team'); 

add_shortcode("our_team","our_team");
function our_team(){
    $html = '';
            $html .='<section class="all-team">';
                    $html .='<div class="row">';
                    $args = array(
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'post_type' => 'our-team',
                        'order' => 'DES',
                    ); 
                    $loop = new WP_Query( $args );
                    while ( $loop->have_posts() ){ $loop->the_post();
                        $html .='<div class="individual-team col-md-3 col-sm-6">';
                            $html .='<div class="box">';
                                $post_id = get_the_ID();
                                    $html .='<span class="team-image">';
                                        if (has_post_thumbnail()){
if (get_field('linkedin_profile_url')) {
$html .='<a href="'. get_field('linkedin_profile_url') .'" target="_blank">';
$html .= get_the_post_thumbnail($post_id,'team-image-size', array( 'class' => 'circle-image size196x196' ) );                 
$html .='</a>'; 
} else{
$html .= get_the_post_thumbnail($post_id,'team-image-size', array( 'class' => 'circle-image size196x196' ) );                 
}
                                        }
                                    $html .='</span>';

                                    $title = get_the_title();
                                    if (get_field('linkedin_profile_url')){
                            $html .='<a href="'. get_field('linkedin_profile_url') .'" target="_blank">';
                            $html .='<h3 class="name">'.$title.'</h3>'; 
                            $html .='</a>'; 
                            } else{
                            $html .='<h3 class="name">'.$title.'</h3>'; 
                            }
                                            $team_designation = get_field("designation");
                                        $html.='<p class="designation">'.$team_designation.'</p>'; 
                                $html .='<p class="team-excerpt">'.wp_trim_words(get_the_excerpt(), 12).'</p>';
                            
                                    //$content= get_the_content(); 
                                    //$html .=  $content;
                                    
                                    $html .='<a class="read-btn team_'.$post_id.'" title="Read More" href="#team'.$post_id.'">Read more</a>';
                            $html .='</div>';
                        $html .='</div>';


					$html .= '<script type="text/javascript"> jQuery(window).load(function () {
					    jQuery(".team_'.$post_id.'").click(function(){
					       jQuery("#team'.$post_id.'").show();
					    });
					    jQuery(".hover_bkgr_fricc").click(function(){
					        jQuery("#team'.$post_id.'").hide();
					    });
					    jQuery(".popupCloseButton").click(function(){
					        jQuery("#team'.$post_id.'").hide();
					    });
					});</script>';
                    
                    
                        $html .='<div class="hover_bkgr_fricc" id="team'.$post_id.'">
						    <span class="helper"></span>
						    <div>
						        <div class="popupCloseButton">&times;</div>';
                        $html .='<div  class="popBox team-popup">';
                        $html .='<span class="team-image">';
                        if (has_post_thumbnail()){
                        if (get_field('linkedin_profile_url')) {
                        $html .='<a href="'. get_field('linkedin_profile_url') .'" target="_blank">';
                        $html .= get_the_post_thumbnail($post_id,'team-image-size', array( 'class' => 'circle-image size196x196' ) );                 
                        $html .='</a>'; 
                        } else{
                        $html .= get_the_post_thumbnail($post_id,'team-image-size', array( 'class' => 'circle-image size196x196' ) );                 

                        }
                        } 
                        $html .='</span>';
                        $title = get_the_title();
                        if (get_field('linkedin_profile_url')) {
                        $html .='<a href="'. get_field('linkedin_profile_url') .'"  target="_blank">' ;
                        $html .='<h6 class="name">'.$title.'</h6>'; 
                        $html .='</a>'; 
                        } else{
                        $html .='<h6 class="name">'.$title.'</h6>'; 
                        }
                        $team_designation = get_field("teamsteam-designation");
                        $html.='<p class="designation">'.$team_designation.'</p>'; 
                        $content= get_the_content(); 
                        $html .=  $content;


                        $html .='</div>';
                        $html .= '</div></div>';

                    
                         }
                    $html .='</div>';
            $html .='</section>';
            wp_reset_postdata();
    return $html;
}
/*All Team */