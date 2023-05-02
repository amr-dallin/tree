<?php
$menu[1][0] = true;
$this->start('title');
echo $this->Html->titleForLayout(__('Add media'));
$this->end();

$this->start('nav');
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array(
    'select2/select2.min',
    'select2/i18n/ru',
    'panel',
    'settings'
));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {        
        $('#ItemAlbumId').select2({
            placeholder: '<?php echo __('Select an album for the media'); ?>',
            allowClear: true,
            language: "ru"
        });
    });
</script>
<?php $this->end(); ?>

<?php echo $this->Form->create('Item', array('autocomplete' => 'off', 'type' => 'file')); ?>
    <div class="bg-gray-lighter pad-top-bottom-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2><?= __('Add media') ?></h2>
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <fieldset>
                        <?php
                        echo $this->Form->input('file', array(
                            'type' => 'file',
                            'class' => 'form-control',
                            'div' => array('class' => 'form-group'),
                            'label' => array('class' => 'sr-only'),
                        ));
                        
                        echo $this->Form->input(
                            'title', array(
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'placeholder' => __('Media Title')
                            ));
                        
                        echo $this->Form->input(
                            'description', array(
                                'type' => 'textarea',
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'rows' => 4,
                                'placeholder' => __('Media Description')
                            ));
                        
                        echo $this->Form->input(
                            'album_id', array(
                                'type' => 'select',
                                'div' => array('class' => 'form-group'),
                                'label' => array(
                                    'value' => __('Album of a media'),
                                    'class' => 'sr-only'
                                ),
                                'empty' => array('' => ''),
                                'options' => $albums,
                                'class' => 'form-control'
                            ));
                        ?>
                        <div class="form-group">
                            <div class="row">
                                <?php
                                echo $this->Form->input(
                                    'start_year', array(
                                        'type' => 'number',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('From')
                                    ));
                                
                                echo $this->Form->input(
                                    'end_year', array(
                                        'type' => 'number',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('To')
                                    ));
                                ?>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->submit(__('Add'), array(
                            'div' => false, 
                            'class' => 'btn btn-primary btn-block'
                        ));
                        ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->Form->end(); ?>