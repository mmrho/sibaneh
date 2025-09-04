<?php
defined('ABSPATH') || exit;

/**
 * TOC - Admin page template (Modern UI)
 */
?>

<div class="wrap ctato-wrap">
    <h1 class="ctato-title">TOC Manager</h1>

    <div id="ctato-toc-manager" class="ctato-manager">

        <!-- Controls -->
        <div class="ctato-controls">
            <div class="ctato-field-group">
                <select id="ctato-page-select" class="ctato-select">
                    <option value="">— Select page —</option>
                    <?php
                    if (isset($pages) && is_array($pages)) {
                        foreach ($pages as $p) {
                            echo '<option value="' . esc_attr($p['id']) . '">' . esc_html($p['title']) . '</option>';
                        }
                    } else {
                        $all = get_posts([
                            'post_type'      => 'page',
                            'posts_per_page' => 500,
                            'post_status'    => ['publish', 'private'],
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        ]);
                        foreach ($all as $p) {
                            echo '<option value="' . esc_attr($p->ID) . '">' . esc_html(get_the_title($p->ID)) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="ctato-field-group">
                <input 
                    id="ctato-custom-title" 
                    type="text" 
                    class="ctato-input" 
                    placeholder="Optional custom title" 
                />
            </div>

            <div class="ctato-actions">
                <button id="ctato-add-node" class="button button-primary">
                    Add
                </button>
                <button id="ctato-save-tree" class="button button-success">
                     Save
                </button>
            </div>
        </div>

        <!-- Tree -->
        <div id="ctatoc-tree" class="ctato-tree"></div>

        <!-- Edit controls -->
        <div class="ctato-edit-controls">
            <button id="ctato-move-up" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-arrow-up-alt2"></span>
            </button>
            <button id="ctato-move-down" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-arrow-down-alt2"></span>
            </button>
            <button id="ctato-edit-title" class="button button-secondary ctato-button" disabled>
                <span class="dashicons dashicons-edit"></span>
            </button>
            <button id="ctato-delete-node" class="button button-danger ctato-button" disabled>
                <span class="dashicons dashicons-trash"></span>
            </button>
        </div>

        <!-- Help -->
        <div class="ctato-help"  style=" direction: ltr;">
            <details>
                <summary><strong>How it works</strong></summary>
                <p>
                    Drag and drop to make children.  
                    Select nodes to edit, move, or delete.  
                </p>
            </details>
            <span id="ctato-save-status" class="ctato-status" style=" direction: ltr;"></span>
        </div>
    </div>
</div>

<!-- Template -->
<script type="text/html" id="ctato-node-template">
    <span class="ctato-node-title"></span>
</script>
