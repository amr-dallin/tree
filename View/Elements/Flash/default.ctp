<?php $this->start('jscript'); ?>
<script type="text/javascript">
notification('<?php echo $params['type']; ?>', '<?php echo $message; ?>');
</script>
<?php $this->end(); ?>