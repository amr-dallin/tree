<?php
$this->layout = 'ajax';
if (!empty($comment)) {
    echo $this->Item->comment($comment);
}
?>
