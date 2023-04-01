<?php
$this->layout = 'login';
$this->start('title');
echo $this->Html->titleForLayout(__('Log In'));
$this->end();
?>


<div class="bg-gray-lighter pad-top-bottom-20">
    <div class="container">
        <div class="row">
            <h2 class="text-center"><?php echo __('Log In to continue'); ?></h2>
            <div class="col-xs-10 col-sm-6 col-md-4  col-xs-offset-1 col-sm-offset-3 col-md-offset-4">
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

            $errorField = '';
            if ($this->Form->isFieldError('username')) {
                $errorField = 'has-error';
            }
            echo $this->Form->input('username', array(
                'div' => array('class' => 'form-group ' . $errorField),
                'label' => array('class' => 'sr-only', 'value' => __('Username')),
                'placeholder' => __('Username'),
                'class' => 'form-control',
                'type' => 'text'
                ));
            
            $errorField = '';
            if ($this->Form->isFieldError('username')) {
                $errorField = 'has-error';
            }
            echo $this->Form->input('password', array(
                'div' => array('class' => 'form-group ' . $errorField),
                'label' => array('class' => 'sr-only', 'value' => __('Username')),
                'placeholder' => __('Password'),
                'class' => 'form-control',
                'type' => 'password'
                ));
            
            echo $this->Form->end(array(
                'div' => array('class' => 'form-group'),
                'class' => 'btn btn-primary btn-block',
                'label' => __('Log In')
            ));
            ?>
            </div>
        </div>
    </div>
</div>