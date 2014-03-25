// add custom tinymce buttons for mcms member functions
(function() {
	tinymce.create('tinymce.plugins.visitor', {
		init:          function(ed, url) {
			ed.addButton('visitor', {
				title:   'Logged Out (visitor)',
				image:   plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/user-icon-out.png',
				onclick: function() {
					ed.selection.setContent('[visitor]' + ed.selection.getContent() + '[/visitor]');
					ed.undoManager.add();
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('visitor', tinymce.plugins.visitor);

	tinymce.create('tinymce.plugins.member', {
		init:          function(ed, url) {
			ed.addButton('member', {
				title:   'Logged In (member)',
				image:   plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/user-icon-in.png',
				onclick: function() {
					ed.selection.setContent('[member]' + ed.selection.getContent() + '[/member]');
					ed.undoManager.add();
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('member', tinymce.plugins.member);

	tinymce.create('tinymce.plugins.access', {
		init:          function(ed, url) {
			ed.addButton('access', {
				title:   'Access (member w/ capability)',
				image:   plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/user-icon-access.png',
				onclick: function() {
					ed.selection.setContent('[access capability="read"]' + ed.selection.getContent() + '[/access]');
					ed.undoManager.add();
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('access', tinymce.plugins.access);

	tinymce.create('tinymce.plugins.inlinepost', {
		init:          function(ed, url) {
			ed.addButton('inlinepost', {
				title:   'Insert inline post content',
				image:   plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/page-icon.png',
				onclick: function() {
					ed.selection.setContent('[inline-post format="title_content" id=""]');
					ed.undoManager.add();
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('inlinepost', tinymce.plugins.inlinepost);

	tinymce.create('tinymce.plugins.inlineposts', {
		init:          function(ed, url) {
			ed.addButton('inlineposts', {
				title:   'Insert inline posts content',
				image:   plugins_url + '/' + MAPI_PLUGIN_SLUG + '/img/pages-icon.png',
				onclick: function() {
					ed.selection.setContent('[inline-query format="list" post_type="post" posts_per_page="5" category_name="uncategorized"]');
					ed.undoManager.add();
				}
			});
		},
		createControl: function(n, cm) {
			return null;
		},
	});
	tinymce.PluginManager.add('inlineposts', tinymce.plugins.inlineposts);
})();
