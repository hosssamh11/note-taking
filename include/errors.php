<?php
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo '<div class="error-message">' . $error . '</div>';
    }
}
