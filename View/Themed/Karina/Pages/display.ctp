<?php
$this->layout = 'display';
$this->start('title');
echo $this->Html->titleForLayout(__('Dasboard'));
$this->end();

$this->start('ribbon');
$breadcrumbs = array();
echo $this->element('Authorized/ribbon', array('breadcrumbs' => $breadcrumbs));
$this->end();

$this->start('headline');
echo $this->element('Authorized/headline', array('title' => 'Dashboard'));
$this->end();

$this->start('navigation');
$menu['dashboard'] = array();
echo $this->element('Authorized/navigation', array('menu' => $menu));
$this->end();
?>



<section class="imagebg height-100 text-center" data-gradient-bg="#5f2c82,#49a09d,#F3A183,#5f2c82">
    <div class="background-image-holder">
    <?php echo $this->Html->image('inner-4.jpg'); ?>
    </div>
    <div class="container pos-vertical-center">
        <div class="row">
            <div class="col-sm-9">

                <span class="h1 countdown" data-date="09/25/2017" data-date-fallback="Launching Soon"></span>
                <p class="lead">
                    Themeforest's most popular HTML page builder, 100+ page templates,
                    <br class="hidden-xs hidden-sm" /> 150+ unique blocks, premium plugins and icons, plus much more.
                </p>
                <div class="modal-instance">
                    <a class="modal-trigger btn btn--primary type--uppercase" href="#">
                        <span class="btn__text">
                            Notify Me
                        </span>
                    </a>
                    <div class="modal-container">
                        <div class="modal-content imagebg text-center">
                            <div class="container">
                                <div class="row">
                                    <h2>Get notified as soon as we launch!</h2>
                                    <form action="//mrare.us8.list-manage.com/subscribe/post?u=77142ece814d3cff52058a51f&amp;id=f300c9cce8" data-success="Thanks for signing up.  Please check your inbox for a confirmation email." data-error="Please provide your name and email address and agree to the terms.">
                                        <div class="col-md-4 col-sm-4">
                                            <input class="validate-required" type="text" name="NAME" placeholder="Your Name" />
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <input class="validate-required validate-email" type="email" name="EMAIL" placeholder="Email Address" />
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <button type="submit" class="btn btn--primary type--uppercase">Subscribe</button>
                                        </div>
                                        <div class="col-sm-12">
                                            <input class="validate-required" type="checkbox" name="group[13737][1]" />
                                            <span>I have read and agree to the
                                                <a href="#">terms and conditions</a>
                                            </span>
                                        </div>
                                        <div style="position: absolute; left: -5000px;" aria-hidden="true">
                                            <input type="text" name="b_77142ece814d3cff52058a51f_f300c9cce8" tabindex="-1" value="">
                                        </div>
                                    </form>
                                </div>
                                <!--end of row-->
                            </div>
                            <!--end of container-->
                        </div>
                    </div>
                    <!--end modal container-->
                </div>
                <!--end modal instance-->
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>