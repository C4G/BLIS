function toggle_div(div_name) {
    $("#" + div_name).hide();
}

function update_database_submit() {
    $('#update_database_progress').show();
    $('#update_database_form').ajax({
        url: 'update_database.php?lid=0&do_currbackup=N&backup_path=0',
        success: function (data) {
            window.location = data;
        }
    });

}

function delete_lab_config(site_name, id) {
    var confirm_code = confirm(
        "Are you sure you want to delete configuration for '" + site_name + "' ?\n" +
        "All data and technician accounts will be deleted permanently. "
    );
    if (confirm_code == false) {
        return;
    }
    var url_string = "ajax/lab_config_delete.php";
    var data_string = "id=" + id;
    $.ajax({
        type: "POST",
        url: url_string,
        data: data_string,
        success: function (msg) {
            window.location = "lab_configs.php";
        }
    });
}

function search_labs(view_all) {
    $('#lab_search_progress_bar').show();
    var url;
    if (view_all == 1) {
        //View all lab configs
        url = "ajax/lab_config_search.php?q=";
        var search_term = $('#lab_search_term').attr("value", "");
        $('#viewall_link').hide();
    }
    else {
        //View by seacrch term
        var search_term = $('#lab_search_term').val();
        url = "ajax/lab_config_search.php?q=" + search_term;
        if (search_term.trim() == "")
            $('#viewall_link').hide();
        else
            $('#viewall_link').show();
    }
    $("#lab_config_list").load(
        url,
        {},
        function () {
            $('#lab_search_progress_bar').hide();
        }
    );
}

function updateKeyForm() {
    const keyDropdown = document.getElementById('keySelectDropdown');

    const keyFileRow = document.getElementById('keyUploadFileRow');
    const keyNameRow = document.getElementById('keyUploadNameRow');

    if (keyDropdown.value === "-1") {
        // "unlisted" is selected
        keyFileRow.style.display = '';
        keyNameRow.style.display = '';
    } else {
        keyFileRow.style.display = 'none';
        keyFileRow.querySelector("input[type='file']").value = '';
        keyNameRow.style.display = 'none';
        keyNameRow.value = '';
        keyNameRow.querySelector("input[type='text']").value = '';
    }
}
