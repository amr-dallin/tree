<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Edit media'));
$this->end();

$this->start('nav');
echo $this->element('admin_nav');
$this->end();



$this->start('jinclude');
echo $this->Html->script(array(
    'select2/select2.min',
    'select2/i18n/ru',
    'panel',
    'settings',
    'jquery.photomarks',
    'jquery.imgareaselect.min'
));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        
        $('.viewer-content').photoMarks({
            itemId: <?php echo $item['Item']['id']; ?>,
            marks: <?php echo $item['Mark']; ?>
        });
        
        $('#ItemAlbumId').select2({
            placeholder: '<?php echo __('Select an album for the media'); ?>',
            allowClear: true,
            language: "ru"
        });
    });
</script>
<?php $this->end(); ?>

<!--
<div class="control-panel">
    <span id="control-panel-setting">
        <i class="fa fa-cog"></i>
    </span>

    <div class="control-panel-block">
        <span class="control-panel-title"><?php echo __('Status'); ?></span>
        <?php echo $this->Item->mode($item); ?>
    </div>
</div>
-->

<div class="viewer">
    <div class="container-fluid">
        <div class="row">
            <div class="viewer-top">
            <?php echo $this->Item->linkBackCollection(); ?>
                <ul class="list-inline pull-right">
                    <li>
                        <?php
                        echo $this->Html->link(
                            $this->Html->tag('span', '', array('class' => 'fa fa-tags fa-lg')),
                            '#', 
                            array(
                                'id' => 'mark-button',
                                'class' => 'link-icon-gray',
                                'escape' => false
                            )
                        );
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="viewer-content">
                <div class="viewer-item">
                    <?php echo $this->Item->viewerImage($item); ?>
                    <div class="marks-container"></div>
                </div>
                <div class="mlabels-container">
                    <?php echo __('Marked on media file:'); ?>
                    <ul class="mlabels"></ul>
                </div>
                <?php echo $this->Item->viewerNav($collection, true); ?>
            </div>
        </div>
        <div class="row">
            <div class="viewer-bottom">
            </div>
        </div>
    </div>
</div>

<?php echo $this->Form->create('Item', array('autocomplete' => 'off')); ?>
    <div class="gallery bg-gray-lighter pad-top-bottom-20">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <fieldset>
                        <?php
                        echo $this->Form->input(
                            'id', array(
                                'type' => 'hidden',
                                'value' => $this->request->data['Item']['id']
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
                            'position',
                            array(
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'placeholder' => __('Position')
                            )
                        );
                        
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
                                        'type' => 'text',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('From')
                                    ));
                                
                                echo $this->Form->input(
                                    'end_year', array(
                                        'type' => 'text',
                                        'div' => array('class' => 'col-xs-6'),
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => __('To')
                                    ));
                                ?>
                            </div>
                        </div>
                        <?php
                        echo $this->Form->submit(__('Edit'), array(
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
