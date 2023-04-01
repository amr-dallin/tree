<?php
$this->layout = 'ajax';
foreach($items as $item) {
    echo $this->Item->item($item);
}
?>