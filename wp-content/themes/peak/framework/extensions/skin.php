<?php

function mo_generate_skin_styles($skin_color) {

    if (empty($skin_color) || $skin_color === 'default')
        return '';

    list($r, $g, $b) = sscanf($skin_color, "#%02x%02x%02x");

    list($r1, $g1, $b1) = array(intval($r * 0.8), intval($g * 0.8), intval($b * 0.8)); // get me the slightly darkened color of the skin - useful for borders etc.

    $output = <<<HTML

/* ============== START - Skin Styles ============= */

/* ------- The links --------- */
a, a:active, a:visited { color: {$skin_color}; }
a:hover { color: #888; }
.sec-nav a, .sec-nav li > a { color: #a1a1a1; }
.sidebar li > a:hover, .sidebar li:hover > a { color: {$skin_color}; }

.page-links a, .page-links a:visited, .pagination a, .pagination a:visited { background-color: {$skin_color}; }

#title-area { background-color: {$skin_color}; }
#custom-title-area { background-color: {$skin_color}; }
.post-list .entry-title a:hover, .post-snippets .hentry .entry-title a:hover { color: {$skin_color}; }
ul.post-listing .published a:hover, ul.post-listing .author a:hover { color: {$skin_color}; }
#content .hentry .entry-meta a:hover { color: {$skin_color}; }
.sticky .entry-snippet { border-color: {$skin_color};}
.post-snippets .byline a:hover { color: {$skin_color};}
.byline span i { color: {$skin_color};}
#content .hentry .category a { background-color: {$skin_color}; }
a.more-link:hover { color: {$skin_color}; }
.image-info .terms a:hover { color: {$skin_color}; }
#content .hentry .entry-meta .category a { color: {$skin_color}; }
#content .hentry .entry-meta.taglist span a:hover { background-color: {$skin_color}; border-color: {$skin_color};}
#title-area a, #title-area a:active, #title-area a:visited { color: {$skin_color}; }

.top-of-page a:hover, .post-list .byline a, .post-list .byline a:active, .post-list .byline a:visited, .entry-meta span i, .read-more a, .loop-nav a:hover { color: {$skin_color}; }
button, .button, input[type=button], input[type="submit"], input[type="reset"] { background-color: {$skin_color}; border-color: {$skin_color};}
.button.theme:hover { background: {$skin_color} !important; border-color: {$skin_color} !important; }
.button.theme { border-color: {$skin_color}; }

#flickr-widget .flickr_badge_image img:hover { border-color: {$skin_color}; }
ul#recentcomments li.recentcomments a { color: {$skin_color}; }
input#mc_signup_submit { background-color: {$skin_color} !important; }
.search-form .submit { background-color: {$skin_color} !important; }
.widget_rss ul > li a.rsswidget { color: {$skin_color}; }

.header-fancy span { background-color: {$skin_color}; }
h3.fancy-header { background-color: {$skin_color};}

.heading .title.dashed:after { background-color: {$skin_color}; }

.segment.slogan blockquote .footer cite { color: {$skin_color}; }
.segment.slogan h3 { color: {$skin_color} !important; }
.portfolio-label { color: {$skin_color}; }
#showcase-filter a:hover, #showcase-filter a.active, #showcase-links a:hover, #showcase-links a.active { background: {$skin_color}; border-color: {$skin_color}; }

.stats-bar-content { background: {$skin_color}; }

.pricing-table .pricing-plan.highlight .top-header h3 { color: {$skin_color} !important; }
.animate-numbers .stats .number { color: {$skin_color} !important; }
.animate-numbers .stats .prefix, .animate-numbers .stats .suffix { color: {$skin_color}; }
.testimonials2-slider-container blockquote cite i { color: {$skin_color}; }
.testimonials-slider-container blockquote cite i { background-color: {$skin_color}; }
.client-testimonials2 .header cite { color: {$skin_color};}
.testimonials-slider-container cite .client-name { color: {$skin_color}; }
#app-benefits .app-benefit i, #app-benefits .agency-benefit i, #agency-benefits .app-benefit i, #agency-benefits .agency-benefit i { color: {$skin_color};}
#agency-services .agency-service i { color: {$skin_color};}
.member-profile h3:after { background-color: {$skin_color}; }
#showcase-filter a:hover { background: {$skin_color}; border-color: {$skin_color}; }
.featured-items h4:after { background-color: {$skin_color}; }
#team-section .team-header .text-content { background-color: {$skin_color}; }
#contact-us .contact-info-section { background-color: {$skin_color}; }
#column-shortcode-section p { background: {$skin_color}; }
.charity-links .charity-link i { color: {$skin_color}; }
.timeline-item .index { color: {$skin_color}; }

#sidebars-footer .widget_text a.small, #sidebars-footer .widget_text a.small:visited,
#home-intro h2 span { color: {$skin_color}; }
#sidebar-header .social-list a:hover i { color: {$skin_color}; }

a.button { color: #fff; }
input:focus, textarea:focus, #content .contact-form input:focus, #content .contact-form textarea:focus,
.sec-nav .contact-form input:focus, .sec-nav .contact-form textarea:focus { border-color: rgba({$r}, {$g} , {$b}, 0.8); }
#home2-heading .heading2 h2, #home3-heading .heading2 h2 { background: rgba({$r}, {$g} , {$b}, 0.7); }

.sec-nav .button:hover, .sec-nav button:hover, .sec-nav input[type="button"]:hover, .sec-nav input[type="submit"]:hover, .sec-nav input[type="reset"]:hover {
background-color: {$skin_color} !important;
border-color: {$skin_color} !important;
}
.sec-nav li:hover a, .sec-nav a:hover, .sec-nav li > a:hover { color: #e1e1e1; }

.tab-titles li.tab-title .current, .tab-titles li.tab-title .current:hover, .tab-titles li.tab-title.current a { border-top-color: {$skin_color}; }
.toggle-label:hover { background-color: {$skin_color}; border-color: {$skin_color}; }
.active-toggle .toggle-label:hover { background-color: {$skin_color}; }

ul.tab-list { border-bottom: 1px solid {$skin_color}; }
ul.tab-list li a.visible, ul.tab-list li a.flex-active { border-bottom: 3px solid {$skin_color}; }
ul.tab-list li a:hover { color: {$skin_color}; }

.team-member:hover h3 a { color: {$skin_color}; }

#app-intro .heading .title { color: {$skin_color}; }
.app-benefit i, .agency-benefit i { color: {$skin_color}; }
#styleswitcher-button i { color: {$skin_color}; }
.call-to-action div.zero-margin .image-wrap .caption .subcaption { background-color: {$skin_color}; }

.single-campaign .entry-content a.button.donate-now.large { border-bottom-color: rgba({$r1}, {$g1} , {$b1}, 1.0); }


/* Plugins Skins Styles */

/*---------- Events Manager ------------- */

table.em-calendar thead { background: {$skin_color}; }
table.em-calendar td.eventful-today a , table.em-calendar td.eventful a { color: {$skin_color}; }

#tribe-events-content .tribe-events-tooltip h4, #tribe_events_filters_wrapper .tribe_events_slider_val, .single-tribe_events a.tribe-events-ical,
.single-tribe_events a.tribe-events-gcal {
  color: {$skin_color};
  }

.tribe-events-list-widget .tribe-events-widget-link a:after { color: {$skin_color}; }
.tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"], .tribe-events-calendar td.tribe-events-present div[id*="tribe-events-daynum-"] > a,
#tribe_events_filters_wrapper input[type=submit], .tribe-events-button, #tribe-events .tribe-events-button, .tribe-events-button.tribe-inactive {
  background: {$skin_color};
  }

/*------- WooCommerce ---------*/

.woocommerce-site .cart-contents .cart-count {
  background: {$skin_color};
}

.woocommerce input[name="update_cart"], .woocommerce input[name="proceed"], .woocommerce input[name="woocommerce_checkout_place_order"],
 .woocommerce-page input[name="update_cart"], .woocommerce-page input[name="proceed"], .woocommerce-page input[name="woocommerce_checkout_place_order"] {
  color: #ffffff;
  background-color: {$skin_color};
  }
.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce a.button.alt,
.woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt,
.woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit,
.woocommerce-page #content input.button, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt,
.woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt {
background: {$skin_color};
border-color: {$skin_color};
}

.woocommerce a.add_to_cart_button, .woocommerce-page a.add_to_cart_button { background: {$skin_color}; border-color: {$skin_color};}

.woocommerce .quantity .plus, .woocommerce #content .quantity .plus, .woocommerce .quantity .minus, .woocommerce #content .quantity .minus, .woocommerce-page .quantity .plus,
.woocommerce-page #content .quantity .plus, .woocommerce-page .quantity .minus, .woocommerce-page #content .quantity .minus {
background: {$skin_color};
}

.woocommerce .woocommerce-message, .woocommerce .woocommerce-info, .woocommerce .woocommerce-error {
border-color: rgba({$r}, {$g} , {$b}, 0.3);
background: rgba({$r}, {$g} , {$b}, 0.1);
}

.woocommerce span.onsale, .woocommerce-page span.onsale { background: .woocommerce a.add_to_cart_button, .woocommerce-page a.add_to_cart_button; }

.woocommerce-site .cart-contents .cart-count { background: {$skin_color}; }

.woocommerce .star-rating span:before, .woocommerce-page .star-rating span:before {
  color: {$skin_color};
  }
.woocommerce span.onsale, .woocommerce-page span.onsale {
  background: {$skin_color};
  text-shadow: none;
  box-shadow: none;
  }
.woocommerce-message,  .woocommerce-info,  .woocommerce-error {
    border: 1px solid rgba({$r}, {$g} , {$b}, 0.3);
    background: rgba({$r}, {$g} , {$b}, 0.2);
}
.cart-contents .cart-count {
    background: {$skin_color};
}
ul.products li.product h3:hover {
    color: {$skin_color};
}

.woocommerce-site #header .site-header-cart .widget_shopping_cart .buttons .button { background-color: {$skin_color}; }

.woocommerce .widget_product_search form.woocommerce-product-search input[type=submit], .woocommerce-page .widget_product_search form.woocommerce-product-search input[type=submit] {
background-color: {$skin_color}; }

/* --------- Other Plugins ---------- */

.tp_recent_tweets li a { color: {$skin_color} !important; }

.tp-caption.medium_bg_peak { background-color: {$skin_color} !important; }

.widget .instagram-pics img:hover { border-color: {$skin_color}; }

/* =============== END - Skin Styles ============= */

HTML;

    return $output;

}