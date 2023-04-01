<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Edit an account @%s', $user['User']['username']));
$this->end();

$this->start('nav');
$menu[3][1] = true;
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
        $('#UserPersonId').select2({
            placeholder: '<?php echo __('Select user personal information'); ?>',
            allowClear: true,
            language: "ru"
        });
    });
</script>
<?php $this->end(); ?>


<?php
echo $this->Form->create(
    'User', 
    array(
        'autocomplete' => 'off', 
        'class' => 'form-horizontal',
        'role' => 'form',
        'inputDefaults' => array(
            'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline'))
        )
    )
);
?>
    <div class="gallery bg-gray-lighter">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2><?php echo __('Edit an account @%s', $user['User']['username']); ?></h2>
                    <hr/>
                </div>
                <div class="col-md-8 col-md-offset-2">
                        <?php
                        echo $this->Form->input('id', array(
                            'type' => 'hidden'
                        ));
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('username')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('username', array(
                            'type' => 'text',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array('class' => 'col-sm-2 control-label'),
                            'class' => 'form-control',
                            'placeholder' => __('Username'),
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('person_id')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('person_id', array(
                            'type' => 'select',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array(
                                'class' => 'col-sm-2 control-label',
                                'text' => __('Person')
                            ),
                            'empty' => array('' => ''),
                            'options' => $people,
                            'class' => 'form-control',
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        ?>
                        <hr/>
                        <?php
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('password')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('password', array(
                            'type' => 'password',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array('class' => 'col-sm-2 control-label'),
                            'class' => 'form-control',
                            'placeholder' => __('Passowrd'),
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('confirm_password')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('confirm_password', array(
                            'type' => 'password',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array(
                                'class' => 'col-sm-2 control-label',
                                'text' => __('Confirm Password')
                            ),
                            'class' => 'form-control',
                            'placeholder' => __('Confirm Password'),
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        ?>
                        <hr/>
                        <?php
                        $errorField = '';
                        if ($this->Form->isFieldError('full_name')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('full_name', array(
                            'type' => 'text',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array('class' => 'col-sm-2 control-label'),
                            'class' => 'form-control',
                            'placeholder' => __('Full name'),
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        
                        $errorField = '';
                        if ($this->Form->isFieldError('email')) {
                            $errorField = 'has-error';
                        }
                        echo $this->Form->input('email', array(
                            'type' => 'email',
                            'div' => array('class' => 'form-group ' . $errorField),
                            'label' => array('class' => 'col-sm-2 control-label'),
                            'class' => 'form-control',
                            'placeholder' => __('Email'),
                            'between' => '<div class="col-sm-10">',
                            'after' => '</div>'
                        ));
                        
                        echo $this->Form->submit(__('Edit'), array(
                            'div' => false, 
                            'class' => 'btn btn-primary btn-block'
                        ));
                        ?>

                </div>
            </div>
        </div>
    </div>
<?php echo $this->Form->end(); ?>



