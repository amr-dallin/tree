<?php
/**
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>

<div class="navigation">
    <div class="container">
        <div class="row">
            <div class="pn-ProductNav_Wrapper">

                <nav id="pnProductNav" class="pn-ProductNav">
                    <div id="pnProductNavContents" class="pn-ProductNav_Contents">
                    <?php
                    $active = '';
                    if (isset($menu[2][0])) $active = 'active';
                    echo $this->Html->link(
                        __('Biography'), 
                        array('controller' => 'people', 'action' => 'view', $person_id, 'admin' => false),
                        array('class' => 'pn-ProductNav_Link ' . $active)
                    );

                    $active = '';
                    if (isset($menu[2][1])) $active = 'active';
                    echo $this->Html->link(
                        __('Family'), 
                        array('controller' => 'people', 'action' => 'family', $person_id, 'admin' => false),
                        array('class' => 'pn-ProductNav_Link ' . $active)
                    );
                    
                    $active = '';
                    if (isset($menu[2][2])) $active = 'active';
                    echo $this->Html->link(
                        __('Marked on media files'), 
                        array('controller' => 'marks', 'action' => 'index', $person_id, 'admin' => false),
                        array('class' => 'pn-ProductNav_Link ' . $active)
                    );
                    ?>
                    </div>
                </nav>
                <button id="pnAdvancerLeft" class="pn-Advancer pn-Advancer_Left" type="button">
                    <svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M445.44 38.183L-2.53 512l447.97 473.817 85.857-81.173-409.6-433.23v81.172l409.6-433.23L445.44 38.18z"/></svg>
                </button>
                <button id="pnAdvancerRight" class="pn-Advancer pn-Advancer_Right" type="button">
                    <svg class="pn-Advancer_Icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 551 1024"><path d="M105.56 985.817L553.53 512 105.56 38.183l-85.857 81.173 409.6 433.23v-81.172l-409.6 433.23 85.856 81.174z"/></svg>
                </button>
            </div>
        </div>


    </div>
</div>

