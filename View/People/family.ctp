<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Family'));
$this->end();

if ($family[0]['Person']['id'] == $this->Session->read('Auth.User.Person.id')) {
    $menu[3][4] = true;
    $this->start('navigation');
    echo $this->element('navigation', array('menu' => $menu));
    $this->end();
} else {
    $this->start('header');
    echo $this->element('person_header', array('person' => $family[0]));
    $this->end();
    
    $menu[2][1] = true;
    $this->start('navigation');
    echo $this->element(
        'navigation_person', 
        array(
            'menu' => $menu, 
            'person_id' => $family[0]['Person']['id']
        )
    );
    $this->end();
}

$this->start('nav');
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('css-include');
echo $this->Html->css(
    array(
        '../lib/jquery-ui-1.12.1/jquery-ui.min',
        '../lib/jquery-ui-1.12.1/jquery-ui.structure.min',
        '../lib/primitives/css/primitives.latest',
        /*'layout-default-latest'*/
    )
);
$this->end();

$this->start('jinclude');
echo $this->Html->script(
    array(
        'jquery-ui-1.10.2.custom.min',
        /*'jquery.layout-latest',*/
        '../lib/primitives/js/primitives.latest',
        '../lib/primitives/js/bporgeditor.latest'
    )
);
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    var m_timer = null;
    $(document).ready(function () {
        ResizePlaceholder();
        
        var options = new primitives.famdiagram.Config();

        var items = <?php echo $this->Html->people($family); ?>;
        
        var templates = [];
        templates.push(getContactTemplate());

        options.items = items;
        options.defaultTemplateName = "contactTemplate";
        options.cursorItem = <?php echo $family[0]['Person']['id']; ?>;
        options.linesWidth = 1;
        options.templates = templates;
        options.arrowsDirection = 2;
        options.onItemRender = onTemplateRender;
        options.hasSelectorCheckbox = primitives.common.Enabled.False;
        options.normalLevelShift = 20;
        options.dotLevelShift = 20;
        options.lineLevelShift = 20;
        options.normalItemsInterval = 10;
        options.dotItemsInterval = 10;
        options.lineItemsInterval = 10;
        options.pageFitMode = 1;
        options.navigationMode = 0;
        options.highlightGravityRadius = 40;
        options.enablePanning = true;

        $("#tree").famDiagram(options);
        
        $(window).resize(function () {
            onWindowResize();
        });
        
        function onTemplateRender(event, data) {
            var itemConfig = data.context;

            if (data.templateName == "contactTemplate") {
                data.element.find("[name=quantity_marks]").attr({"href": itemConfig.quantity_marks_href});
                data.element.find("[name=short_name]").attr({"href": itemConfig.short_name_href});
                data.element.find("[name=avatar]").attr({"src": itemConfig.avatar});

                var fields = ["short_name", "quantity_marks"];
                for (var index = 0; index < fields.length; index++) {
                    var field = fields[index];
                    var element = data.element.find("[name=" + field + "]");
                    if (element.text() != itemConfig[field]) {
                        element.text(itemConfig[field]);
                    }
                }
            }
        }
        
        function getContactTemplate() {
			var result = new primitives.orgdiagram.TemplateConfig();
			result.name = "contactTemplate";

			result.itemSize = new primitives.common.Size(80, 120);
			result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);

			var itemTemplate = $(
                '<div class="person">' +
                    '<div class="avatar"><img name="avatar" /></div>' +
                    '<div class="short-name"><a name="short_name"></a></div>' +
                    '<div class="quantity-marks"><a name="quantity_marks"></a></div>' +
                '</div>'
            ).css({
                width: result.itemSize.width + "px",
                height: result.itemSize.height + "px"
            }).addClass("bp-item bp-corner-all bt-item-frame");
            result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

            return result;
        }
        
        function onWindowResize() {
            if (m_timer == null) {
                m_timer = window.setTimeout(function () {
                    ResizePlaceholder();
                    $("#tree").famDiagram("update", primitives.common.UpdateMode.Refresh)
                    window.clearTimeout(m_timer);
                    m_timer = null;
                }, 300);
            }
        }

        function ResizePlaceholder() {
            var bodyWidth = $(window).width() - 40
            var bodyHeight = $(window).height() - 100
            $("#tree").css(
            {
                "width": bodyWidth + "px",
                "height": bodyHeight + "px"
            });
        }
        
    });
    
</script>
<?php $this->end(); ?>

<div class="container-fluid bg-gray-lighter">
    <div id="tree" class="people"></div>
</div>