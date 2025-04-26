<?php
add_action('user_new_form', 'extra_user_profile_fields');
add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

function extra_user_profile_fields($user)
{

    if ($user === 'add-new-user') {
        echo '<h3>اطلاعات تحصیلی</h3><table class="form-table">';
        require_once THEME_TEMPLATE . "admin/user-fields/new-user.php";
        echo '</table>';
    } else {
        $userMetas = get_user_meta($user->ID);
        $wbsBranch = new Branch();
        if (!in_array('student', $user->roles, true)) {
            ?>
            <table class="form-table">
                <tr>
                    <th><label for="selectBranch">شعبه</label></th>
                    <td>
                        <select id="selectBranch" multiple
                                name="branch_id"
                                data-action="getAllBranches"
                                class="select2 is-ajax-select">
                            <?php if (!empty($userMetas['branch_id'][0])) {
                                foreach ($userMetas['branch_id'] as $getBranch) {
                                    $branch = $wbsBranch->get((int)$getBranch);
                                    ?>
                                    <option selected
                                            value="<?php echo $branch->id; ?>"><?php echo $branch->title; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <?php
        } else {
            echo '<h3>اطلاعات تحصیلی</h3><table class="form-table">';
            require_once THEME_TEMPLATE . "admin/user-fields/exist-user.php";
            echo '</table>';
            echo '<h3>نتایج دانش آموز <button type="button" id="addUserResult" class="button button-primary">جدید</button></h3>';
            require_once THEME_TEMPLATE . "admin/user-fields/results.php";
        }
    }

}


add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');
add_action('user_register', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id)
{
    update_user_meta($user_id, 'national_id', (int)$_POST['national_id']);
    update_user_meta($user_id, 'birthdate', sanitize_text_field(esc_sql($_POST['birthdate'])));
    update_user_meta($user_id, 'father_phone', sanitize_text_field(esc_sql($_POST['father_phone'])));
    update_user_meta($user_id, 'mother_phone', sanitize_text_field(esc_sql($_POST['mother_phone'])));
    update_user_meta($user_id, 'gender', sanitize_text_field(esc_sql($_POST['gender'])));
    update_user_meta($user_id, 'year', sanitize_text_field(esc_sql($_POST['year'])));
    update_user_meta($user_id, 'grade_id', (int)$_POST['grade_id']);
    update_user_meta($user_id, 'fos_id', (int)$_POST['fos_id']);
    update_user_meta($user_id, 'class_id', (int)$_POST['class_id']);
    update_user_meta($user_id, 'branch_id', (int)$_POST['branch_id']);
    $userResults = !empty($_POST['userResults']) ? array_values($_POST['userResults']) : [];
    update_user_meta($user_id, 'userResults', $userResults);
}
