<?php
defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/inc/frontend-password-protection.php';

function wpbb_travel_project_mode( $mode ) { return 'travel'; }
add_filter( 'wp_theme_project_mode', 'wpbb_travel_project_mode' );

function wpbb_travel_assets() {
    $theme = wp_get_theme();
    $manifest = get_stylesheet_directory() . '/dist/.vite/manifest.json';
    if ( ! is_readable( $manifest ) ) return;
    $data = json_decode( (string) file_get_contents( $manifest ), true );
    if ( ! is_array( $data ) ) return;
    if ( ! empty( $data['src/scss/public.scss']['file'] ) ) {
        wp_enqueue_style( 'wpbb-travel-app', get_stylesheet_directory_uri() . '/dist/' . ltrim( $data['src/scss/public.scss']['file'], '/' ), array(), $theme->get( 'Version' ) );
        if ( function_exists( 'wp_theme_sector_customizer_css' ) ) wp_add_inline_style( 'wpbb-travel-app', wp_theme_sector_customizer_css( '#185B57', '18px', '--sector-primary', '--sector-radius' ) );
    }
    if ( ! empty( $data['src/js/main.js']['file'] ) ) wp_enqueue_script( 'wpbb-travel-app', get_stylesheet_directory_uri() . '/dist/' . ltrim( $data['src/js/main.js']['file'], '/' ), array(), $theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'wpbb_travel_assets', 30 );

function wpbb_travel_dark_mode_bootstrap() { echo '<script>(function(){try{var m=localStorage.getItem("wpThemeMode");if(m==="dark"){document.documentElement.classList.add("is-dark-theme");document.documentElement.setAttribute("data-theme","dark");}}catch(e){}})();</script>'; }
add_action( 'wp_head', 'wpbb_travel_dark_mode_bootstrap', 1 );


function wpbb_travel_demo_profile( $profile ) {
    $assets = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/img/demo/';
    return array_merge( $profile, array(
        'id'=>'travel', 'name'=>__( 'Travel Agency', 'wp-bbtheme-child-travel' ), 'commerce'=>false,
        'eyebrow'=>__( 'Curated journeys, clear planning', 'wp-bbtheme-child-travel' ), 'hero_title'=>__( 'Travel that feels considered from the first search.', 'wp-bbtheme-child-travel' ), 'hero_text'=>__( 'Search destinations, styles, dates and budgets, then turn a shortlist into a useful conversation with a travel specialist.', 'wp-bbtheme-child-travel' ),
        'hero_image'=>$assets . 'hero-photo.jpg', 'about_image'=>$assets . 'about-photo.jpg',
        'primary_label'=>__( 'Find a trip', 'wp-bbtheme-child-travel' ), 'primary_url'=>'#finder',
        'secondary_label'=>__( 'Explore services', 'wp-bbtheme-child-travel' ), 'secondary_url'=>wp_theme_demo_page_url( 'services' ),
        'services_eyebrow'=>__( 'What we do', 'wp-bbtheme-child-travel' ), 'services_heading'=>__( 'Planning, booking and support for trips worth taking.', 'wp-bbtheme-child-travel' ),
        'about_eyebrow'=>__( 'Why choose us', 'wp-bbtheme-child-travel' ), 'about_title'=>__( 'Travel planning with expert context, not endless tabs.', 'wp-bbtheme-child-travel' ), 'about_text'=>__( 'Destination expertise, transparent trip details and enquiry journeys that keep planning personal.', 'wp-bbtheme-child-travel' ),
        'industries_eyebrow'=>__( 'Built around your needs', 'wp-bbtheme-child-travel' ), 'industries_heading'=>__( 'Choose by destination, pace, interests or travel style.', 'wp-bbtheme-child-travel' ),
        'process_eyebrow'=>__( 'How it works', 'wp-bbtheme-child-travel' ), 'process_heading'=>__( 'Search, compare, ask the right questions, then book with confidence.', 'wp-bbtheme-child-travel' ), 'faq_heading'=>__( 'Practical answers before you travel.', 'wp-bbtheme-child-travel' ),
        'services'=>array(array( __( 'Tailor-made trips', 'wp-bbtheme-child-travel' ), __( 'Shape an itinerary around dates, interests and the pace you prefer.', 'wp-bbtheme-child-travel' ) ),
array( __( 'Flight & stay planning', 'wp-bbtheme-child-travel' ), __( 'Bring transport, hotels and transfers into one clear plan.', 'wp-bbtheme-child-travel' ) ),
array( __( 'Traveller support', 'wp-bbtheme-child-travel' ), __( 'Keep useful help available before departure and while away.', 'wp-bbtheme-child-travel' ) )), 'industries'=>array(array( __( 'City & culture', 'wp-bbtheme-child-travel' ), __( 'Short breaks and deeper cultural itineraries.', 'wp-bbtheme-child-travel' ) ),
array( __( 'Beach & slow travel', 'wp-bbtheme-child-travel' ), __( 'Relaxed stays built around time, place and good logistics.', 'wp-bbtheme-child-travel' ) ),
array( __( 'Adventure', 'wp-bbtheme-child-travel' ), __( 'Active trips with a clearer view of difficulty and inclusions.', 'wp-bbtheme-child-travel' ) ),
array( __( 'Family travel', 'wp-bbtheme-child-travel' ), __( 'Practical itineraries for different ages and needs.', 'wp-bbtheme-child-travel' ) )), 'stats'=>array(array( '24/7', __( 'Traveller assistance', 'wp-bbtheme-child-travel' ) ),
array( '35+', __( 'Curated destinations', 'wp-bbtheme-child-travel' ) ),
array( '4.9', __( 'Traveller rating', 'wp-bbtheme-child-travel' ) ),
array( '1', __( 'Clear trip finder', 'wp-bbtheme-child-travel' ) )), 'process'=>array(array( '01', __( 'Search', 'wp-bbtheme-child-travel' ), __( 'Filter trips by destination, style, duration and budget.', 'wp-bbtheme-child-travel' ) ),
array( '02', __( 'Compare', 'wp-bbtheme-child-travel' ), __( 'Review practical details, inclusions and travel pace.', 'wp-bbtheme-child-travel' ) ),
array( '03', __( 'Enquire', 'wp-bbtheme-child-travel' ), __( 'Send dates and traveller details to start planning.', 'wp-bbtheme-child-travel' ) )),
        'cta_title'=>__( 'Start with the trip you want to remember.', 'wp-bbtheme-child-travel' ), 'cta_text'=>__( 'Search by destination and style, then send the details our travel team needs to shape the next step.', 'wp-bbtheme-child-travel' ), 'footer_text'=>__( 'Curated holidays, specialist journeys and practical planning support.', 'wp-bbtheme-child-travel' ),
        'page_labels'=>array('about'=>__( 'About', 'wp-bbtheme-child-travel' ),'services'=>__( 'Services', 'wp-bbtheme-child-travel' ),'industries'=>__( 'Solutions', 'wp-bbtheme-child-travel' ),'contact'=>__( 'Contact', 'wp-bbtheme-child-travel' ),'blog'=>__( 'Insights', 'wp-bbtheme-child-travel' )),
        'palette'=>array('theme_brand_color'=>'#185B57','theme_accent_color'=>'#D0793D','theme_background_color'=>'#f7f8fb','theme_surface_color'=>'#ffffff','theme_border_color'=>'#dfe4ee','theme_radius'=>'22px')
    ) );
}
add_filter( 'wp_theme_demo_profile', 'wpbb_travel_demo_profile', 20 );


function wpbb_travel_pattern_markup( $name ) {
    $path = get_stylesheet_directory() . '/patterns/' . sanitize_file_name( $name ) . '.php';
    if ( ! is_readable( $path ) ) return '';
    ob_start(); include $path; return trim( (string) ob_get_clean() );
}

function wpbb_travel_extra_home_sections( $content, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return $content;
    return $content . wpbb_travel_pattern_markup( 'sector-proof' );
}
add_filter( 'wp_theme_demo_extra_home_sections', 'wpbb_travel_extra_home_sections', 25, 2 );

function wpbb_travel_blog_profile( $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return $profile;
    $profile['blog_eyebrow'] = __( 'Insights', 'wp-bbtheme-child-travel' );
    $profile['blog_archive_title'] = __( 'Destination ideas and practical travel guidance.', 'wp-bbtheme-child-travel' );
    $profile['blog_archive_intro'] = __( 'Useful guides on places, timing, itineraries and planning well.', 'wp-bbtheme-child-travel' );
    return $profile;
}
add_filter( 'wp_theme_demo_profile', 'wpbb_travel_blog_profile', 90 );


function wpbb_travel_demo_attachment( $filename, $title ) {
    $slug = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_page_by_path( 'wpbb-travel-' . $slug, OBJECT, 'attachment' );
    if ( $existing ) return $existing->ID;
    $source = get_stylesheet_directory() . '/assets/img/demo/' . basename( $filename );
    if ( ! is_readable( $source ) ) return 0;
    $uploads = wp_upload_dir(); $dir = trailingslashit( $uploads['basedir'] ) . 'wpbb-travel'; wp_mkdir_p( $dir );
    $target = $dir . '/' . basename( $filename ); if ( ! file_exists( $target ) ) copy( $source, $target );
    $filetype = wp_check_filetype( $target );
    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
    $id = wp_insert_attachment( array( 'post_mime_type'=>$filetype['type'] ?: 'image/jpeg', 'post_title'=>$title, 'post_name'=>'wpbb-travel-' . $slug, 'post_status'=>'inherit' ), $target );
    if ( $id && ! is_wp_error( $id ) ) {
        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
        $meta = wpbb_child_381048_generate_attachment_metadata( $id, $target ); if ( $meta ) wp_update_attachment_metadata( $id, $meta ); update_post_meta( $id, '_wp_attachment_image_alt', $title );
        return (int) $id;
    }
    return 0;
}

function wpbb_travel_register_directory() {
    register_post_type( 'trip', array(
        'labels'=>array('name'=>__( 'Trips', 'wp-bbtheme-child-travel' ),'singular_name'=>__( 'Trip', 'wp-bbtheme-child-travel' ),'add_new_item'=>__( 'Add Trip', 'wp-bbtheme-child-travel' )),
        'public'=>true,'show_in_rest'=>true,'has_archive'=>'trips','rewrite'=>array('slug'=>'trips'),'menu_icon'=>'dashicons-airplane','supports'=>array('title','editor','excerpt','thumbnail','page-attributes')
    ) );
    register_taxonomy( 'trip_destination', 'trip', array( 'label'=>__( 'Destinations', 'wp-bbtheme-child-travel' ), 'public'=>true, 'show_in_rest'=>true, 'hierarchical'=>true, 'rewrite'=>array('slug'=>'destination') ) ); register_taxonomy( 'travel_style', 'trip', array( 'label'=>__( 'Travel styles', 'wp-bbtheme-child-travel' ), 'public'=>true, 'show_in_rest'=>true, 'hierarchical'=>true, 'rewrite'=>array('slug'=>'travel-style') ) );
}
add_action( 'init', 'wpbb_travel_register_directory', 12 );

function wpbb_travel_meta_fields() { return array('price'=>__( 'From price', 'wp-bbtheme-child-travel' ),'duration_days'=>__( 'Duration (days)', 'wp-bbtheme-child-travel' ),'departure'=>__( 'Next departure', 'wp-bbtheme-child-travel' ),'group_size'=>__( 'Typical group size', 'wp-bbtheme-child-travel' ),'rating'=>__( 'Traveller rating', 'wp-bbtheme-child-travel' )); }
function wpbb_travel_meta_box() { add_meta_box( 'wpbb-travel-details', __( 'Trip details', 'wp-bbtheme-child-travel' ), 'wpbb_travel_meta_box_render', 'trip', 'normal', 'high' ); }
add_action( 'add_meta_boxes', 'wpbb_travel_meta_box' );
function wpbb_travel_meta_box_render( $post ) {
    wp_nonce_field( 'wpbb_travel_save', 'wpbb_travel_nonce' ); echo '<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px">';
    foreach ( wpbb_travel_meta_fields() as $key=>$label ) { $value=get_post_meta($post->ID,'_travel_'.$key,true); echo '<label><strong>'.esc_html($label).'</strong><input class="widefat" type="text" name="wpbb_travel['.esc_attr($key).']" value="'.esc_attr($value).'"></label>'; } echo '</div>';
}
function wpbb_travel_save_meta( $post_id ) {
    if ( empty($_POST['wpbb_travel_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wpbb_travel_nonce'])),'wpbb_travel_save') || !current_user_can('edit_post',$post_id) ) return;
    $values=isset($_POST['wpbb_travel'])&&is_array($_POST['wpbb_travel'])?wp_unslash($_POST['wpbb_travel']):array(); foreach(wpbb_travel_meta_fields() as $key=>$label) update_post_meta($post_id,'_travel_'.$key,sanitize_text_field($values[$key]??''));
}
add_action( 'save_post_trip', 'wpbb_travel_save_meta' );

function wpbb_travel_directory_configs( $configs ) {
    $configs['travel'] = array(
      'post_type'=>'trip','eyebrow'=>__( 'Trip finder', 'wp-bbtheme-child-travel' ),'title'=>__( 'Find a trip that fits the way you want to travel.', 'wp-bbtheme-child-travel' ),'intro'=>__( 'Start with destination or style, then narrow by budget and duration.', 'wp-bbtheme-child-travel' ),'keyword_label'=>__( 'Search trips', 'wp-bbtheme-child-travel' ),'keyword_placeholder'=>__( 'Destination, activity or trip name', 'wp-bbtheme-child-travel' ),'button_label'=>__( 'Find trips', 'wp-bbtheme-child-travel' ),'results_label'=>__( 'trips to consider', 'wp-bbtheme-child-travel' ),'limit'=>8,'default_sort'=>'featured',
      'filters'=>array(array('type'=>'taxonomy','key'=>'destination','label'=>__( 'Destination', 'wp-bbtheme-child-travel' ),'taxonomy'=>'trip_destination','all_label'=>'Any destination'),array('type'=>'taxonomy','key'=>'style','label'=>__( 'Travel style', 'wp-bbtheme-child-travel' ),'taxonomy'=>'travel_style','all_label'=>'Any style'),array('type'=>'meta_max','key'=>'max_price','label'=>__( 'Max budget', 'wp-bbtheme-child-travel' ),'meta_key'=>'_travel_price','placeholder'=>'No max','step'=>100),array('type'=>'meta_max','key'=>'max_days','label'=>__( 'Max duration', 'wp-bbtheme-child-travel' ),'meta_key'=>'_travel_duration_days','placeholder'=>'Any','step'=>1)),'sorts'=>array('featured'=>array('label'=>__( 'Recommended', 'wp-bbtheme-child-travel' ),'orderby'=>'menu_order','order'=>'ASC'),'price-asc'=>array('label'=>__( 'Price: low to high', 'wp-bbtheme-child-travel' ),'orderby'=>'meta_value_num','order'=>'ASC','meta_key'=>'_travel_price'),'price-desc'=>array('label'=>__( 'Price: high to low', 'wp-bbtheme-child-travel' ),'orderby'=>'meta_value_num','order'=>'DESC','meta_key'=>'_travel_price')),'card_taxonomies'=>array('trip_destination','travel_style'),'card_meta'=>array(array('key'=>'_travel_price','label'=>__( 'From', 'wp-bbtheme-child-travel' ),'format'=>'money','currency'=>'£'),array('key'=>'_travel_duration_days','label'=>__( 'Duration', 'wp-bbtheme-child-travel' ),'suffix'=>' days'),array('key'=>'_travel_departure','label'=>__( 'Departure', 'wp-bbtheme-child-travel' )),array('key'=>'_travel_rating','label'=>__( 'Rating', 'wp-bbtheme-child-travel' ),'suffix'=>'/5')),'card_button'=>__( 'View trip', 'wp-bbtheme-child-travel' )
    ); return $configs;
}
add_filter( 'wp_theme_sector_directory_configs', 'wpbb_travel_directory_configs' );

function wpbb_travel_seed_directory( $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return;
    $rows=array(array('title'=>'Coastal Portugal','slug'=>'coastal-portugal','excerpt'=>'Lisbon, the Alentejo coast and Porto at an unhurried pace.','content'=>'Lisbon, the Alentejo coast and Porto at an unhurried pace.','terms'=>array('trip_destination'=>'Portugal','travel_style'=>'Culture & coast'),'meta'=>array('price'=>'1650','duration_days'=>'9','departure'=>'18 Sep 2026','group_size'=>'2–10','rating'=>'4.9'),'image'=>'item-1.jpg'),array('title'=>'Nordic Escape','slug'=>'nordic-escape','excerpt'=>'Copenhagen, fjords and quiet coastal stays across Scandinavia.','content'=>'Copenhagen, fjords and quiet coastal stays across Scandinavia.','terms'=>array('trip_destination'=>'Scandinavia','travel_style'=>'Nature & design'),'meta'=>array('price'=>'2250','duration_days'=>'8','departure'=>'4 Oct 2026','group_size'=>'2–8','rating'=>'4.8'),'image'=>'item-2.jpg'),array('title'=>'Japan by Rail','slug'=>'japan-by-rail','excerpt'=>'Tokyo, Kyoto and the Japanese Alps with rail travel built in.','content'=>'Tokyo, Kyoto and the Japanese Alps with rail travel built in.','terms'=>array('trip_destination'=>'Japan','travel_style'=>'Rail journey'),'meta'=>array('price'=>'3490','duration_days'=>'13','departure'=>'9 Nov 2026','group_size'=>'2–12','rating'=>'4.9'),'image'=>'item-3.jpg'),array('title'=>'Greek Island Slowdown','slug'=>'greek-island-slowdown','excerpt'=>'A relaxed island itinerary with small hotels and private transfers.','content'=>'A relaxed island itinerary with small hotels and private transfers.','terms'=>array('trip_destination'=>'Greece','travel_style'=>'Beach & slow'),'meta'=>array('price'=>'1790','duration_days'=>'10','departure'=>'22 May 2027','group_size'=>'2–6','rating'=>'4.7'),'image'=>'item-4.jpg'),array('title'=>'Andalusia Food Journey','slug'=>'andalusia-food-journey','excerpt'=>'Markets, tapas, vineyards and historic cities across southern Spain.','content'=>'Markets, tapas, vineyards and historic cities across southern Spain.','terms'=>array('trip_destination'=>'Spain','travel_style'=>'Food & culture'),'meta'=>array('price'=>'1420','duration_days'=>'7','departure'=>'12 Mar 2027','group_size'=>'4–12','rating'=>'4.8'),'image'=>'item-5.jpg'),array('title'=>'Costa Rica Active','slug'=>'costa-rica-active','excerpt'=>'Rainforest walks, wildlife and Pacific coast adventures.','content'=>'Rainforest walks, wildlife and Pacific coast adventures.','terms'=>array('trip_destination'=>'Costa Rica','travel_style'=>'Adventure'),'meta'=>array('price'=>'2890','duration_days'=>'11','departure'=>'6 Feb 2027','group_size'=>'4–10','rating'=>'4.9'),'image'=>'item-6.jpg'));
    foreach($rows as $i=>$row){
      foreach($row['terms'] as $tax=>$term) if(taxonomy_exists($tax)&&!term_exists($term,$tax)) wp_insert_term($term,$tax);
      $existing=get_page_by_path($row['slug'],OBJECT,'trip'); $args=array('post_type'=>'trip','post_status'=>'publish','post_title'=>$row['title'],'post_name'=>$row['slug'],'menu_order'=>$i,'post_excerpt'=>$row['excerpt'],'post_content'=>'<!-- wp:paragraph --><p>'.esc_html($row['content']).'</p><!-- /wp:paragraph -->');
      if($existing){$args['ID']=$existing->ID;$id=wp_update_post($args);}else{$id=wp_insert_post($args);} if(!$id||is_wp_error($id))continue;
      foreach($row['terms'] as $tax=>$term)wp_set_object_terms($id,$term,$tax); foreach($row['meta'] as $key=>$value)update_post_meta($id,'_travel_'.$key,$value); $img=wpbb_travel_demo_attachment($row['image'],$row['title']); if($img)set_post_thumbnail($id,$img); update_post_meta($id,'_wp_theme_demo_trip',1);
    }
}
add_action( 'wp_theme_seed_sector_pages', 'wpbb_travel_seed_directory', 25 );

function wpbb_travel_after_hero_finder( $content, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return $content;
    return $content . '<!-- wp:group {"className":"wp-theme-section-shell wpbb-travel-finder-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wpbb-travel-finder-section"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><!-- wp:wpbb/sector-finder {"context":"travel","limit":8} /--><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';
}
add_filter( 'wp_theme_demo_after_hero_sections', 'wpbb_travel_after_hero_finder', 20, 2 );

function wpbb_travel_navigation( $items, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return $items;
    array_splice( $items, 1, 0, array( array('key'=>'trip','title'=>__( 'Trips', 'wp-bbtheme-child-travel' ),'type'=>'post_type_archive','object'=>'trip','locations'=>array('header','footer')) ) ); return $items;
}
add_filter( 'wp_theme_demo_navigation_items', 'wpbb_travel_navigation', 20, 2 );

function wpbb_travel_header_search_types( $types ) { if(post_type_exists('trip'))$types[]='trip'; return array_values(array_unique($types)); }
add_filter( 'wp_theme_header_search_post_types', 'wpbb_travel_header_search_types' );

function wpbb_travel_single_content( $content ) {
    if ( !is_singular('trip') || !in_the_loop() || !is_main_query() ) return $content; $content=wpbb_child_381043_dedupe_single_body($content,get_the_excerpt()); $id=get_the_ID(); $image=get_the_post_thumbnail_url($id,'large'); $gallery = function_exists( 'wpbb_child_381045_gallery_single_markup' ) ? wpbb_child_381045_gallery_single_markup( $id ) : ''; if ( ! $gallery && function_exists( 'wp_theme_item_gallery_single_markup' ) ) $gallery = wp_theme_item_gallery_single_markup( $id );
    $facts=''; foreach(wpbb_travel_meta_fields() as $key=>$label){$value=get_post_meta($id,'_travel_'.$key,true);if(''!==trim((string)$value))$facts.='<div><small>'.esc_html($label).'</small><strong>'.esc_html($value).'</strong></div>';}
    $html='<section class="wpbb-sector-single"><div class="container"><div class="wpbb-sector-single__hero"><div class="wpbb-sector-single__media">'.($gallery?:($image?'<img src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'">':'')).'</div><div><p class="wp-theme-sector-eyebrow">'.esc_html('Trip').'</p><h1>'.esc_html(get_the_title()).'</h1><p class="wp-theme-sector-lead">'.esc_html(get_the_excerpt()).'</p><div class="wpbb-sector-single__facts">'.$facts.'</div></div></div><div class="wpbb-sector-single__content">'.$content.'</div>';
    if(function_exists('wpbb_travel_request_form'))$html.=wpbb_travel_request_form($id); return $html.'</div></section>';
}
add_filter( 'the_content', 'wpbb_travel_single_content', 25 );

function wpbb_travel_polylang_post_types( $types, $settings ) { $types['trip']='trip'; return $types; }
add_filter( 'pll_get_post_types', 'wpbb_travel_polylang_post_types', 10, 2 );
function wpbb_travel_pll_trip_destination( $tax, $settings ) { $tax['trip_destination']='trip_destination'; return $tax; }
add_filter( 'pll_get_taxonomies', 'wpbb_travel_pll_trip_destination', 10, 2 );
function wpbb_travel_pll_travel_style( $tax, $settings ) { $tax['travel_style']='travel_style'; return $tax; }
add_filter( 'pll_get_taxonomies', 'wpbb_travel_pll_travel_style', 10, 2 );

function wpbb_travel_register_requests() { register_post_type('trip_enquiry',array('labels'=>array('name'=>__( 'Trip Enquiries', 'wp-bbtheme-child-travel' ),'singular_name'=>__( 'Trip Enquiry', 'wp-bbtheme-child-travel' )),'public'=>false,'show_ui'=>true,'show_in_menu'=>'edit.php?post_type=trip','supports'=>array('title'))); }
add_action('init','wpbb_travel_register_requests',14);
function wpbb_travel_request_form( $object_id ) {
    $success=isset($_GET['request'])&&'received'===sanitize_key(wp_unslash($_GET['request'])); ob_start(); ?>
    <div class="wpbb-sector-request" id="request"><p class="wp-theme-sector-eyebrow"><?php echo esc_html(__( 'Plan this trip', 'wp-bbtheme-child-travel' )); ?></p><h2><?php echo esc_html(__( 'Tell us the dates and travellers you have in mind.', 'wp-bbtheme-child-travel' )); ?></h2><?php if($success):?><div class="alert alert-success"><?php echo esc_html(__( 'Thanks. Your travel enquiry has been received.', 'wp-bbtheme-child-travel' )); ?></div><?php endif;?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"><input type="hidden" name="action" value="wpbb_travel_submit_request"><input type="hidden" name="object_id" value="<?php echo esc_attr($object_id); ?>"><?php wp_nonce_field('wpbb_travel_request_'.$object_id,'wpbb_travel_request_nonce'); ?>
      <?php echo '<label class=""><span>'.esc_html(__( 'Name', 'wp-bbtheme-child-travel' )).'</span><input type="text" name="name" required></label>' . '<label class=""><span>'.esc_html(__( 'Email', 'wp-bbtheme-child-travel' )).'</span><input type="email" name="email" required></label>' . '<label class=""><span>'.esc_html(__( 'Phone', 'wp-bbtheme-child-travel' )).'</span><input type="tel" name="phone"></label>' . '<label class=""><span>'.esc_html(__( 'Preferred departure', 'wp-bbtheme-child-travel' )).'</span><input type="date" name="departure_date"></label>' . '<label class=""><span>'.esc_html(__( 'Travellers', 'wp-bbtheme-child-travel' )).'</span><input type="number" name="travellers" min="1" required></label>' . '<label class="is-wide"><span>'.esc_html(__( 'Questions or requirements', 'wp-bbtheme-child-travel' )).'</span><textarea name="message" rows="5"></textarea></label>'; ?><button class="btn btn-primary" type="submit"><?php echo esc_html(__( 'Send trip enquiry', 'wp-bbtheme-child-travel' )); ?></button>
    </form></div><?php return ob_get_clean();
}
function wpbb_travel_submit_request() {
    $object_id=absint($_POST['object_id']??0); if(!$object_id||'trip'!==get_post_type($object_id))wp_die(esc_html(__( 'Invalid request.', 'wp-bbtheme-child-travel' ))); if(empty($_POST['wpbb_travel_request_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wpbb_travel_request_nonce'])),'wpbb_travel_request_'.$object_id))wp_die(esc_html(__( 'The form expired. Please try again.', 'wp-bbtheme-child-travel' )));
    $name=sanitize_text_field(wp_unslash($_POST['name']??'')); $email=sanitize_email(wp_unslash($_POST['email']??'')); $phone=sanitize_text_field(wp_unslash($_POST['phone']??'')); $departure_date=sanitize_text_field(wp_unslash($_POST['departure_date']??'')); $travellers=absint(wp_unslash($_POST['travellers']??'')); $message=sanitize_textarea_field(wp_unslash($_POST['message']??'')); if('' === (string) $name || ! is_email( $email ) || '' === (string) $travellers)wp_die(esc_html(__( 'Please complete the required fields.', 'wp-bbtheme-child-travel' )));
    $request_id=wp_insert_post(array('post_type'=>'trip_enquiry','post_status'=>'publish','post_title'=>sprintf('%s — %s',get_the_title($object_id),isset($name)?$name:current_time('mysql')))); if($request_id&&!is_wp_error($request_id)){foreach(array('object_id'=>$object_id,'name'=>$name,'email'=>$email,'phone'=>$phone,'departure_date'=>$departure_date,'travellers'=>$travellers,'message'=>$message,'status'=>'new') as $key=>$value)update_post_meta($request_id,'_travel_request_'.$key,$value);}
    wp_safe_redirect(add_query_arg('request','received',get_permalink($object_id)).'#request'); exit;
}
add_action('admin_post_wpbb_travel_submit_request','wpbb_travel_submit_request'); add_action('admin_post_nopriv_wpbb_travel_submit_request','wpbb_travel_submit_request');

function wpbb_travel_mega_menu( $definitions, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'travel' ) return $definitions; $archive=get_post_type_archive_link('trip')?:home_url('/trips/');
    $definitions['trip']=array('title'=>__( 'Trips navigation', 'wp-bbtheme-child-travel' ),'target_key'=>'trip','eyebrow'=>__( 'Trips', 'wp-bbtheme-child-travel' ),'heading'=>__( 'Start with the kind of trip you want.', 'wp-bbtheme-child-travel' ),'intro'=>__( 'Browse the full trip catalogue or use destination and style filters.', 'wp-bbtheme-child-travel' ),'columns'=>array(
      array('title'=>__( 'Explore', 'wp-bbtheme-child-travel' ),'links'=>array(array(__( 'Trips', 'wp-bbtheme-child-travel' ),__( 'Start with destination or style, then narrow by budget and duration.', 'wp-bbtheme-child-travel' ),$archive),array(__( 'Services', 'wp-bbtheme-child-travel' ),__( 'Planning, booking and support for trips worth taking.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('services')),array(__( 'Solutions', 'wp-bbtheme-child-travel' ),__( 'Choose by destination, pace, interests or travel style.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('industries')))),
      array('title'=>__( 'Plan', 'wp-bbtheme-child-travel' ),'links'=>array(array(__( 'How it works', 'wp-bbtheme-child-travel' ),__( 'Search, compare, ask the right questions, then book with confidence.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('services')),array(__( 'About', 'wp-bbtheme-child-travel' ),__( 'Destination expertise, transparent trip details and enquiry journeys that keep planning personal.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('about')),array(__( 'Contact', 'wp-bbtheme-child-travel' ),__( 'Talk to the team about the next step.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('contact')))),
      array('title'=>__( 'Useful', 'wp-bbtheme-child-travel' ),'links'=>array(array(__( 'Insights', 'wp-bbtheme-child-travel' ),__( 'Useful guides on places, timing, itineraries and planning well.', 'wp-bbtheme-child-travel' ),get_permalink(get_option('page_for_posts'))?:home_url('/blog/')),array(__( 'Search', 'wp-bbtheme-child-travel' ),__( 'Use the live finder to narrow the catalogue.', 'wp-bbtheme-child-travel' ),$archive),array(__( 'Enquire', 'wp-bbtheme-child-travel' ),__( 'Send the details needed for a useful response.', 'wp-bbtheme-child-travel' ),wp_theme_demo_page_url('contact'))))
    )); return $definitions;
}
add_filter('wp_theme_demo_mega_menu_definitions','wpbb_travel_mega_menu',20,2);

/**
 * v3.8.10.20: keep editable Mega Menu content out of public discovery / SEO.
 * The parent already registers these objects as private; child filters make the
 * intent explicit for Core XML sitemaps and common SEO plugins too.
 */
function wpbb_child_private_megamenu_post_type_args( $args, $post_type ) {
    if ( 'megamenu' !== $post_type ) return $args;
    $args['public'] = false;
    $args['publicly_queryable'] = false;
    $args['exclude_from_search'] = true;
    $args['has_archive'] = false;
    $args['rewrite'] = false;
    $args['query_var'] = false;
    return $args;
}
add_filter( 'register_post_type_args', 'wpbb_child_private_megamenu_post_type_args', 20, 2 );

function wpbb_child_private_megamenu_taxonomy_args( $args, $taxonomy ) {
    if ( 'megamenu-cat' !== $taxonomy ) return $args;
    $args['public'] = false;
    $args['publicly_queryable'] = false;
    $args['rewrite'] = false;
    $args['query_var'] = false;
    return $args;
}
add_filter( 'register_taxonomy_args', 'wpbb_child_private_megamenu_taxonomy_args', 20, 2 );

function wpbb_child_core_sitemap_post_types( $post_types ) {
    unset( $post_types['megamenu'] );
    return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'wpbb_child_core_sitemap_post_types', 20 );

function wpbb_child_core_sitemap_taxonomies( $taxonomies ) {
    unset( $taxonomies['megamenu-cat'] );
    return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'wpbb_child_core_sitemap_taxonomies', 20 );

function wpbb_child_mega_robots( $robots ) {
    if ( is_singular( 'megamenu' ) || is_tax( 'megamenu-cat' ) ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}
add_filter( 'wp_robots', 'wpbb_child_mega_robots', 20 );

function wpbb_child_yoast_exclude_megamenu_post_type( $excluded, $post_type ) {
    return 'megamenu' === $post_type ? true : $excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'wpbb_child_yoast_exclude_megamenu_post_type', 20, 2 );

function wpbb_child_yoast_exclude_megamenu_taxonomy( $excluded, $taxonomy ) {
    return 'megamenu-cat' === $taxonomy ? true : $excluded;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'wpbb_child_yoast_exclude_megamenu_taxonomy', 20, 2 );

function wpbb_child_yoast_mega_robots( $robots ) {
    if ( is_singular( 'megamenu' ) || is_tax( 'megamenu-cat' ) ) return 'noindex, nofollow';
    return $robots;
}
add_filter( 'wpseo_robots', 'wpbb_child_yoast_mega_robots', 20 );


/**
 * v3.8.10.21: global request-a-quote UI is opt-in by child theme.
 * Sector themes with their own quote journeys can keep it; the rest do not
 * expose an unrelated floating "My Quote" control or public route.
 */
if ( ! function_exists( 'wpbb_child_request_quote_enabled' ) ) {
    function wpbb_child_request_quote_enabled() {
        $enabled_themes = array(
            'wp-bbtheme-child-automotive',
            'wp-bbtheme-child-building-services',
            'wp-bbtheme-child-insurance',
            'wp-bbtheme-child-logistics',
            'wp-bbtheme-child-medicine',
            'wp-bbtheme-child-woo-tech-shop',
        );
        $enabled = in_array( get_stylesheet(), $enabled_themes, true );
        return (bool) apply_filters( 'wpbb_child_request_quote_enabled', $enabled, get_stylesheet() );
    }
}

function wpbb_child_request_quote_body_class( $classes ) {
    $classes[] = wpbb_child_request_quote_enabled() ? 'wpbb-request-quote-enabled' : 'wpbb-request-quote-disabled';
    return $classes;
}
add_filter( 'body_class', 'wpbb_child_request_quote_body_class', 30 );

function wpbb_child_request_quote_menu_items( $items ) {
    if ( wpbb_child_request_quote_enabled() ) return $items;
    $target = trim( (string) wp_parse_url( home_url( '/request-a-quote/' ), PHP_URL_PATH ), '/' );
    foreach ( $items as $key => $item ) {
        $path = trim( (string) wp_parse_url( $item->url, PHP_URL_PATH ), '/' );
        if ( $target && $path === $target ) unset( $items[ $key ] );
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'wpbb_child_request_quote_menu_items', 30 );

function wpbb_child_request_quote_disable_route() {
    if ( wpbb_child_request_quote_enabled() ) return;
    $request = isset( $GLOBALS['wp']->request ) ? trim( (string) $GLOBALS['wp']->request, '/' ) : '';
    if ( ! is_page( 'request-a-quote' ) && 'request-a-quote' !== $request ) return;

    global $wp_query;
    if ( $wp_query ) $wp_query->set_404();
    status_header( 404 );
    nocache_headers();
    $template = get_404_template();
    if ( $template ) {
        include $template;
        exit;
    }
    wp_die( esc_html__( 'Page not found.', 'wp-bbtheme-child' ), esc_html__( 'Not found', 'wp-bbtheme-child' ), array( 'response' => 404 ) );
}
add_action( 'template_redirect', 'wpbb_child_request_quote_disable_route', 1 );

function wpbb_child_request_quote_sitemap_args( $args, $post_type ) {
    if ( wpbb_child_request_quote_enabled() || 'page' !== $post_type ) return $args;
    $page = get_page_by_path( 'request-a-quote' );
    if ( $page ) {
        $excluded = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
        $excluded[] = (int) $page->ID;
        $args['post__not_in'] = array_values( array_unique( $excluded ) );
    }
    return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'wpbb_child_request_quote_sitemap_args', 30, 2 );

require_once get_stylesheet_directory() . '/inc/seo-guardrails.php';

/** v3.8.10.24: identify generated legal pages independently of translated slugs. */
function wpbb_child_legal_page_body_class_v381024( $classes ) {
    if ( ! is_page() ) return $classes;
    $post = get_queried_object();
    if ( ! $post instanceof WP_Post ) return $classes;

    $is_legal = function_exists( 'is_privacy_policy' ) && is_privacy_policy();
    if ( ! $is_legal && false !== strpos( (string) $post->post_content, 'wp-theme-legal-section' ) ) {
        $is_legal = true;
    }
    if ( $is_legal ) $classes[] = 'wpbb-legal-page';
    return array_values( array_unique( $classes ) );
}
add_filter( 'body_class', 'wpbb_child_legal_page_body_class_v381024', 40 );

/** v3.8.10.25: remove generated empty spacing without touching authored copy. */
if ( ! function_exists( 'wpbb_child_remove_empty_paragraphs_v381025' ) ) {
    function wpbb_child_remove_empty_paragraphs_v381025( $content ) {
        if ( is_admin() || ! is_string( $content ) || '' === $content ) return $content;
        return (string) preg_replace(
            '~<p(?:\\s[^>]*)?>(?:\\s|&nbsp;|&#160;|<br\\s*/?>)*</p>~i',
            '',
            $content
        );
    }
}
add_filter( 'the_content', 'wpbb_child_remove_empty_paragraphs_v381025', 120 );

/** v3.8.10.25: do not output a completely empty CTA block above the footer. */
if ( ! function_exists( 'wpbb_child_remove_empty_cta_v381025' ) ) {
    function wpbb_child_remove_empty_cta_v381025( $block_content, $block ) {
        if ( empty( $block['blockName'] ) || 'wpbb/cta-section' !== $block['blockName'] || ! is_string( $block_content ) ) return $block_content;
        if ( preg_match( '~<(?:img|picture|video|iframe|form|button|a)\\b~i', $block_content ) ) return $block_content;
        $plain = trim( html_entity_decode( wp_strip_all_tags( $block_content ), ENT_QUOTES | ENT_HTML5, get_bloginfo( 'charset' ) ) );
        return '' === $plain ? '' : $block_content;
    }
}
add_filter( 'render_block', 'wpbb_child_remove_empty_cta_v381025', 120, 2 );



/** v3.8.10.29: make demo switching/imports self-healing across child themes. */
if ( ! function_exists( 'wpbb_child_demo_refresh_on_activation_v381029' ) ) {
    function wpbb_child_demo_refresh_on_activation_v381029() {
        // The parent importer stores one global version/profile. When a different
        // child theme is activated, invalidate that marker so its own profile is
        // imported instead of reusing the previous child's demo state.
        delete_option( 'wp_theme_demo_import_version' );
        delete_option( 'wp_theme_demo_menu_profile' );
    }
    add_action( 'after_switch_theme', 'wpbb_child_demo_refresh_on_activation_v381029', 5 );
}

if ( ! function_exists( 'wpbb_child_demo_integrity_guard_v381029' ) ) {
    function wpbb_child_demo_integrity_guard_v381029( $page_id = 0, $profile = array() ) {
        $page_id = absint( $page_id ?: get_option( 'page_on_front' ) );
        if ( ! $page_id || 'page' !== get_post_type( $page_id ) ) return;

        $content = (string) get_post_field( 'post_content', $page_id );
        // Never rewrite a real imported or edited homepage. This is only a guard
        // for the genuinely empty/near-empty page seen after switching demos.
        if ( strlen( trim( $content ) ) >= 120 ) return;

        if ( ! is_array( $profile ) ) $profile = array();
        $eyebrow = (string) ( $profile['eyebrow'] ?? __( 'Welcome', 'wp-theme' ) );
        $title = (string) ( $profile['hero_title'] ?? get_bloginfo( 'name' ) );
        $intro = (string) ( $profile['hero_text'] ?? __( 'A practical WordPress starter site ready to edit.', 'wp-theme' ) );
        $primary_label = (string) ( $profile['primary_label'] ?? __( 'Get started', 'wp-theme' ) );
        $primary_url = (string) ( $profile['primary_url'] ?? home_url( '/contact/' ) );
        $secondary_label = (string) ( $profile['secondary_label'] ?? __( 'Explore', 'wp-theme' ) );
        $secondary_url = (string) ( $profile['secondary_url'] ?? home_url( '/services/' ) );
        $services_heading = (string) ( $profile['services_heading'] ?? __( 'Useful services, clearly presented.', 'wp-theme' ) );
        $about_title = (string) ( $profile['about_title'] ?? __( 'A flexible starting point for the real site.', 'wp-theme' ) );
        $about_text = (string) ( $profile['about_text'] ?? $intro );
        $hero_image = esc_url( (string) ( $profile['hero_image'] ?? '' ) );
        $about_image = esc_url( (string) ( $profile['about_image'] ?? $hero_image ) );
        $services = ! empty( $profile['services'] ) && is_array( $profile['services'] ) ? array_slice( $profile['services'], 0, 4 ) : array();
        $stats = ! empty( $profile['stats'] ) && is_array( $profile['stats'] ) ? array_slice( $profile['stats'], 0, 4 ) : array();

        $out = '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-sector-hero wp-theme-demo-repair","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-sector-hero wp-theme-demo-repair"><!-- wp:wpbb/row {"containerClass":"container","customClasses":"align-items-center"} --><!-- wp:wpbb/column {"xs":12,"lg":6} --><p class="wp-theme-sector-eyebrow">' . esc_html( $eyebrow ) . '</p><h1>' . esc_html( $title ) . '</h1><p class="wp-theme-sector-lead">' . esc_html( $intro ) . '</p><div class="wp-theme-demo-buttons"><a class="btn btn-primary" href="' . esc_url( $primary_url ) . '">' . esc_html( $primary_label ) . '</a><a class="btn btn-outline-primary" href="' . esc_url( $secondary_url ) . '">' . esc_html( $secondary_label ) . '</a></div><!-- /wp:wpbb/column -->';
        if ( $hero_image ) $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><figure class="wp-theme-sector-page-image"><img src="' . $hero_image . '" alt="" loading="eager" decoding="async"></figure><!-- /wp:wpbb/column -->';
        $out .= '<!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        if ( 'automotive' === ( $profile['id'] ?? '' ) ) {
            $out .= '<!-- wp:group {"className":"wp-theme-section-shell wpbb-automotive-finder-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wpbb-automotive-finder-section" id="finder"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><!-- wp:wpbb/sector-finder {"context":"automotive","limit":8} /--><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';
        }

        $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-services-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-services-section"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><p class="wp-theme-sector-eyebrow">' . esc_html( (string) ( $profile['services_eyebrow'] ?? __( 'Services', 'wp-theme' ) ) ) . '</p><h2>' . esc_html( $services_heading ) . '</h2><!-- wp:wpbb/row {"gutterX":"gx-4","gutterY":"gy-4"} -->';
        foreach ( $services as $service ) {
            $service_title = is_array( $service ) ? (string) ( $service[0] ?? '' ) : '';
            $service_text = is_array( $service ) ? (string) ( $service[1] ?? '' ) : '';
            if ( '' === trim( $service_title ) ) continue;
            $out .= '<!-- wp:wpbb/column {"xs":12,"md":6,"lg":3} --><article class="wp-theme-sector-card"><h3>' . esc_html( $service_title ) . '</h3><p>' . esc_html( $service_text ) . '</p></article><!-- /wp:wpbb/column -->';
        }
        $out .= '<!-- /wp:wpbb/row --><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-about-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-about-section"><!-- wp:wpbb/row {"containerClass":"container","customClasses":"align-items-center"} -->';
        if ( $about_image ) $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><figure class="wp-theme-sector-page-image"><img src="' . $about_image . '" alt="" loading="lazy" decoding="async"></figure><!-- /wp:wpbb/column -->';
        $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><p class="wp-theme-sector-eyebrow">' . esc_html( (string) ( $profile['about_eyebrow'] ?? __( 'About', 'wp-theme' ) ) ) . '</p><h2>' . esc_html( $about_title ) . '</h2><p class="wp-theme-sector-lead">' . esc_html( $about_text ) . '</p><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        if ( $stats ) {
            $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-sector-proof","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-sector-proof"><!-- wp:wpbb/row {"containerClass":"container","gutterX":"gx-3","gutterY":"gy-3"} -->';
            foreach ( $stats as $stat ) {
                $number = is_array( $stat ) ? (string) ( $stat[0] ?? '' ) : '';
                $label = is_array( $stat ) ? (string) ( $stat[1] ?? '' ) : '';
                $out .= '<!-- wp:wpbb/column {"xs":6,"lg":3} --><div class="wp-theme-sector-proof__item"><h3>' . esc_html( $number ) . '</h3><p>' . esc_html( $label ) . '</p></div><!-- /wp:wpbb/column -->';
            }
            $out .= '<!-- /wp:wpbb/row --></div><!-- /wp:group -->';
        }

        $out .= '<!-- wp:wpbb/cta-section {"title":"' . esc_attr( (string) ( $profile['cta_title'] ?? __( 'Ready to make it yours?', 'wp-theme' ) ) ) . '","titleTag":"h2","text":"' . esc_attr( (string) ( $profile['cta_text'] ?? $intro ) ) . '","buttonText":"' . esc_attr( $primary_label ) . '","buttonUrl":"' . esc_url( $primary_url ) . '","className":"wp-theme-home-cta wp-theme-home-cta--bbuilder"} /-->';

        wp_update_post( array( 'ID' => $page_id, 'post_content' => $out ) );
        update_post_meta( $page_id, '_wp_theme_demo_repaired_381029', current_time( 'mysql' ) );
    }
    add_action( 'wp_theme_after_demo_import', 'wpbb_child_demo_integrity_guard_v381029', 99, 2 );
}


/* v3.8.10.30 visual icon configuration */
function wpbb_travel_visual_icon_config() {
    $config = array( 'base' => get_stylesheet_directory_uri(), 'icons' => array('plane', 'route', 'map-pin', 'camera', 'bed', 'calendar', 'users', 'shield') );
    echo '<script>window.wpbbChildVisuals=' . wp_json_encode( $config ) . ';</script>';
}
add_action( 'wp_footer', 'wpbb_travel_visual_icon_config', 1 );


/* v3.8.10.30: realistic demo blog featured images. Runs only after the theme's explicit demo import. */
function wpbb_travel_demo_blog_photo_attachment( $filename, $title ) {
    $slug = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_page_by_path( 'travel-blog-' . $slug, OBJECT, 'attachment' );
    if ( $existing ) {
        if ( function_exists( 'wpbb_travel_refresh_bundled_attachment_v381041' ) ) wpbb_travel_refresh_bundled_attachment_v381041( (int) $existing->ID, 'assets/img/blog' );
        return (int) $existing->ID;
    }
    $source = get_stylesheet_directory() . '/assets/img/blog/' . basename( $filename );
    if ( ! is_readable( $source ) ) return 0;
    $uploads = wp_upload_dir();
    $dir = trailingslashit( $uploads['basedir'] ) . 'travel-blog';
    wp_mkdir_p( $dir );
    $target = $dir . '/' . basename( $filename );
    if ( ! file_exists( $target ) ) copy( $source, $target );
    $filetype = wp_check_filetype( $target );
    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
    $id = wp_insert_attachment( array(
        'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
        'post_title' => $title,
        'post_name' => 'travel-blog-' . $slug,
        'post_status' => 'inherit',
    ), $target );
    if ( $id && ! is_wp_error( $id ) ) {
        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
        $meta = wpbb_child_381048_generate_attachment_metadata( $id, $target );
        if ( $meta ) wp_update_attachment_metadata( $id, $meta );
        update_post_meta( $id, '_wp_attachment_image_alt', $title );
        return (int) $id;
    }
    return 0;
}
function wpbb_travel_seed_demo_blog_photos( $page_id = 0, $profile = array() ) {
    $posts = get_posts( array( 'post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>12, 'orderby'=>'date', 'order'=>'DESC' ) );
    if ( ! $posts ) return;
    $images = array( 'blog-1.jpg','blog-2.jpg','blog-3.jpg','blog-4.jpg','blog-5.jpg','blog-6.jpg' );
    foreach ( $posts as $index => $post ) {
        $filename = $images[ $index % count( $images ) ];
        $attachment = wpbb_travel_demo_blog_photo_attachment( $filename, get_the_title( $post ) );
        if ( $attachment ) set_post_thumbnail( $post->ID, $attachment );
    }
}
add_action( 'wp_theme_after_demo_import', 'wpbb_travel_seed_demo_blog_photos', 70, 2 );


/** v3.8.10.31: apply bundled realistic media to already-imported demos after theme upgrade. */

/**
 * Refresh an already-imported demo attachment from the current child-theme asset.
 *
 * Image optimisation may have changed `_wp_attached_file` from e.g. item-1.jpg to
 * item-1.avif/webp. Resolve the bundled source by filename stem instead of requiring
 * the child theme to ship every generated format, then regenerate all WP sub-sizes.
 */
function wpbb_travel_refresh_bundled_attachment_v381041( $attachment_id, $asset_dir ) {
    $attachment_id = absint( $attachment_id );
    if ( ! $attachment_id || 'attachment' !== get_post_type( $attachment_id ) ) return false;

    $attached = (string) get_post_meta( $attachment_id, '_wp_attached_file', true );
    $stem = pathinfo( basename( $attached ), PATHINFO_FILENAME );
    if ( '' === $stem ) return false;

    $base = trailingslashit( get_stylesheet_directory() ) . trailingslashit( $asset_dir ) . $stem;
    $source = '';
    foreach ( array( '.jpg', '.jpeg', '.png', '.webp', '.avif' ) as $extension ) {
        if ( is_readable( $base . $extension ) ) {
            $source = $base . $extension;
            break;
        }
    }
    if ( ! $source ) return false;

    $target = get_attached_file( $attachment_id );
    if ( ! $target ) return false;

    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';

    $source_ext = strtolower( (string) pathinfo( $source, PATHINFO_EXTENSION ) );
    $target_ext = strtolower( (string) pathinfo( $target, PATHINFO_EXTENSION ) );
    $written = false;

    if ( $source_ext === $target_ext ) {
        $written = (bool) @copy( $source, $target );
    } else {
        $target_type = wp_check_filetype( $target );
        $target_mime = ! empty( $target_type['type'] ) ? (string) $target_type['type'] : '';
        $editor = wp_get_image_editor( $source );
        if ( ! is_wp_error( $editor ) && 0 === strpos( $target_mime, 'image/' ) ) {
            $saved = $editor->save( $target, $target_mime );
            $written = ! is_wp_error( $saved ) && is_readable( $target );
        }
    }

    // Some hosts can read AVIF/WebP but cannot encode it. Fall back to the bundled
    // source extension and update WordPress to the new original file explicitly.
    if ( ! $written ) {
        $fallback = trailingslashit( dirname( $target ) ) . $stem . '.' . $source_ext;
        if ( ! @copy( $source, $fallback ) ) return false;
        update_attached_file( $attachment_id, $fallback );
        $filetype = wp_check_filetype( $fallback );
        if ( ! empty( $filetype['type'] ) ) {
            wp_update_post( array( 'ID' => $attachment_id, 'post_mime_type' => $filetype['type'] ) );
        }
        $target = $fallback;
    }

    // Remove old generated sizes first. Otherwise stale JPG thumbnails can remain
    // referenced after the original was converted to AVIF/WebP by an optimiser.
    $old_meta = wp_get_attachment_metadata( $attachment_id );
    if ( is_array( $old_meta ) && ! empty( $old_meta['sizes'] ) && is_array( $old_meta['sizes'] ) ) {
        foreach ( $old_meta['sizes'] as $old_size ) {
            if ( empty( $old_size['file'] ) ) continue;
            $old_file = trailingslashit( dirname( $target ) ) . basename( (string) $old_size['file'] );
            if ( is_file( $old_file ) && wp_normalize_path( $old_file ) !== wp_normalize_path( $target ) ) @unlink( $old_file );
        }
    }

    $meta = wpbb_child_381048_generate_attachment_metadata( $attachment_id, $target );
    if ( $meta ) wp_update_attachment_metadata( $attachment_id, $meta );
    clean_attachment_cache( $attachment_id );
    return true;
}

function wpbb_travel_realistic_media_upgrade_v381041() {
    if ( ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) ) return;
    $done_key = 'wpbb_travel_realistic_media_upgrade_v381041';
    if ( get_option( $done_key ) ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $pairs = array(array('wpbb-travel','assets/img/demo'),array('travel-blog','assets/img/blog'));
    foreach ( $pairs as $pair ) {
        $upload_prefix = $pair[0];
        $asset_dir = $pair[1];
        $ids = get_posts( array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => array( array( 'key'=>'_wp_attached_file', 'value'=>$upload_prefix . '/', 'compare'=>'LIKE' ) ),
        ) );
        foreach ( $ids as $attachment_id ) {
            wpbb_travel_refresh_bundled_attachment_v381041( $attachment_id, $asset_dir );
        }
    }
    if ( function_exists( 'wpbb_travel_seed_directory' ) ) wpbb_travel_seed_directory( array( 'id'=>'travel' ) );
    if ( function_exists( 'wpbb_travel_seed_demo_blog_photos' ) ) wpbb_travel_seed_demo_blog_photos( 0, array() );
    update_option( $done_key, current_time( 'mysql' ), false );
}
add_action( 'admin_init', 'wpbb_travel_realistic_media_upgrade_v381041', 120 );


/* v3.8.10.42: full-width single-column demo rows + optional frontend demo protection. */
function wpbb_child_381042_repair_single_columns( $blocks ) {
    foreach ( $blocks as &$block ) {
        if ( 'wpbb/row' === ( $block['blockName'] ?? '' ) && ! empty( $block['innerBlocks'] ) ) {
            $column_indexes = array();
            foreach ( $block['innerBlocks'] as $index => $inner ) {
                if ( 'wpbb/column' === ( $inner['blockName'] ?? '' ) ) $column_indexes[] = $index;
            }
            if ( 1 === count( $column_indexes ) ) {
                $idx = $column_indexes[0];
                $attrs = $block['innerBlocks'][ $idx ]['attrs'] ?? array();
                if ( 12 === (int) ( $attrs['xs'] ?? 12 ) ) {
                    $attrs['xs'] = 12;
                    foreach ( array( 'sm', 'md', 'lg', 'xl', 'xxl' ) as $breakpoint ) unset( $attrs[ $breakpoint ] );
                    $block['innerBlocks'][ $idx ]['attrs'] = $attrs;
                }
            }
        }
        if ( ! empty( $block['innerBlocks'] ) ) $block['innerBlocks'] = wpbb_child_381042_repair_single_columns( $block['innerBlocks'] );
    }
    unset( $block );
    return $blocks;
}

function wpbb_child_381042_repair_demo_page_widths() {
    $pages = get_posts( array(
        'post_type' => 'page', 'post_status' => 'any', 'posts_per_page' => -1,
        'meta_key' => '_wp_theme_demo_managed', 'meta_value' => '1', 'fields' => 'ids',
    ) );
    foreach ( $pages as $page_id ) {
        $content = (string) get_post_field( 'post_content', $page_id );
        if ( false === strpos( $content, 'wpbb/column' ) ) continue;
        $blocks = parse_blocks( $content );
        $repaired = serialize_blocks( wpbb_child_381042_repair_single_columns( $blocks ) );
        if ( $repaired !== $content ) wp_update_post( array( 'ID' => $page_id, 'post_content' => $repaired ) );
    }
}
add_action( 'wp_theme_after_demo_import', 'wpbb_child_381042_repair_demo_page_widths', 140 );
function wpbb_child_381042_repair_demo_page_widths_once() {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) return;
    $key = 'wpbb_381042_single_col_' . sanitize_key( get_stylesheet() );
    if ( get_option( $key ) ) return;
    wpbb_child_381042_repair_demo_page_widths();
    update_option( $key, 1, false );
}
add_action( 'admin_init', 'wpbb_child_381042_repair_demo_page_widths_once', 40 );

/**
 * v3.8.10.43: repair shared demo alignment and force one fresh media pass.
 *
 * The previous media migration was intentionally one-shot. This release uses a
 * new per-theme marker so sites that already ran v381041 receive the current
 * child-owned room/product/project/blog images as well.
 */
if ( ! function_exists( 'wpbb_child_381043_normalize_text' ) ) {
    function wpbb_child_381043_normalize_text( $value ) {
        $value = html_entity_decode( wp_strip_all_tags( (string) $value ), ENT_QUOTES | ENT_HTML5, get_bloginfo( 'charset' ) );
        return trim( preg_replace( '/\\s+/u', ' ', $value ) );
    }
}

if ( ! function_exists( 'wpbb_child_381043_dedupe_single_body' ) ) {
    function wpbb_child_381043_dedupe_single_body( $content, $excerpt = '' ) {
        $excerpt_text = wpbb_child_381043_normalize_text( $excerpt );
        if ( '' === $excerpt_text ) return $content;

        $content_text = wpbb_child_381043_normalize_text( $content );
        if ( $content_text === $excerpt_text ) return '';

        if ( preg_match( '~^\\s*<p(?:\\s[^>]*)?>(.*?)</p>~is', (string) $content, $match ) ) {
            if ( wpbb_child_381043_normalize_text( $match[1] ) === $excerpt_text ) {
                return ltrim( substr( (string) $content, strlen( $match[0] ) ) );
            }
        }
        return $content;
    }
}

if ( ! function_exists( 'wpbb_child_381043_repair_block_alignment' ) ) {
    function wpbb_child_381043_repair_block_alignment( $blocks ) {
        foreach ( $blocks as &$block ) {
            if ( 'wpbb/row' === ( $block['blockName'] ?? '' ) ) {
                $attrs = $block['attrs'] ?? array();
                $classes = preg_split( '/\\s+/', trim( (string) ( $attrs['customClasses'] ?? '' ) ) );
                $classes = array_values( array_filter( array_map( 'sanitize_html_class', $classes ) ) );
                if ( in_array( 'wp-theme-sector-media-text', $classes, true ) ) {
                    $classes = array_values( array_diff( $classes, array( 'align-items-center', 'align-items-end' ) ) );
                    if ( ! in_array( 'align-items-start', $classes, true ) ) $classes[] = 'align-items-start';
                    $attrs['customClasses'] = implode( ' ', $classes );
                    $block['attrs'] = $attrs;
                }
            }
            if ( ! empty( $block['innerBlocks'] ) ) {
                $block['innerBlocks'] = wpbb_child_381043_repair_block_alignment( $block['innerBlocks'] );
            }
        }
        unset( $block );
        return $blocks;
    }
}

if ( ! function_exists( 'wpbb_child_381043_repair_demo_pages' ) ) {
    function wpbb_child_381043_repair_demo_pages() {
        // Repair every page that actually contains the theme's media/text row.
        // This also covers front pages imported before the managed-page marker existed.
        $page_ids = get_posts( array(
            'post_type' => 'page',
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ) );
        foreach ( $page_ids as $page_id ) {
            $content = (string) get_post_field( 'post_content', $page_id );
            if ( false === strpos( $content, 'wp-theme-sector-media-text' ) ) continue;
            $repaired = serialize_blocks( wpbb_child_381043_repair_block_alignment( parse_blocks( $content ) ) );
            if ( $repaired !== $content ) {
                wp_update_post( array( 'ID' => $page_id, 'post_content' => $repaired ) );
                clean_post_cache( $page_id );
            }
        }
    }
}

if ( ! function_exists( 'wpbb_child_381043_refresh_media_once' ) ) {
    function wpbb_child_381043_refresh_media_once( $page_id = 0, $profile = array() ) {
        if ( ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) ) return;
        if ( ! current_user_can( 'manage_options' ) ) return;

        $current_stylesheet = sanitize_key( get_stylesheet() );
        $done_key = 'wpbb_child_381043_media_' . $current_stylesheet;
        $owner_key = 'wpbb_child_381043_media_owner';
        // Demo posts are shared while child themes are switched. Refresh again
        // whenever a different child theme last supplied the active media.
        if ( get_option( $done_key ) && $current_stylesheet === (string) get_option( $owner_key ) ) return;

        $defined = get_defined_functions();
        foreach ( (array) ( $defined['user'] ?? array() ) as $function_name ) {
            if ( ! preg_match( '/^wpbb_[a-z0-9_]+_realistic_media_upgrade_v381041$/', $function_name ) ) continue;
            delete_option( $function_name );
            call_user_func( $function_name );
        }

        // Correct stale titles/alt text left behind when the same demo posts were
        // reused while switching child themes.
        $post_ids = get_posts( array(
            'post_type' => 'any',
            'post_status' => 'any',
            'posts_per_page' => -1,
            'meta_key' => '_thumbnail_id',
            'fields' => 'ids',
        ) );
        foreach ( $post_ids as $post_id ) {
            $thumbnail_id = (int) get_post_thumbnail_id( $post_id );
            if ( ! $thumbnail_id ) continue;
            $attached = (string) get_post_meta( $thumbnail_id, '_wp_attached_file', true );
            $attachment_name = (string) get_post_field( 'post_name', $thumbnail_id );
            if ( false === strpos( $attached, '-blog/' ) && 0 !== strpos( $attachment_name, 'wpbb-' ) ) continue;
            $title = get_the_title( $post_id );
            if ( '' === trim( (string) $title ) ) continue;
            wp_update_post( array( 'ID' => $thumbnail_id, 'post_title' => $title ) );
            update_post_meta( $thumbnail_id, '_wp_attachment_image_alt', $title );
            clean_post_cache( $post_id );
            clean_attachment_cache( $thumbnail_id );
        }

        wpbb_child_381043_repair_demo_pages();
        update_option( $done_key, current_time( 'mysql' ), false );
        update_option( $owner_key, $current_stylesheet, false );
    }
}
add_action( 'wp_theme_after_demo_import', 'wpbb_child_381043_refresh_media_once', 180, 2 );
add_action( 'admin_init', 'wpbb_child_381043_refresh_media_once', 130 );

/**
 * v3.8.10.45: shared rhythm, contrast, sector-media and gallery repair.
 */
require_once __DIR__ . '/inc/sector-consistency.php';
