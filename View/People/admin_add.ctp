<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Add Person'));
$this->end();

$this->start('nav');
$menu[2][0] = true;
echo $this->element('admin_nav', array('menu' => $menu));
$this->end();

$this->start('jinclude');
echo $this->Html->script(array(
    'select2/select2.min',
    'select2/i18n/ru',
    'settings'
));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#PersonFatherId').select2({
            placeholder: '<?php echo __('Select Father'); ?>',
            allowClear: true,
            language: "ru"
        });
        
        $('#PersonMotherId').select2({
            placeholder: '<?php echo __('Select Mother'); ?>',
            allowClear: true,
            language: "ru"
        });
        
        $('#PersonSpouseId').select2({
            placeholder: '<?php echo __('Select Spouse'); ?>',
            allowClear: true,
            language: "ru"
        });
    });
</script>
<?php $this->end(); ?>


    <div class="gallery bg-gray-lighter">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2><?php echo __('Add Person'); ?></h2>
                    <hr/>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <?php echo $this->Form->create('Person', array('autocomplete' => 'off')); ?>
                    <fieldset>                    
                        <div class="row">
                        <?php
                        echo $this->Form->input(
                            'last_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4'),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('Last Name')
                            )
                        );
                                
                        echo $this->Form->input(
                            'first_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4'),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('First Name')
                            )
                        );
                                
                        echo $this->Form->input(
                            'second_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4'),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('Second Name')
                            )
                        );
                        ?>
                        </div>
                        
                        <?php
                        echo $this->Form->input(
                            'father_id', 
                            array(
                                'type' => 'select',
                                'div' => array('class' => 'form-group'),
                                'label' => array(
                                    'value' => __('Select Father'),
                                    'class' => 'sr-only'
                                ),
                                'empty' => array('' => __('Select Father')),
                                'options' => $fathers,
                                'class' => 'form-control'
                            )
                        );
                        
                        echo $this->Form->input(
                            'mother_id', 
                            array(
                                'type' => 'select',
                                'div' => array('class' => 'form-group'),
                                'label' => array(
                                    'value' => __('Select Mother'),
                                    'class' => 'sr-only'
                                ),
                                'empty' => array('' => __('Select Mother')),
                                'options' => $mothers,
                                'class' => 'form-control'
                            )
                        );
                        
                        echo $this->Form->input(
                            'spouse_id', 
                            array(
                                'type' => 'select',
                                'div' => array('class' => 'form-group'),
                                'label' => array(
                                    'value' => __('Select Spouse'),
                                    'class' => 'sr-only'
                                ),
                                'empty' => array('' => __('Select Spouse')),
                                'options' => $spouses,
                                'class' => 'form-control'
                            )
                        );
                        ?>
                        
                        <div class="row">
                        <?php
                        echo $this->Form->input(
                            'birthday',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-6'),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('Birthday(yyyy-mm-dd)')
                            )
                        );
                                
                        echo $this->Form->input(
                            'gender',
                            array(
                                'type' => 'radio',
                                'options' => array(
                                    1 => __('Male'),
                                    2 => __('Female') 
                                ),
                                'default' => 1,
                                'div' => 'col-md-6 form-group',
                                'legend' => false,
                                'label' => false,
                                'before' => '<label class="radio-inline">',
                                'separator' => '</label><label class="radio-inline">',
                                'after' => '</label>'
                            )
                        );
                        ?>    
                        </div>
                        
                        <?php
                        echo $this->Form->input(
                            'biography',
                            array(
                                'type' => 'textarea',
                                'div' => array('class' => 'form-group'),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'rows' => 8,
                                'placeholder' => __('Biography')
                            )
                        );
                        
                        echo $this->Form->submit(
                            __('Add'),
                            array(
                                'div' => false, 
                                'class' => 'btn btn-primary btn-block'
                            )
                        );
                        ?>
                    </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>

            
        </div>
    </div>

