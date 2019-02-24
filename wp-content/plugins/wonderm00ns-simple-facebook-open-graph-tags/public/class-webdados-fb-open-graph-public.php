<?php
/**
 * @package Facebook Open Graph, Google+ and Twitter Card Tags
 * @version 2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Webdados_FB_Public {



	/* Version */
	private $version;

	/* Database options */
	private $options;

	/* Image Size temporary holder */
	private $image_size = false;

	/* BDP Post temporary holder */
	private $post = false;



	/* Construct */
	public function __construct( $options, $version ) {
		$this->options = $options;
		$this->version = $version;
	}



	/* Insert the tags on the header */
	function get_post( $post ) {
		if ( is_singular() ) {
			$this->post = $post;
		}
		return $post;
	}



	/* Insert the tags on the header */
	public function insert_meta_tags() {
		global $webdados_fb, $wp_query;

		if ( !apply_filters( 'fb_og_disable', false ) ) {

			//Open tag
			$html='
<!-- START - '.WEBDADOS_FB_PLUGIN_NAME.' '.WEBDADOS_FB_VERSION.' -->
';
	
			if ( apply_filters('fb_og_enabled', true) ) {
		
				//Also set Title Tag? - Needed??
				$fb_set_title_tag=0;
		
				//Init values
				$fb_locale = '';
				$fb_title = '';
				$fb_url = '';
				$fb_desc = '';
				$fb_image = '';
				$fb_type = 'article';
				$fb_author = '';
				$fb_author_meta = '';
				$fb_author_linkrelgp = '';
				$fb_author_twitter = '';
				$fb_article_pub_date = '';
				$fb_article_mod_date = '';
				$fb_image_additional = array();
				$fb_additional_tags = array(
					'name' => array(),
					'property' => array(),
				);
				$fb_publisher = trim($this->options['fb_publisher']);
				$fb_publisher_schema = trim($this->options['fb_publisher_schema']);
				$fb_publisher_twitteruser = trim($this->options['fb_publisher_twitteruser']);
		
				//Homepage Description
				switch( $this->options['fb_desc_homepage'] ) {
					case 'custom':
						$fb_desc_homepage = $this->options['fb_desc_homepage_customtext'];
						//WPML?
						if ( $webdados_fb->is_wpml_active() ) {
							global $sitepress;
							if ( ICL_LANGUAGE_CODE != $sitepress->get_default_language() ) {
								$fb_desc_homepage = icl_t( 'wd-fb-og', 'wd_fb_og_desc_homepage_customtext', $fb_desc_homepage );
							}
						}
						break;
					default:
						$fb_desc_homepage = get_bloginfo( 'description' );
						break;
				}
		
				if ( is_singular() ) {
		
					global $post;
					// Title
						//It's a Post or a Page or an attachment page - It can also be the homepage if it's set as a page
						$fb_title = esc_attr( wp_strip_all_tags( stripslashes( $post->post_title ), true ) );
						//SubHeading
						if ( isset($this->options['fb_show_subheading']) && intval($this->options['fb_show_subheading'])==1 && $webdados_fb->is_subheading_plugin_active() ) {
							if (isset($this->options['fb_subheading_position']) && $this->options['fb_subheading_position']=='before' ) {
								$fb_title = trim( trim(get_the_subheading()).' - '.trim($fb_title), ' -' );
							} else {
								$fb_title = trim( trim($fb_title).' - '.trim(get_the_subheading()), ' -' );
							}
						}
					// URL
						$fb_url = get_permalink();
					// Type if it's a homepage page
						if ( is_front_page() ) {
							/* Fix homepage type when it's a static page */
							$fb_url = get_option('home').(intval($this->options['fb_url_add_trailing'])==1 ? '/' : '' );
							$fb_type = trim($this->options['fb_type_homepage']=='' ? 'website' : $this->options['fb_type_homepage']);
						}
					// Description
						if ( $fb_desc = trim( get_post_meta($post->ID, '_webdados_fb_open_graph_specific_description', true) ) ) {
							//From our metabox
						} else {
							if ( trim($post->post_excerpt) != '' ) {
								//If there's an excerpt that's what we'll use
								$fb_desc = trim($post->post_excerpt);
							} else {
								//If not we grab it from the content
								$fb_desc = trim($post->post_content);
							}
						}
					// Image
						if ( intval($this->options['fb_image_show'])==1 || intval($this->options['fb_image_show_schema'])==1 || intval($this->options['fb_image_show_twitter'])==1 ) {
							$fb_image = $this->get_post_image();
						}
					// Author
						$author_id = $post->post_author;
						if ( $author_id > 0 && ! ( is_page() && intval($this->options['fb_author_hide_on_pages'])==1 ) ) {
							$fb_author = get_the_author_meta('facebook', $author_id);
							$fb_author_meta = get_the_author_meta('display_name', $author_id);
							$fb_author_linkrelgp = get_the_author_meta('googleplus', $author_id);
							$fb_author_twitter = get_the_author_meta('twitter', $author_id);
						}
		
					//Published and Modified time - We should check this out and maybe have it for any kind of post...
						if ( is_singular('post' ) ) {
							$fb_article_pub_date = get_the_date('c' );
							$fb_article_mod_date = get_the_modified_date('c' );
						} else {
							//Reset dates show because we're not on posts
							$this->options['fb_article_dates_show'] = 0;
						}
					//Sections
						if ( is_singular('post' ) ) {
							$cats = get_the_category();
							if ( !is_wp_error($cats) && (is_array($cats) && count($cats)>0) ) {
								$fb_sections = array();
								foreach ($cats as $cat) {
									$fb_sections[] = $cat->name;
								}
							}
						} else {
							$this->options['fb_article_sections_show'] = 0;
						}
					// Business Directory Plugin
						if ( isset( $this->options['fb_show_businessdirectoryplugin'] ) && $webdados_fb->is_business_directory_active() ) {
							global $wpbdp;
							$bdp_action = wpbdp_current_action();
							$bdp_disable_cpt = wpbdp_get_option( 'disable-cpt' );
							$current_view_object = $wpbdp->dispatcher->current_view_object();
							switch( $bdp_action ) {
								case 'show_listing':
									$fb_title = trim( esc_attr( wp_strip_all_tags( stripslashes( $this->post->post_title ), true ) ).' - '.$fb_title, ' -' );
									$fb_set_title_tag = 1;
									$fb_url = get_permalink($this->post->ID);
									if ( trim($this->post->post_excerpt)!='' ) {
										//If there's an excerpt that's what we'll use
										$fb_desc = trim($this->post->post_excerpt);
									} else {
										//If not we grab it from the content
										$fb_desc = trim($this->post->post_content);
									}		
									if (intval($this->options['fb_image_show'])==1 || intval($this->options['fb_image_show_schema'])==1 || intval($this->options['fb_image_show_twitter'])==1) {
										$thumbdone = false;
										if ( intval($this->options['fb_image_use_featured'])==1 ) {
											//Featured
											if ( $id_attachment = get_post_thumbnail_id( $this->post->ID ) ) {
												//There's a featured/thumbnail image for this listing
												$fb_image = wp_get_attachment_url( $id_attachment, false );
												$thumbdone = true;
											} else {
											}
										}
										if ( !$thumbdone ) {
											//Main image loaded
											if ( $thumbnail_id = wpbdp_listings_api()->get_thumbnail_id( $this->post->ID ) ) {
												$fb_image = wp_get_attachment_url( $thumbnail_id, false );
												$thumbdone = true;
											}
										}
									}
							}
						}
					// WooCommerce
						if ( $webdados_fb->is_woocommerce_active() && is_product() ) {
							$fb_type = 'product';
							$product = new WC_Product( $post->ID );
							//Price
							$price = version_compare( WC_VERSION, '3.0', '>=' ) ? wc_get_price_including_tax($product) : $product->get_price_including_tax();
							$currency = get_woocommerce_currency();
							$fb_additional_tags['property']['product_price_amount'] = array(
								$price
							);
							if ( function_exists('get_woocommerce_currency') ) $fb_additional_tags['property']['product_price_currency'] = array(
								$currency
							);
							$fb_additional_tags['name']['twitter_label1'] = array(
								__('Price', 'wonderm00ns-simple-facebook-open-graph-tags')
							);
							if ( function_exists('get_woocommerce_currency') )  $fb_additional_tags['name']['twitter_data1'] = array(
								$price.' '.get_woocommerce_currency()
							);
							//Additional product images?
							if ( intval($this->options['fb_image_show'])==1 && $this->options['fb_wc_useproductgallery']==1 ) {
								if ( $attachment_ids = version_compare( WC_VERSION, '3.0', '>=' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids() ) {
									foreach ( $attachment_ids as $attachment_id ) {
										if ( $image_link = wp_get_attachment_url( $attachment_id ) ) {
											if ( trim($image_link)!='' ) {
												$fb_image_additional[] = array(
													'fb_image' => trim($image_link),
													'png_overlay' => ( intval($this->options['fb_wc_usepg_png_overlay']) ? true : false ),
												);
											}
										}
									}
								}
							}
						}
		
				} else {
		
					//Other pages - Defaults
					$fb_title = esc_attr( wp_strip_all_tags( stripslashes( get_bloginfo( 'name' ) ), true ) );
					$fb_url = ( ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://' ).$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //Not really canonical but will work for now
					$fb_image = trim( $this->options['fb_image'] );
		
					$this->options['fb_article_sections_show'] = 0;
					$this->options['fb_article_dates_show'] = 0;
					$this->options['fb_author_show'] = 0;
					$this->options['fb_author_show_meta'] = 0;
					$this->options['fb_author_show_linkrelgp'] = 0;
					$this->options['fb_author_show_twitter'] = 0;
					$this->options['fb_author_show_twitter'] = 0;
		
					//Category
					if ( is_category() ) {
						$fb_title = esc_attr( wp_strip_all_tags( stripslashes( single_cat_title( '', false ) ), true ) );
						$term = $wp_query->get_queried_object();
						$fb_url = get_term_link( $term, $term->taxonomy );
						$cat_desc = trim( esc_attr( wp_strip_all_tags( stripslashes( category_description() ), true ) ) );
						if ( trim($cat_desc)!='' ) $fb_desc = $cat_desc;
					} else {
						if ( is_tag() ) {
							$fb_title = esc_attr( wp_strip_all_tags( stripslashes( single_tag_title( '', false ) ), true ) );
							$term = $wp_query->get_queried_object();
							$fb_url = get_term_link( $term, $term->taxonomy );
							$tag_desc = trim( esc_attr( wp_strip_all_tags( stripslashes( tag_description() ), true ) ) );
							if ( trim($tag_desc)!='' ) $fb_desc = $tag_desc;
						} else {
							if (is_tax()) {
								$fb_title = esc_attr( wp_strip_all_tags( stripslashes( single_term_title( '', false ) ), true ) );
								$term = $wp_query->get_queried_object();
								$fb_url = get_term_link($term, $term->taxonomy);
								$tax_desc = trim( esc_attr( wp_strip_all_tags( stripslashes( term_description() ), true ) ) );
								if ( trim($tax_desc)!='' ) $fb_desc = $tax_desc;
								//WooCommerce
								if ( $webdados_fb->is_woocommerce_active() && intval($this->options['fb_wc_usecategthumb'])==1 && is_product_category() ) {
									if ( intval($this->options['fb_image_show'])==1 || intval($this->options['fb_image_show_schema'])==1 || intval($this->options['fb_image_show_twitter'])==1 ) {
										if ( $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) ) {
											if ( $image = wp_get_attachment_url( $thumbnail_id ) ) {
												$fb_image = $image;
											}
										}
									}
								}
							} else {
								if ( is_search() ) {
									$fb_title = esc_attr( wp_strip_all_tags( stripslashes( __('Search for', 'wonderm00ns-simple-facebook-open-graph-tags').' "'.get_search_query().'"' ), true ) );
									$fb_url = get_search_link();
								} else {
									if (is_author()) {
										$fb_title = esc_attr( wp_strip_all_tags( stripslashes( get_the_author_meta('display_name', get_query_var('author') ) ), true ) );
										$fb_url = get_author_posts_url( get_query_var('author'), get_query_var('author_name') );
									} else {
										if ( is_archive() ) {
											if ( is_day() ) {
												$fb_title = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'day' ) . ' ' .single_month_title( ' ', false ) . ' ' . __( 'Archives', 'wonderm00ns-simple-facebook-open-graph-tags' ) ), true ) );
												$fb_url = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
											} else {
												if ( is_month() ) {
													$fb_title = esc_attr( wp_strip_all_tags( stripslashes( single_month_title( ' ', false ) . ' ' . __( 'Archives', 'wonderm00ns-simple-facebook-open-graph-tags' ) ), true ) );
													$fb_url = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
												} else {
													if ( is_year() ) {
														$fb_title = esc_attr( wp_strip_all_tags( stripslashes( get_query_var( 'year' ) . ' ' . __( 'Archives', 'wonderm00ns-simple-facebook-open-graph-tags' ) ), true ) );
														$fb_url = get_year_link( get_query_var( 'year' ) );
													}
												}
											}
										} else {
											if (is_front_page()) {
												$fb_url = get_option('home').(intval($this->options['fb_url_add_trailing'])==1 ? '/' : '');
												$fb_type = trim( $this->options['fb_type_homepage']=='' ? 'website' : $this->options['fb_type_homepage'] );
												$fb_desc = $fb_desc_homepage;
											} else {
												//Others... Defaults already set up there
											}
										}
									}
								}
							}
						}
					}
				}
		
				//og:type for WPML root page?
				if ( $webdados_fb->is_wpml_active() ) {
					if ( class_exists('WPML_Root_Page') ) {
						if ( WPML_Root_Page::is_current_request_root() ) {
							$fb_type = trim( $this->options['fb_type_homepage']=='' ? 'website' : $this->options['fb_type_homepage'] );
						}
					}
				}
		
		
		
				//Default description, if empty until now
				if ( trim($fb_desc)=='' ) {
					switch( $this->options['fb_desc_default_option'] ) {
						case 'custom':
							$fb_desc = $this->options['fb_desc_default'];
							//WPML?
							if ( $webdados_fb->is_wpml_active() ) {
								global $sitepress;
								if ( ICL_LANGUAGE_CODE != $sitepress->get_default_language() ) {
									$fb_desc = icl_t( 'wd-fb-og', 'wd_fb_og_fb_desc_default', $fb_desc );
								}
							}
							break;
						default:
							$fb_desc = $fb_desc_homepage;
							break;
					}
				}
		
				//Trim description
				$fb_desc = trim( str_replace('&nbsp;', ' ', $fb_desc) ); //Non-breaking spaces are usefull on a meta description. We'll just convert them to normal spaces to really trim it
				$fb_desc = trim(
							intval($this->options['fb_desc_chars'])>0
							?
							mb_substr( wp_strip_all_tags( strip_shortcodes( stripslashes( $fb_desc ), true ) ), 0, intval($this->options['fb_desc_chars']) )
							:
							wp_strip_all_tags( strip_shortcodes( stripslashes( $fb_desc ), true ) )
				);
		
				//YOAST SEO?
				if ( $this->options['fb_show_wpseoyoast']==1 ) {
					if ( $webdados_fb->is_yoast_seo_active() ) {
						$wpseo = WPSEO_Frontend::get_instance();
						//Title
						$fb_title_temp = $wpseo->title(false);
						$fb_title = wp_strip_all_tags( trim($fb_title_temp)!='' ? trim($fb_title_temp) : $fb_title, true);
						//Title - SubHeading plugin
						if ( $fb_title_temp!='' && $this->options['fb_show_subheading']==1 ) {
							if ( $webdados_fb->is_subheading_plugin_active() ) {
								if ( isset($this->options['fb_subheading_position']) && $this->options['fb_subheading_position']=='before' ) {
									$fb_title = trim( trim( get_the_subheading() ).' - '.trim($fb_title), ' -');
								} else {
									$fb_title = trim( trim( $fb_title ).' - '.trim( get_the_subheading() ), ' -');
								}
							}
						}
						//URL
						$fb_url_temp = $wpseo->canonical(false);
						$fb_url = wp_strip_all_tags( trim($fb_url_temp)!='' ? trim($fb_url_temp) : $fb_url, true);
						//Description
						$fb_desc_temp = $wpseo->metadesc(false);
						$fb_desc = wp_strip_all_tags( trim($fb_desc_temp)!='' ? trim($fb_desc_temp) : $fb_desc, true);
					}
				}
		
				//All in One SEO Pack?
				if ( $this->options['fb_show_aioseop']==1 ) {
					if ( $webdados_fb->is_aioseop_active() ) {
						global $aiosp;
						//Title - Why are we getting the first post title on archives and homepage...?!?
						$fb_title_temp = $aiosp->orig_title;
						$fb_title = wp_strip_all_tags( trim($fb_title_temp)!='' ? trim($fb_title_temp) : $fb_title, true);
						//Title - SubHeading plugin
						if ( $fb_title_temp!='' && $this->options['fb_show_subheading']==1 ) {
							if ( $webdados_fb->is_subheading_plugin_active() ) {
								if ( isset($this->options['fb_subheading_position']) && $this->options['fb_subheading_position']=='before' ) {
									$fb_title = trim( trim( get_the_subheading() ).' - '.trim($fb_title), ' -');
								} else {
									$fb_title = trim( trim( $fb_title ).' - '.trim( get_the_subheading() ), ' -');
								}
							}
						}
						//URL - See aioseop_class.php 3898 - We have a problem because wp_query is not the same right now
						/*$fb_url_temp = '';
						$aioseop_options = get_option( 'aioseop_options' );
						$opts = $aiosp->meta_opts;
						var_dump($wp_query);
						$show_page = true;
						if ( ! empty( $aioseop_options['aiosp_no_paged_canonical_links'] ) ) {
							$show_page = false;
						}
						if ( $aioseop_options['aiosp_can'] ) {
							if ( ! empty( $aioseop_options['aiosp_customize_canonical_links'] ) && ! empty( $opts['aiosp_custom_link'] ) ) {
								$fb_url_temp = $opts['aiosp_custom_link'];
							}
							if ( empty( $url ) ) {
								$fb_url_temp = $aiosp->aiosp_mrt_get_url( $wp_query, $show_page );
							}
				
							$fb_url_temp = $aiosp->validate_url_scheme( $fb_url_temp );
				
							$fb_url_temp = apply_filters( 'aioseop_canonical_url', $fb_url_temp );
						}
						var_dump($fb_url_temp);
						$fb_url = wp_strip_all_tags( trim($fb_url_temp)!='' ? trim($fb_url_temp) : $fb_url, true);*/
						//Description - Why are we getting the first post description on archives and homepage...?!?
						if ( is_home() && ! is_front_page() ) {
							$post = aiosp_common::get_blog_page();
						} else {
							$post = $aiosp->get_queried_object();
						}
						$fb_desc_temp = apply_filters( 'aioseop_description', $aiosp->get_main_description( $post ) );
						$fb_desc = wp_strip_all_tags( trim($fb_desc_temp)!='' ? trim($fb_desc_temp) : $fb_desc, true);
		
					}
				}
		
				//Apply Filters
				$fb_app_id = apply_filters('fb_og_app_id', $this->options['fb_app_id']);
				$fb_locale = apply_filters('fb_og_locale', $fb_locale);
				$fb_title = apply_filters('fb_og_title', $fb_title);
				$fb_url = apply_filters('fb_og_url', $fb_url);
				$fb_type = apply_filters('fb_og_type', $fb_type);
				$fb_desc = apply_filters('fb_og_desc', $fb_desc);
				$fb_image = apply_filters('fb_og_image', $fb_image);
				$fb_image_additional = apply_filters('fb_og_image_additional', $fb_image_additional);
		
				//Image size
				$fb_image_size = false;
				if ( intval($this->options['fb_image_show'])==1 && trim($fb_image)!='' ) {
					if ( intval($this->options['fb_image_size_show'])==1 && intval($this->options['fb_adv_disable_image_size'])==0 ) {
						if ( isset($this->image_size) && is_array($this->image_size) ) { //Already fetched
							$fb_image_size = $this->image_size;
						} else {
							$fb_image_size = $this->get_open_graph_image_size($fb_image);
						}
					}
				} else {
					$this->options['fb_image_show'] = 0;
				}
		
				//Image overlay - Single?
				if ( intval($this->options['fb_image_show'])==1 && intval($this->options['fb_image_overlay'])==1 && apply_filters('fb_og_image_overlay', true, $fb_image) ) {
					//Single
					$temp_fb_image_overlay = $this->get_image_with_overlay($fb_image);
					if ( $temp_fb_image_overlay['overlay'] ) {
						$fb_image = $temp_fb_image_overlay['fb_image'];
						//We know the exact size now. We better just show it, right?
						$this->options['fb_image_size_show'] = 1;
						$fb_image_size = array(WEBDADOS_FB_W, WEBDADOS_FB_H);
					}
					//Additional
					if ( isset($fb_image_additional) && is_array($fb_image_additional) && count($fb_image_additional)>0 ) {
						foreach($fb_image_additional as $key => $value ) {
							if ( isset($value['png_overlay']) && $value['png_overlay'] ) {
								$temp_fb_image_overlay = $this->get_image_with_overlay($value['fb_image']);
								if ( $temp_fb_image_overlay['overlay'] ) {
									$fb_image_additional[$key]['fb_image'] = $temp_fb_image_overlay['fb_image'];
								}
							}
						}
					}
				}
				
				//No spaces on URLs
				if ( isset($fb_url) && trim($fb_url)!='' )								$fb_url =				str_replace(' ', '%20', trim($fb_url));
				if ( isset($fb_publisher) && trim($fb_publisher)!='' )					$fb_publisher =			str_replace(' ', '%20', trim($fb_publisher));
				if ( isset($fb_publisher_schema) && trim($fb_publisher_schema)!='' )	$fb_publisher_schema =	str_replace(' ', '%20', trim($fb_publisher_schema));
				if ( isset($fb_author) && trim($fb_author)!='' )						$fb_author =			str_replace(' ', '%20', trim($fb_author));
				if ( isset($fb_author_linkrelgp) && trim($fb_author_linkrelgp)!='' )	$fb_author_linkrelgp =	str_replace(' ', '%20', trim($fb_author_linkrelgp));
				if ( isset($fb_image) && trim($fb_image)!='' )							$fb_image =				str_replace(' ', '%20', trim($fb_image));
				if ( isset($fb_image_additional) && is_array($fb_image_additional) && count($fb_image_additional) ) {
					foreach ( $fb_image_additional as $key => $value ) {
						if ( isset($value['fb_image']) ) $fb_image_additional[$key]['fb_image'] = str_replace( ' ', '%20', trim($value['fb_image']) );
					}
				}
				
				//If there's still no description let's just add the title as a last resort
				if ( trim($fb_desc)=='' ) $fb_desc = $fb_title;
		
				//Print tags
					// Facebook
				$html.=' <!-- Facebook Open Graph -->
';
					//Locale
					if ( intval($this->options['fb_locale_show'])==1 ) $html.='  <meta property="og:locale" content="'.trim(esc_attr( trim($this->options['fb_locale'])!='' ? trim($this->options['fb_locale']) : $webdados_fb->get_locale() )).'"/>
';
					//Site name
					if ( intval($this->options['fb_sitename_show'])==1 ) $html.='  <meta property="og:site_name" content="'.trim(esc_attr(get_bloginfo('name' ))).'"/>
';
					//Title
					if ( intval($this->options['fb_title_show'])==1 && trim($fb_title)!='' ) $html.='  <meta property="og:title" content="'.trim(esc_attr($fb_title)).'"/>
';
					//URL
					if ( intval($this->options['fb_url_show'])==1 && trim($fb_url)!='' ) $html.='  <meta property="og:url" content="'.trim(esc_attr($fb_url)).'"/>
';
					//Type
					if ( intval($this->options['fb_type_show'])==1 && trim($fb_type)!='' ) $html.='  <meta property="og:type" content="'.trim(esc_attr($fb_type)).'"/>
';
					//Description
					if ( intval($this->options['fb_desc_show'])==1 && trim($fb_desc)!='' ) $html.='  <meta property="og:description" content="'.trim(esc_attr($fb_desc)).'"/>
';
					//Image
					if( intval($this->options['fb_image_show'])==1 && trim($fb_image)!='' ) $html.='  <meta property="og:image" content="'.trim(esc_attr($fb_image)).'"/>
';
					//Additional Images
					if( intval($this->options['fb_image_show'])==1  && isset($fb_image_additional) && is_array($fb_image_additional) && count($fb_image_additional)>0 ) {
						foreach ($fb_image_additional as $fb_image_additional_temp) {
							if ( isset($fb_image_additional_temp['fb_image']) && trim($fb_image_additional_temp['fb_image'])!='' ) {
								$html.='  <meta property="og:image" content="'.trim(esc_attr($fb_image_additional_temp['fb_image'])).'"/>
';
							}
						}
					} else {
						//Image Size - We only show the image size if we only have one image
						if( intval($this->options['fb_image_size_show'])==1 && isset($fb_image_size) && is_array($fb_image_size) ) $html.='  <meta property="og:image:width" content="'.intval(esc_attr($fb_image_size[0])).'"/>
  <meta property="og:image:height" content="'.intval(esc_attr($fb_image_size[1])).'"/>
';
					}
					//Dates
					if ( intval($this->options['fb_article_dates_show'])==1 && trim($fb_article_pub_date)!='' ) $html.='  <meta property="article:published_time" content="'.trim(esc_attr($fb_article_pub_date)).'"/>
';
					if ( intval($this->options['fb_article_dates_show'])==1 && trim($fb_article_mod_date)!='') $html.='  <meta property="article:modified_time" content="'.trim(esc_attr($fb_article_mod_date)).'" />
  <meta property="og:updated_time" content="'.trim(esc_attr($fb_article_mod_date)).'" />
';
					//Sections
					if (intval($this->options['fb_article_sections_show'])==1 && isset($fb_sections) && is_array($fb_sections) && count($fb_sections)>0) {
						foreach($fb_sections as $fb_section) {
							$html.='  <meta property="article:section" content="'.trim(esc_attr($fb_section)).'"/>
';
						}
					}
					//Author
					if ( intval($this->options['fb_author_show'])==1 && $fb_author!='') $html.='  <meta property="article:author" content="'.trim(esc_attr($fb_author)).'"/>
';
					//Publisher
					if ( intval($this->options['fb_publisher_show'])==1 && trim($fb_publisher)!='') $html.='  <meta property="article:publisher" content="'.trim(esc_attr($fb_publisher)).'"/>
';
					//App ID
					if ( intval($this->options['fb_app_id_show'])==1 && trim($fb_app_id)!='' ) $html.='  <meta property="fb:app_id" content="'.trim(esc_attr($fb_app_id)).'"/>
';
					//Admins
					if ( intval($this->options['fb_admin_id_show'])==1 && trim($this->options['fb_admin_id'])!='' ) $html.='  <meta property="fb:admins" content="'.trim(esc_attr($this->options['fb_admin_id'])).'"/>
';
				// Schema
			$html.=' <!-- Google+ / Schema.org -->
';
					//Title
					if ( intval($this->options['fb_title_show_schema'])==1 && trim($fb_title)!='' ) $html.='  <meta itemprop="name" content="'.trim(esc_attr($fb_title)).'"/>
';
					//Description
					if ( intval($this->options['fb_desc_show_schema'])==1 && trim($fb_desc)!='' ) $html.='  <meta itemprop="description" content="'.trim(esc_attr($fb_desc)).'"/>
';
					//Image
					if( intval($this->options['fb_image_show_schema'])==1 && trim($fb_image)!='' ) $html.='  <meta itemprop="image" content="'.trim(esc_attr($fb_image)).'"/>
';
					//Author
					if ( intval($this->options['fb_author_show_linkrelgp'])==1 && trim($fb_author_linkrelgp)!='') $html.='  <link rel="author" href="'.trim(esc_attr($fb_author_linkrelgp)).'"/>
';
					//Publisher
					if ( intval($this->options['fb_publisher_show_schema'])==1 && trim($fb_publisher_schema)!='') $html.='  <link rel="publisher" href="'.trim(esc_attr($fb_publisher_schema)).'"/>
';
				// Twitter
			$html.=' <!-- Twitter Cards -->
';
					//Title
					if ( intval($this->options['fb_title_show_twitter'])==1 && trim($fb_title)!='' ) $html.='  <meta name="twitter:title" content="'.trim(esc_attr($fb_title)).'"/>
';
					//URL
					if ( intval($this->options['fb_url_show_twitter'])==1 && trim($fb_url)!='' ) $html.='  <meta name="twitter:url" content="'.trim(esc_attr($fb_url)).'"/>
';
					//Description
					if ( intval($this->options['fb_desc_show_twitter'])==1 && trim($fb_desc)!='' ) $html.='  <meta name="twitter:description" content="'.trim(esc_attr($fb_desc)).'"/>
';
					//Image
					if( intval($this->options['fb_image_show_twitter'])==1 && trim($fb_image)!='' ) $html.='  <meta name="twitter:image" content="'.trim(esc_attr($fb_image)).'"/>
';
					//Twitter Card
					if( intval($this->options['fb_title_show_twitter'])==1 || intval($this->options['fb_url_show_twitter'])==1 || intval($this->options['fb_desc_show_twitter'])==1 || intval($this->options['fb_publisher_show_twitter'])==1 || intval($this->options['fb_image_show_twitter'])==1 ) $html.='  <meta name="twitter:card" content="'.trim(esc_attr($this->options['fb_twitter_card_type'])).'"/>
';
					//Author
					if ( intval($this->options['fb_author_show_twitter'])==1 && trim($fb_author_twitter)!='' ) $html.='  <meta name="twitter:creator" content="@'.trim(esc_attr( $fb_author_twitter )).'"/>
';
					//Publisher
					if ( intval($this->options['fb_publisher_show_twitter'])==1 && trim($fb_publisher_twitteruser)!='') $html.='  <meta name="twitter:site" content="@'.trim(esc_attr($fb_publisher_twitteruser)).'"/>
';
				// SEO
			$html.=' <!-- SEO -->
';
					//Title
					if ( intval($fb_set_title_tag)==1 && trim($fb_title)!='' ) {
						//Does nothing so far. We try to create the <title> tag but it's too late now
						//We should use wp_title(), but do we want to? This is only because Business Directory Plugin and they seem to have it covered by now...
					}
					//URL
					if ( intval($this->options['fb_url_canonical'])==1 ) $html.='  <link rel="canonical" href="'.trim(esc_attr($fb_url)).'"/>
';
					//Description
					if ( intval($this->options['fb_desc_show_meta'])==1 && trim($fb_desc)!='' ) $html.='  <meta name="description" content="'.trim(esc_attr($fb_desc)).'"/>
';
					//Author
					if (intval($this->options['fb_author_show_meta'])==1 && $fb_author_meta!='') $html.='  <meta name="author" content="'.trim(esc_attr($fb_author_meta)).'"/>
';
					//Publisher
					if ( intval($this->options['fb_publisher_show_meta'])==1 ) $html.='  <meta name="publisher" content="'.trim(esc_attr(get_bloginfo('name' ))).'"/>
';
				// SEO
			$html.=' <!-- Misc. tags -->
';
					foreach ($fb_additional_tags as $type => $tags) {
						foreach($tags as $tag => $values) {
							foreach($values as $value) {
								$html.='  <meta '.$type.'="'.str_replace('_', ':', trim($tag)).'" content="'.trim(esc_attr($value)).'"/>
';	
							}
						}
					}
			} else {
	
				$html.=' <!-- Removed by fb_og_enabled filter -->
';
	
			}
		
			//Close tag
			$html.='<!-- END - '.WEBDADOS_FB_PLUGIN_NAME.' '.WEBDADOS_FB_VERSION.' -->
	
';
		} else {
			$html = '
<!-- START - '.WEBDADOS_FB_PLUGIN_NAME.' '.WEBDADOS_FB_VERSION.' -->
<!-- Disabled by the "fb_og_disable" filter -->
<!-- END - '.WEBDADOS_FB_PLUGIN_NAME.' '.WEBDADOS_FB_VERSION.' -->
';
		}
		echo apply_filters('fb_og_output', $html);

	}



	/* Get post image - Singular pages */
	private function get_post_image() {
		global $post;
		$thumbdone = false;
		$fb_image = '';
		$minsize = intval($this->options['fb_image_min_size']);
		//Attachment page? - This overrides the other options
		if ( is_attachment() ) {
			if ( $temp=wp_get_attachment_image_src(null, 'full' ) ) {
				$fb_image = trim($temp[0]);
				$img_size = array(intval($temp[1]), intval($temp[2]));
				if ( trim($fb_image)!='' ) {
					$thumbdone=true;
				}
			}
		}
		//Specific post image
		if ( !$thumbdone ) {
			if ( intval($this->options['fb_image_use_specific'])==1 ) {
				if ( $fb_image = trim(get_post_meta($post->ID, '_webdados_fb_open_graph_specific_image', true)) ) {
					if ( trim($fb_image)!='' ) {
						$thumbdone=true;
					}
				}
			}
		}
		//Featured image
		if ( !$thumbdone ) {
			if ( function_exists('get_post_thumbnail_id' ) ) {
				if ( intval($this->options['fb_image_use_featured'])==1 ) {
					if ( $id_attachment=get_post_thumbnail_id($post->ID) ) {
						//There's a featured/thumbnail image for this post
						$fb_image = wp_get_attachment_url($id_attachment, false);
						$thumbdone = true;
					}
				}
			}
		}
		//From post/page content
		if ( !$thumbdone ) {
			if ( intval($this->options['fb_image_use_content'])==1 ) {
				$imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
				preg_match_all($imgreg, trim($post->post_content), $matches);
				if ($matches[1]) {
					$imagetemp=false;
					foreach($matches[1] as $image) {
						//There's an image on the content
						$pos = strpos($image, site_url());
						if ($pos === false) {
							if (stristr($image, 'http://' ) || stristr($image, 'https://' ) || mb_substr($image, 0, 2)=='//' ) {
								if (mb_substr($image, 0, 2)=='//' ) $image=((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https:' : 'http:' ).$image;
								//Complete URL - offsite
								//if ( intval(ini_get('allow_url_fopen' ))==1 ) {
									$imagetemp=$image;
									$imagetempsize=$imagetemp;
								//} else {
									//If it's offsite we can't getimagesize'it, so we won't use it
									//We could save a temporary version locally and then getimagesize'it but do we want to do this every single time?
								//}
							} else {
								//Partial URL - we guess it's onsite because no http(s)://
								$imagetemp=site_url().$image;
								$imagetempsize=(
									intval(ini_get('allow_url_fopen' ))==1
									?
									(
										intval($this->options['fb_adv_force_local'])==1
										?
										ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
										:
										$imagetemp
									)
									:
									ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
								);
							}
						} else {
							//Complete URL - onsite
							$imagetemp=$image;
							$imagetempsize=(
								intval(ini_get('allow_url_fopen' ))==1
								?
								(
									intval($this->options['fb_adv_force_local'])==1
									?
									ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
									:
									$imagetemp
								)
								:
								ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
							);
						}
						if ($imagetemp) {
							if ( intval($this->options['fb_adv_disable_image_size'])==1 ) {
								//If we don't check for image size, we'll just accept the first one
								$fb_image = $imagetemp;
								$thumbdone = true;
								break; //Break the foreach
							} else {
								if ($img_size = $this->get_open_graph_image_size($imagetempsize)) {
									if ($img_size[0] >= $minsize && $img_size[1] >= $minsize) {
										$fb_image = $imagetemp;
										$thumbdone = true;
										break; //Break the foreach
									}
								}
							}
						}
					}
				}
			}
		}
		//From media gallery
		if ( !$thumbdone ) {
			if ( intval($this->options['fb_image_use_media'])==1 ) {
				$images = get_posts(array('post_type' => 'attachment','numberposts' => -1,'post_status' => null,'order' => 'ASC','orderby' => 'menu_order','post_mime_type' => 'image','post_parent' => $post->ID));
				if ( $images ) {
					foreach( $images as $image ) {
						$imagetemp = wp_get_attachment_url($image->ID, false);
						$imagetempsize = (
							intval(ini_get('allow_url_fopen' ))==1
							?
							(
								intval($this->options['fb_adv_force_local'])==1
								?
								ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
								:
								$imagetemp
							)
							:
							ABSPATH.str_replace(trailingslashit(site_url()), '', $imagetemp)
						);
						if ( intval($this->options['fb_adv_disable_image_size'])==1 ) {
							//If we don't check for image size, we'll just accept the first one
							$fb_image = $imagetemp;
							$thumbdone = true;
							break; //Break the foreach
						} else {
							if ( $img_size = $this->get_open_graph_image_size($imagetempsize) ) {
								if ($img_size[0] >= $minsize && $img_size[1] >= $minsize) {
									$fb_image = $imagetemp;
									$thumbdone = true;
									break; //Break the foreach
								}
							}
						}
					}
				}
			}
		}
		//From default
		if ( !$thumbdone ) {
			if ( intval($this->options['fb_image_use_default'])==1 ) {
				//Well... We sure did try. We'll just keep the default one!
				$fb_image = $this->options['fb_image'];
			} else {
				//User chose not to use default on pages/posts
				$fb_image = '';
			}
		}
		//Return
		return $fb_image;

	}


	/* Image with overlay URL */
	private function get_image_with_overlay($fb_image) {
		$fb_image_parsed = parse_url($fb_image);
		//Only if the image is hosted locally
		if ( $fb_image_parsed['host']==$_SERVER['HTTP_HOST'] ) {
			$fb_image = plugins_url('/wonderm00ns-simple-facebook-open-graph-tags/fbimg.php?img='.urlencode($fb_image));
			return array(
				'overlay'	=> true,
				'fb_image'	=> $fb_image,
			);
		}
		return array(
			'overlay'	=> false,
			'fb_image'	=> $fb_image,
		);
	}



	/* Get image size */
	private function get_open_graph_image_size_curl( $image, $headers ) {
		try {
			$curl = curl_init($image);
			if ( is_array($headers) ) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			//Set HTTP REFERER and USER AGENT just in case. Some servers may have hotlinking protection
			curl_setopt($curl, CURLOPT_REFERER, ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://' ).$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			$data = curl_exec($curl);
			curl_close($curl);
			return $data;
		} catch(Exception $e) {
			return false;
		}
	}
	private function get_open_graph_image_size( $image ) {
		//Just in case we've missed it somewhere...
		if ( intval($this->options['fb_adv_disable_image_size'])==1 ) return false;
		//Go ahead
		$transient_key = 'webdados_og_image_size_' . md5($image);
		$transient_val = get_transient($transient_key);
		if ($transient_val) {
			return $transient_val;
		}
		if ( stristr($image, 'http://' ) || stristr($image, 'https://' ) || mb_substr($image, 0, 2)=='//' ) {
			if ( function_exists('curl_version' ) && function_exists('imagecreatefromstring' ) ) {
				//We'll get just a part of the image to speed things up. From http://stackoverflow.com/questions/4635936/super-fast-getimagesize-in-php
				$headers = array(
					"Range: bytes=0-32768"
				);
				$data = $this->get_open_graph_image_size_curl($image, $headers);
				if ( $data ) {
					$done_partial = false;
					$tried_full = false;
					try {
						$im = @imagecreatefromstring($data); //Mute errors because we're not loading the all image
						if ($im) $done_partial = true;
					} catch(Exception $e) {
						//Try again with the whole image - In case of Fatal Error
						$tried_full = true;
						$data = $this->get_open_graph_image_size_curl($image, null);
						$im = @imagecreatefromstring($data);
					}
					if ( !$done_partial && !$tried_full ) {
						//Try again with the whole image - In case of Warning
						if ( $data = $this->get_open_graph_image_size_curl($image, null) ) {
							$im = @imagecreatefromstring($data);
						} else {
							//No way...
							$im = false;
						}
					}
					if ( $im ) {
						if ( $x=imagesx($im) ) {
							//We have to fake the image type - For RSS
							$ext = pathinfo($image, PATHINFO_EXTENSION);
							switch(strtolower($ext)) {
								case 'gif':
									$type=1;
									break;
								case 'jpg':
								case 'jpeg':
									$type=2;
									break;
								case 'png':
									$type=3;
									break;
								default:
									$type=2;
									break;
							}
							$img_size = array($x, imagesy($im), $type, '' );
						} else {
							$img_size = false;
						}
					} else {
						$img_size = false;
					}
				} else {
					$img_size = false;
				}
			} else {
				if ( intval(ini_get('allow_url_fopen' ))==1 ) {
					$img_size = getimagesize($image);
				} else {
					//We give up!
					$img_size = false;
				}
			}
		} else {
			//Local path
			$img_size = getimagesize($image);
		}
		if ($img_size) {
			set_transient($transient_key, $img_size, DAY_IN_SECONDS);
		}
		$this->image_size = $img_size;
		return $img_size;
	}



	/* Add Open Graph Namespace */
	public function add_open_graph_namespace($output) {
		if ( $this->options['fb_declaration_method']=='prefix' ) {
			if ( preg_match('/\bprefix=(["\'])([^"\']+)["\']/i', $output, $m) ) {
				//prefix attribute already there, so let's look into it
				$prefix = $m[2];
				if ( !preg_match('/\bog: /', $prefix) ) {
					//og prefix missing, let's add it
					$prefix .= ' og: http://ogp.me/ns#';
				}
				if ( !preg_match('/\bfb: /', $prefix) ) {
					//fb prefix missing, let's add it
					$prefix .= ' fb: http://ogp.me/ns/fb#';
				}
				//replace existing prefix attribute with new one
				$output=str_replace($m[0], 'prefix='.$m[1].$prefix.$m[1], $output);
			} else {
				//No prefix attribute there, let's add it
				$output=$output . ' prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#"';
			}
		} else {
			if ( stristr($output, 'xmlns:og') ) {
				//Already there
			} else {
				//Let's add it
				$output=$output . ' xmlns:og="http://ogp.me/ns#"';
			}
			if ( stristr($output, 'xmlns:fb') ) {
				//Already there
			} else {
				//Let's add it
				$output=$output . ' xmlns:fb="http://ogp.me/ns/fb#"';
			}
		}
		return $output;
	}



	/* Add Schema itemtype */
	public function add_schema_itemtype($output) {
		if ( intval($this->options['fb_type_show_schema'])==1 ) {
			$fb_type_schema = '';
			if ( is_front_page() ) {
				$fb_type_schema = trim($this->options['fb_type_schema_homepage'])=='' ? 'WebSite' : trim($this->options['fb_type_schema_homepage']);
			} else {
				$fb_type_schema = trim($this->options['fb_type_schema_post'])=='' ? 'Article' : trim($this->options['fb_type_schema_post']);
			}
			$fb_type_schema = apply_filters('fb_type_schema', $fb_type_schema );
			if ( $fb_type_schema!='' ) $output=$output . ' itemscope itemtype="http://schema.org/'.esc_attr($fb_type_schema).'"';
		}
		return $output;
	}



	/* Images on feed */
	public function images_on_feed_yahoo_media_tag() {
		if ( intval($this->options['fb_image_rss'])==1 ) {
			//Even if it's comments feed, not a problem
			echo 'xmlns:media="http://search.yahoo.com/mrss/"';
		}
	}
	public function images_on_feed_image() {
		if ( intval($this->options['fb_image_rss'])==1 ) {
			//Only runs on posts feed, not comments, so cool!
			$fb_image = $this->get_post_image();
			if ( $fb_image!='' ) {
				$uploads = wp_upload_dir();
				$url = parse_url($fb_image);
				$path = $uploads['basedir'] . preg_replace( '/.*uploads(.*)/', '${1}', $url['path'] );
				if ( file_exists($path) ) {
					$filesize = filesize($path);
					$url = $path;
				} else {		
					$header = get_headers($fb_image, 1);					   
					$filesize = $header['Content-Length'];	
					$url = $fb_image;				
				}
				if ( intval($this->options['fb_adv_disable_image_size'])==0 ) {
					if ( list( $width, $height, $type, $attr ) = $this->get_open_graph_image_size( $url ) ) {
						echo '<enclosure url="' . $fb_image . '" length="' . $filesize . '" type="'.image_type_to_mime_type($type).'"/>';
						echo '<media:content url="'.$fb_image.'" width="'.$width.'" height="'.$height.'" medium="image" type="'.image_type_to_mime_type($type).'"/>';
					} else {
						echo '<enclosure url="' . $fb_image . '" length="' . $filesize . '" type="'.image_type_to_mime_type(null).'"/>';
						echo '<media:content url="'.$fb_image.'" width="" height="" medium="image" type="'.image_type_to_mime_type(null).'"/>';
					}
				} else {
					echo '<enclosure url="' . $fb_image . '" length="' . $filesize . '" type="'.image_type_to_mime_type(null).'"/>';
					echo '<media:content url="'.$fb_image.'" width="" height="" medium="image" type="'.image_type_to_mime_type(null).'"/>';
				}
			}
		}
	}



}

?>