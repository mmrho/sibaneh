/**
 * tableOfContents - Admin JS
 * Initializes jsTree on #ctatoc-tree, handles add node, save, delete.
 * Expects toc_data localized object: { ajax_url, nonce, posts }
 */

jQuery(document).ready(function($){
    // Ensure toc_data exists
    window.toc_data = window.toc_data || {};

    // Prepare initial tree data by requesting via AJAX
    function loadTree() {
        return $.ajax({
            url: toc_data.ajax_url,
            method: 'POST',
            data: {
                action: 'tableOfContents_get_toc'
            }
        });
    }

    // Initialize jsTree after loading data
    loadTree().done(function(resp){
        var treeData = [];
        if ( resp.success && resp.data && resp.data.tree ) {
            treeData = transformServerTreeToJsTree(resp.data.tree);
        }

        $('#ctatoc-tree').jstree({
            'core' : {
                'check_callback' : true,
                'data' : treeData,
                'multiple': true, // فعال کردن multi-select
                // 'themes': { 'dots': true }, // برای بهتر دیدن ساختار
                // اگر بخوای درخت flat باشه: 'max_depth': 1
            },
            'plugins' : ['dnd', 'types', 'wholerow', 'unique'],
            'types' : {
                'default' : { 'icon' : 'dashicons dashicons-admin-page' }
            }
        }).on('changed.jstree', function(e, data) { // استفاده از changed برای select/deselect
            var selectedCount = data.selected.length;
            if (selectedCount > 0) {
                $('#ctato-delete-node').prop('disabled', false);
                // up/down و edit فقط برای single selection
                if (selectedCount === 1) {
                    $('#ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', false);
                    
                    // لینک به ویرایش محتوا (در تب جدید)
                    var node = data.instance.get_node(data.selected[0]);
                    var postId = node.data.post_id; // تغییر به post_id
                    if (postId) {
                        window.open(ajaxurl.replace('admin-ajax.php', 'post.php') + '?post=' + postId + '&action=edit', '_blank');
                    }
                } else {
                    $('#ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', true);
                }
            } else {
                $('#ctato-delete-node, #ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', true);
            }
        });
        
        // Delete node on Delete key
        $(document).on('keydown', function(e){
            if ( e.key === 'Delete' || e.key === 'Del' ) {
                deleteSelectedNodes();
            }
        });
    });

    // تابع کمکی برای حذف همه نودهای انتخاب‌شده
    function deleteSelectedNodes() {
        var inst = $('#ctatoc-tree').jstree(true);
        var sel = inst.get_selected();
        if (sel && sel.length) {
            sel.forEach(function(nodeId) {
                inst.delete_node(nodeId);
            });
        }
    }

    // Transform server nodes to jsTree format
    function transformServerTreeToJsTree(nodes) {
        var out = [];
        nodes.forEach(function(n){
            var node = {
                id: 'db_' + n.db_id, // prefix to avoid collisions
                text: n.title ? n.title : (n.post_id ? ('Content ' + n.post_id) : 'Untitled'), // تغییر به post_id
                data: {
                    db_id: n.db_id,
                    post_id: n.post_id // تغییر به post_id
                },
                children: []
            };
            if ( n.children && n.children.length ) {
                node.children = transformServerTreeToJsTree( n.children );
            }
            out.push(node);
        });
        return out;
    }

    // Convert jsTree nodes to server format expected by save endpoint
    function extractTreeFromJsTree() {
        var inst = $('#ctatoc-tree').jstree(true);
        var rootNodes = inst.get_json('#', { flat:false });

        function convert(nodes) {
            var out = [];
            nodes.forEach(function(n){
                var post_id = n.data && n.data.post_id ? n.data.post_id : null; // تغییر به post_id
                var title = n.text;
                out.push({
                    post_id: post_id, // تغییر به post_id
                    title: title,
                    children: convert(n.children || [])
                });
            });
            return out;
        }

        return convert(rootNodes);
    }

    // Add Node button handler
    $('#ctato-add-node').on('click', function(e){
        e.preventDefault();
        var postId = $('#ctato-post-select').val(); // تغییر به post-select
        if ( ! postId ) {
            alert('Please select a content to add.');
            return;
        }
        var customTitle = $('#ctato-custom-title').val();

        // Create a new node in jsTree root
        var inst = $('#ctatoc-tree').jstree(true);
        var nodeText = customTitle ? customTitle : $('#ctato-post-select option:selected').text();

        // Generate a temporary ID for client-only node
        var tempId = 'new_' + Date.now();

        inst.create_node('#', {
            id: tempId,
            text: nodeText,
            data: { post_id: parseInt(postId,10) } // تغییر به post_id
        }, 'last', function(node) {
            inst.deselect_all();
            inst.select_node(node);
        });

        // Clear inputs
        $('#ctato-post-select').val('');
        $('#ctato-custom-title').val('');
    });

    // New: Add New Content button handler (ایجاد CPT جدید با AJAX)
    $('#ctato-add-new-content').on('click', function(e){
        e.preventDefault();
        var newTitle = prompt('Enter title for new content:');
        if (!newTitle || newTitle.trim() === '') {
            return;
        }

        $.ajax({
            url: toc_data.ajax_url,
            method: 'POST',
            data: {
                action: 'tableOfContents_create_new_content',
                nonce: toc_data.nonce,
                title: newTitle
            },
            success: function(resp){
                if (resp.success && resp.data.post_id) {
                    // اضافه کردن به سلکت
                    $('#ctato-post-select').append('<option value="' + resp.data.post_id + '">' + newTitle + '</option>');
                    alert('New content created with ID: ' + resp.data.post_id);
                    // اختیاری: مستقیم اضافه به درخت
                } else {
                    alert('Error: ' + (resp.data.message || 'Unknown'));
                }
            },
            error: function(){
                alert('AJAX error.');
            }
        });
    });

    // Delete button handler
    $('#ctato-delete-node').on('click', function(e){
        e.preventDefault();
        deleteSelectedNodes();
    });

    // Move Up button handler (فقط برای single)
    $('#ctato-move-up').on('click', function(e){
        e.preventDefault();
        var inst = $('#ctatoc-tree').jstree(true);
        var sel = inst.get_selected(true)[0];
        if (sel) {
            var prev = inst.get_prev_dom(sel);
            if (prev) {
                inst.move_node(sel, prev, 'before');
            }
        }
    });

    // Move Down button handler (فقط برای single)
    $('#ctato-move-down').on('click', function(e){
        e.preventDefault();
        var inst = $('#ctatoc-tree').jstree(true);
        var sel = inst.get_selected(true)[0];
        if (sel) {
            var next = inst.get_next_dom(sel);
            if (next) {
                inst.move_node(sel, next, 'after');
            }
        }
    });

    // Edit Title button handler (جدید - فقط برای single)
    $('#ctato-edit-title').on('click', function(e){
        e.preventDefault();
        var inst = $('#ctatoc-tree').jstree(true);
        var sel = inst.get_selected(true)[0];
        if (sel) {
            var currentText = inst.get_text(sel);
            var newText = prompt('Edit title:', currentText);
            if (newText !== null && newText.trim() !== '') {
                inst.set_text(sel, newText);
            }
        }
    });

    // Save button handler
    $('#ctato-save-tree').on('click', function(e){
        e.preventDefault();
        $('#ctato-save-status').text('Saving...');
        var payload = extractTreeFromJsTree();
        $.ajax({
            url: toc_data.ajax_url,
            method: 'POST',
            data: {
                action: 'tableOfContents_save_toc',
                nonce: toc_data.nonce,
                tree: JSON.stringify(payload)
            },
            success: function(resp){
                if ( resp && resp.success ) {
                    $('#ctato-save-status').text('Saved.');
                    // reload tree to get new db_ids
                    setTimeout(function(){
                        $('#ctatoc-tree').jstree('destroy');
                        loadTree().done(function(resp2){
                            var treeData = [];
                            if ( resp2.success && resp2.data && resp2.data.tree ) {
                                treeData = transformServerTreeToJsTree(resp2.data.tree);
                            }
                            $('#ctatoc-tree').jstree({
                                'core' : {
                                    'check_callback' : true,
                                    'data' : treeData,
                                    'multiple': true // نگه داشتن multi-select بعد از reload
                                },
                                'plugins' : ['dnd', 'types', 'wholerow', 'unique'],
                                'types' : {
                                    'default' : { 'icon' : 'dashicons dashicons-admin-page' }
                                }
                            }).on('changed.jstree', function(e, data) {
                                var selectedCount = data.selected.length;
                                if (selectedCount > 0) {
                                    $('#ctato-delete-node').prop('disabled', false);
                                    if (selectedCount === 1) {
                                        $('#ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', false);
                                        
                                        // لینک به ویرایش (تکرار برای reload)
                                        var node = data.instance.get_node(data.selected[0]);
                                        var postId = node.data.post_id;
                                        if (postId) {
                                            window.open(ajaxurl.replace('admin-ajax.php', 'post.php') + '?post=' + postId + '&action=edit', '_blank');
                                        }
                                    } else {
                                        $('#ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', true);
                                    }
                                } else {
                                    $('#ctato-delete-node, #ctato-move-up, #ctato-move-down, #ctato-edit-title').prop('disabled', true);
                                }
                            });
                        });
                    }, 600);
                } else {
                    $('#ctato-save-status').text('Error: ' + (resp.data && resp.data.message ? resp.data.message : 'Unknown'));
                }
            },
            error: function(xhr){
                $('#ctato-save-status').text('AJAX error.');
            }
        });
    });

});