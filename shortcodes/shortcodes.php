<?php

abstract class Responsive_Portfolio_Gallery_Shortcodes {

	var $shortcode = 'shortcode';
	var $content = false;

	public function __construct() {
		add_shortcode($this->shortcode, array(&$this, 'shortcode'));
	}

	public function shortcode($atts){
		$atts = shortcode_atts(
			array(
				'categories' => '',
				'default-view' => 'grid'
			),
			$atts
		);
		return $atts;
	}

	public function content($columns, $categories, $default_view){
		$categories = array_map('strtolower', $categories);
		$filter_cats = array();
		$loop = new WP_Query(array('post_type' => 'portfolio-item', 'posts_per_page' => -1));
		$count =0;
		$portfolio_list = 	'<div id="container portfolio-wrapper">
								<div id="portfolio-list" class="shuffle">';
		if($loop){
			while($loop->have_posts()): $loop->the_post();
				$displayItem = false;
				$postid = get_the_ID();
				$terms = get_the_terms( $postid, 'portfolio-category' );
				if($terms && !is_wp_error( $terms )){
					$links = array();
					$links[] = "*";
					foreach($terms as $term){
						if(empty($categories) || in_array(strtolower($term->name), $categories)){
							$displayItem = true;
						}
						$links[] = $term->slug;
					}
					$tax = json_encode($links);
					if($displayItem){
						$filter_cats = array_merge($filter_cats, $links);
					}
				}
				else {
					$tax = '';
				}
				$tax = "data-groups='". strtolower($tax) . "'";
				$post_meta = get_post_custom();
				$thumbnail_links_to = isset($post_meta['_thumbnail_url']) ? $post_meta['_thumbnail_url'][0] : "";
				if($thumbnail_links_to == 'external'){
					$thumbnail_url = $post_meta['_url'][0] ? 'http://' . $post_meta['_url'][0] : get_permalink();
				}
				else {
					$thumbnail_url = get_permalink();
				}
				$thumbnail_target = isset($post_meta['_thumbnail_url_target']) ? $post_meta['_thumbnail_url_target'][0] : "";
				if($thumbnail_target == "on") {
					$thumbnail_target = 'target="_blank"';
				}
				else {
					$thumbnail_target = '';
				}
				$url_target = isset($post_meta['_url_target']) ? $post_meta['_url_target'][0] : "";
				if($url_target == "on"){
					$url_target = 'target="_blank"';
				}
				if($post_meta['_url'][0]){
					$url = '<a class="visit-site" href="http://'. $post_meta['_url'][0] .'" '. $url_target .'>
								Visit Site
							</a>';
				}
				else {
					$url = '';
				}
				$image_full = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'full' );
				if($displayItem){
					$portfolio_list .= '<div class="module-container portfolio-item" '. $tax .'>
											<div class="module-img">
												<a href="'. $thumbnail_url .'" '. $thumbnail_target .'>
													<img src="'. $image_full[0] .'">
												</a>
											</div>
											<div class="module-meta">
												<h3 class="item-header">
													<a href="' . get_permalink() .'">'. get_the_title(). '</a>
												</h3>
												<p class="excerpt">'.
													$this->the_excerpt_max_charlength(45) .'
												</p>
												<p class="links">
													<a href="'. get_permalink() .'">Read More</a>'.
													$url .'
												</p>
											</div>
										</div>';
				}
			endwhile;
		}
		else {
			$portfolio_list .= '<p class="error-not-found">Sorry, no portfolio entries to show.</p>';
		}
		$portfolio_list .= '</div>
							<div class="clearboth"></div>
						</div>';

		$filter_cats = array_unique($filter_cats);
		$portfolio = $this->portfolio_filter_output($filter_cats);
		$portfolio .= $portfolio_list;
		$portfolio .= $this->include_javascript($columns, $default_view);
		return $portfolio;
	}

	public function portfolio_filter_output($categories){
		$cat_count = count($categories);
		$terms = get_terms("portfolio-category");
		$term_count = count($terms);
		$html = '<div id="filter-sorter">
				<div id="filter-buttons">
				<h3>Filter:</h3>';
		$html .= '<ul id="portfolio-filter-list">
				<li class="selected"><a href="#" data-group="*" class="active">All</a></li>';
		if($term_count > 0){
			foreach($terms as $term){
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				if(empty($categories) || in_array($termname, $categories)){
					$html .= '<li><a href="#" data-group="' . $termname . '">' . $term->name . '</a></li>';
				}
			}
		}
		$html .= '</ul>';
		$html .= '<select id="portfolio-filter-select">
				<option data-group="*">All</option>';
		if($term_count > 0){
			foreach ( $terms as $term ) {
				$termname = strtolower($term->name);
				$termname = str_replace(' ', '-', $termname);
				if(empty($categories) || in_array($termname, $categories)){
					$html .= '<option data-group="' . $termname . '">' . $term->name . '</option>';
				}
			}
		}
		$html .= '</select>';
		$gridButton = plugins_url( '/assets/images/grid-view-32.png' , dirname(__FILE__));
		$listButton =plugins_url( '/assets/images/list-view-32.png' , dirname(__FILE__));;
		$hybridButton =plugins_url( '/assets/images/hybrid-grid-view-32.png' , dirname(__FILE__));;
		$html .= '</div>';
		if($term_count == 0 && $cat_count == 1){
			$html = "";
		}
		$html .= '<div id="view-sorter">
					<span id="view-sorter-title">View:</span>
					<span title="Grid View" class="grid_btn 2-col-grid"><img src="'.$gridButton.'" alt="Grid View" /></span>
					<span title="Hybrid View" class="hybrid_btn 2-col-hybrid"><img src="'.$hybridButton.'" alt="Hybrid View" /></span>
					<span title="List View" class="list_btn 2-col-list"><img src="'.$listButton.'" alt="List View" /></span>
				</div>';
		if($term_count > 0 && $cat_count != 1){
			$html .= '</div>
					<div class="clearboth"></div>';
		}
		return $html;
	}
	public function include_javascript($columns, $default_view){
		$script = '
		<script>
			jQuery(document).ready(
				function(){
					jQuery(\'<div class="loading-portfolio"></div>\').prependTo("body");
					jQuery("#portfolio-list .portfolio-item").addClass("columns-" + ' .$columns. ');
					jQuery("#portfolio-list .module-meta").slideUp().css("height", 0);
					jQuery(".grid_btn").css("opacity","0.5");

					var $grid = jQuery("#portfolio-list");
					$grid.shuffle({
						itemSelector: ".portfolio-item" // the selector for the items in the grid
					});
					jQuery("#portfolio-filter-list a").on(
						"click",
						function(event){
							event.preventDefault();
							var selector = jQuery(this).attr("data-group");
							var parent = jQuery(this).parent();
							parent.siblings().removeClass("selected");
							parent.addClass("selected");
							jQuery("#portfolio-filter-list a").removeClass("active");
							jQuery(this).addClass("active");
							$grid.shuffle("shuffle", selector );
							return false;
						}
					);

					jQuery("#portfolio-filter-select").on(
						"change",
						function(){
							var selector = jQuery("option:selected").attr("data-group");
							var parent = jQuery(this).parent();
							$grid.shuffle("shuffle", selector );
							return false;
						}
					);
					imagesLoaded(
						document.querySelector("#portfolio-list"),
						function( instance ) {
							jQuery(".loading-portfolio").fadeTo(
								1250,
								0,
								function() {
									jQuery(".loading-portfolio").remove();
								}
							);
						    	setTimeout(
								function(){
							    		jQuery("span.2-col-' . $default_view . '").trigger("click");
								},
								500
						    	);
						}
					);
				}
			);

			 // Two Column Buttons Actions
			jQuery("span.2-col-grid").on(
				"click",
				function () {
					jQuery("#portfolio-list .portfolio-item, #portfolio-list .module-img, #portfolio-list .module-meta")
					.removeClass("full-page-view");
					jQuery("#portfolio-list .module-meta").slideUp().css("height", 0);
					jQuery(".list_btn").css("opacity","1");
					jQuery(".hybrid_btn").css("opacity","1");
					jQuery(".grid_btn").css("opacity","0.5");
					jQuery("#portfolio-filter-list a.active").trigger("click");
				}
			);

			jQuery("span.2-col-hybrid").on(
				"click",
				function () {
					jQuery("#portfolio-list .portfolio-item, #portfolio-list .module-img, #portfolio-list .module-meta")
					.removeClass("full-page-view");
					jQuery("#portfolio-list .module-meta").slideDown().css("float", "left").css("height", "auto");
					jQuery(".list_btn").css("opacity","1");
					jQuery(".hybrid_btn").css("opacity","0.5");
					jQuery(".grid_btn").css("opacity","1");
					jQuery("#portfolio-list .module-container").css("height", "auto");
					jQuery("#portfolio-filter-list a.active").trigger("click");
				}
			);

			jQuery("span.2-col-list").on(
				"click",
				function () {
					jQuery("#portfolio-list .portfolio-item, #portfolio-list .module-img").addClass("full-page-view");
					jQuery("#portfolio-list .module-meta").addClass("full-page-view").slideDown().css("float", "left").css("height", "auto");
					jQuery(".list_btn").css("opacity","0.5");
					jQuery(".hybrid_btn").css("opacity","1");
					jQuery(".grid_btn").css("opacity","1");
					jQuery("#portfolio-list .module-container").css("height", "auto");
					jQuery("#portfolio-filter-list a.active").trigger("click");
				}
			);
		</script>';
		return $script;
	}

	public function the_excerpt_max_charlength($charlength) {
		$result =  "";
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				$result .= mb_substr( $subex, 0, $excut );
			} else {
				$result .= $subex;
			}
			$result .= '[...]';
		} else {
			$result = $excerpt;
		}
		return $result;
	}
}
