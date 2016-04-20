tinymce.PluginManager.add('livemeshShortcodes', function(editor, url) {

    editor.addCommand( 'livemeshPopup', function( ui, v ){
        var popup = v.identifier;

        // load thickbox
        tb_show( editor.getLang('livemesh.insert'), ajaxurl + "?action=livemesh_popup&popup=" + popup + "&width=" + 670 );
    });

    var menu_items = [

        { text: editor.getLang('livemesh.main'), menu: [
            { text: editor.getLang('livemesh.segment'), onclick: function(e){ addPopup('segment') } },
            { text: editor.getLang('livemesh.columns'), onclick: function(e){ addPopup('columns') }, text: editor.getLang('livemesh.columns') },
            { text: editor.getLang('livemesh.image'), onclick: function(e){ addPopup('image') }, text: editor.getLang('livemesh.image') },
            { text: editor.getLang('livemesh.button'), onclick: function(e){ addPopup('button') }, text: editor.getLang('livemesh.button') },
            { text: editor.getLang('livemesh.contact_form'), onclick: function(e){ addPopup('contact_form') }, text: editor.getLang('livemesh.contact_form') },

        ] },


        { text: editor.getLang('livemesh.typography'), menu: [
            { text: editor.getLang('livemesh.heading'), onclick: function(e){ addPopup('heading') } },
            { text: editor.getLang('livemesh.heading2'), onclick: function(e){ addPopup('heading2') } },
            { text: editor.getLang('livemesh.code'), onclick: function(e){ addPopup('code') } },
            { text: editor.getLang('livemesh.highlight1'), onclick: function(e){ addPopup('highlight1') } },
            { text: editor.getLang('livemesh.highlight2'), onclick: function(e){ addPopup('highlight2') } },
            { text: editor.getLang('livemesh.list'), onclick: function(e){ addPopup('list') } },
            { text: editor.getLang('livemesh.wrap'), onclick: function(e){ addPopup('wrap') } },
            { text: editor.getLang('livemesh.icon'), onclick: function(e){ addPopup('icon') } },
            { text: editor.getLang('livemesh.action_call'), onclick: function(e){ addPopup('action_call') } },
            { text: editor.getLang('livemesh.blockquote'), onclick: function(e){ addPopup('blockquote') } },
            { text: editor.getLang('livemesh.pullquote'), onclick: function(e){ addPopup('pullquote') } }


        ] },

        { text: editor.getLang('livemesh.custom_post_type'), menu: [
            { text: editor.getLang('livemesh.pricing_plans'), onclick: function(e){ addPopup('pricing_plans') } },
            { text: editor.getLang('livemesh.testimonials'), onclick: function(e){ addPopup('testimonials') } },
            { text: editor.getLang('livemesh.testimonials2'), onclick: function(e){ addPopup('testimonials2') } },
            { text: editor.getLang('livemesh.team'), onclick: function(e){ addPopup('team') } },
            { text: editor.getLang('livemesh.show_post_snippets'), onclick: function(e){ addPopup('show_post_snippets') } }

        ] },


        { text: editor.getLang('livemesh.portfolio_shortcodes'), menu: [
            { text: editor.getLang('livemesh.show_post_snippets'), onclick: function(e){ addPopup('show_post_snippets') } },
            { text: editor.getLang('livemesh.show_portfolio'), onclick: function(e){ addPopup('show_portfolio') } },
            { text: editor.getLang('livemesh.show_gallery'), onclick: function(e){ addPopup('show_gallery') } }
        ] },


        { text: editor.getLang('livemesh.videos'), menu: [
            { text: editor.getLang('livemesh.vimeo_video'), onclick: function(e){ addPopup('vimeo_video') } },
            { text: editor.getLang('livemesh.audio'), onclick: function(e){ addPopup('audio') } }

        ] },


        
        { text: editor.getLang('livemesh.blog_posts_shortcodes'), menu: [
            { text: editor.getLang('livemesh.show_post_snippets'), onclick: function(e){ addPopup('show_post_snippets') } },
            { text: editor.getLang('livemesh.recent_posts'), onclick: function(e){ addPopup('recent_posts') } },
            { text: editor.getLang('livemesh.popular_posts'), onclick: function(e){ addPopup('popular_posts') } },
            { text: editor.getLang('livemesh.category_posts'), onclick: function(e){ addPopup('category_posts') } },
            { text: editor.getLang('livemesh.tag_posts'), onclick: function(e){ addPopup('tag_posts') } },
            { text: editor.getLang('livemesh.show_custom_post_types'), onclick: function(e){ addPopup('show_custom_post_types') } }

        ] },

        { text: editor.getLang('livemesh.slider_shortcodes'), menu: [
            { text: editor.getLang('livemesh.responsive_slider'), onclick: function(e){ addPopup('responsive_slider') } },
            { text: editor.getLang('livemesh.tab_slider'), onclick: function(e){ addPopup('tab_slider') } },
        ] },

        { text: editor.getLang('livemesh.social_shortcodes'), menu: [
            { text: editor.getLang('livemesh.social_list'), onclick: function(e){ addPopup('social_list') } },
            { text: editor.getLang('livemesh.donate'), onclick: function(e){ addPopup('donate') } },
            { text: editor.getLang('livemesh.subscribe_rss'), onclick: function(e){ addPopup('subscribe_rss') } },

        ] },


        { text: editor.getLang('livemesh.tabs_shortcodes'), menu: [
            { text: editor.getLang('livemesh.tabgroup'), onclick: function(e){ addPopup('tabgroup') } },
            { text: editor.getLang('livemesh.toggle'), onclick: function(e){ addPopup('toggle') } },

        ] },

        { text: editor.getLang('livemesh.stats_shortcodes'), menu: [
            { text: editor.getLang('livemesh.stats'), onclick: function(e){ addPopup('stats') } },
            { text: editor.getLang('livemesh.animate_numbers'), onclick: function(e){ addPopup('animate_numbers') } },
            { text: editor.getLang('livemesh.piechart'), onclick: function(e){ addPopup('piechart') } },
        ] },

        { text: editor.getLang('livemesh.miscellaneous_shortcodes'), menu: [
            { text: editor.getLang('livemesh.message'), onclick: function(e){ addPopup('message') } },
            { text: editor.getLang('livemesh.box_frame'), onclick: function(e){ addPopup('box_frame') } },
            { text: editor.getLang('livemesh.divider'), onclick: function(e){ addPopup('divider') } },
            { text: editor.getLang('livemesh.clear'), onclick: function(e){ addPopup('clear') } },
            { text: editor.getLang('livemesh.header_fancy'), onclick: function(e){ addPopup('header_fancy') } },
        ] },
    ];


    editor.addButton('livemeshShortcodes', {
        icon: 'livemeshtools',
        text: false,
        tooltip: editor.getLang('livemesh.insert'),
        type: 'menubutton',
        menu: menu_items
    });

    function addPopup( shortcode ) {
        tinyMCE.activeEditor.execCommand( "livemeshPopup", false, {
            title: tinyMCE.activeEditor.getLang('livemesh.insert'),
            identifier: shortcode
        });
    }
});
