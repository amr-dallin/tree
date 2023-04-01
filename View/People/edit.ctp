<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Edit'));
$this->end();

$menu[3][5] = true;
$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('navigation');
echo $this->element('navigation', array('menu' => $menu));
$this->end();

$this->start('css-include');
echo $this->Html->css(
    array(
        '../lib/inputmask/css/inputmask'
    )
);
$this->end();

$this->start('jinclude');
echo $this->Html->script(array(
    '../lib/inputmask/js/min/inputmask/inputmask.min',
    '../lib/inputmask/js/min/inputmask/inputmask.extensions.min',
    '../lib/inputmask/js/min/jquery.inputmask.bundle.min',
    '../lib/inputmask/js/min/inputmask/inputmask.numeric.extensions.min',
    '../lib/inputmask/js/min/inputmask/jquery.inputmask.min'
    
));
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#PersonBirthday').inputmask(
            "99/99/9999",
            { yearrange: { minyear: 1900, maxyear: 2015 }}
        );
    });
</script>
<?php $this->end(); ?>


    <div class="gallery bg-gray-lighter pad-top-bottom-20">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
<?php
echo $this->Form->create(
    'Person', 
    array(
        'autocomplete' => 'off',
        'role' => 'form',
        'inputDefaults' => array(
            'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
        )
    )
);
?>
                    <fieldset>                    
                        <div class="row">
                        <?php
                        $errorField = '';
                        if ($this->Form->isFieldError('last_name')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'last_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4 ' . $errorField),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('Last Name')
                            )
                        );

                        $errorField = '';
                        if ($this->Form->isFieldError('first_name')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'first_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4 ' . $errorField),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('First Name')
                            )
                        );
                                
                        $errorField = '';
                        if ($this->Form->isFieldError('second_name')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'second_name',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-4 ' . $errorField),
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __('Second Name')
                            )
                        );
                        ?>
                        </div>
                        
                        <div class="row">
                        <?php
                        $errorField = '';
                        if ($this->Form->isFieldError('birthday')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'birthday',
                            array(
                                'type' => 'text',
                                'div' => array('class' => 'form-group col-md-6 ' . $errorField),
                                'label' => false,
                                'class' => 'form-control',
                                'value' => $this->Html->dateFormat('d/m/Y', $this->request->data['Person']['birthday']),
                                'placeholder' => __('Birthday')
                            )
                        );
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('gender')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'gender',
                            array(
                                'type' => 'radio',
                                'options' => array(
                                    1 => __('Male'),
                                    2 => __('Female') 
                                ),
                                'default' => 1,
                                'div' => 'col-md-6 form-group ' . $errorField,
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
                        $errorField = '';
                        if ($this->Form->isFieldError('biography')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input(
                            'biography',
                            array(
                                'type' => 'textarea',
                                'div' => array('class' => 'form-group ' . $errorField),
                                'label' => array('class' => 'sr-only'),
                                'class' => 'form-control',
                                'rows' => 16,
                                'placeholder' => __('Biography')
                            )
                        );
                        
                        echo $this->Form->submit(
                            __('Edit'),
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

