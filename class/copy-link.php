<?php
function add_copy_link_script() {
    ?>
    <script>
    function copyToClipboard(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'موفق!',
                    text: 'لینک با موفقیت کپی شد',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }).catch(function(err) {
                fallbackCopyTextToClipboard(url);
            });
        } else {
            fallbackCopyTextToClipboard(url);
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";
        
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            var successful = document.execCommand("copy");
            Swal.fire({
                icon: successful ? 'success' : 'error',
                title: successful ? 'موفق!' : 'خطا!',
                text: successful ? 'لینک با موفقیت کپی شد' : 'خطا در کپی کردن لینک',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'خطا در کپی کردن لینک',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
        
        document.body.removeChild(textArea);
    }
    </script>
    <?php
}
add_action('wp_footer', 'add_copy_link_script');
