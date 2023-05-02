<?php
$this->start('title');
echo $this->Html->titleForLayout(__('People'));
$this->end();

$this->start('nav');
$menu[2] = true;
echo $this->element('nav', array('menu' => $menu));
$this->end();

$this->start('css-include');
echo $this->Html->css(
    array(
        '../lib/jquery-ui-1.12.1/jquery-ui.min',
        '../lib/jquery-ui-1.12.1/jquery-ui.structure.min',
        '../lib/primitives/css/primitives.latest'
    )
);
$this->end();

$this->start('jinclude');
echo $this->Html->script(
    array(
        'jquery-ui-1.10.2.custom.min',
        '../lib/primitives-5.9.1/min/primitives.min',
        '../lib/primitives-5.9.1/min/primitives.jquery.min'
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

        var items = <?= $this->Html->people($people) ?>;
        
        var templates = [];
        templates.push(getContactTemplate());

        options.items = items;
        options.defaultTemplateName = "contactTemplate";
        options.cursorItem = '<?= $this->Session->read('Auth.User.User.person_id') ?>';
        options.linesWidth = 1;
        options.arrowsDirection = 2;
        options.templates = templates;
        options.onItemRender = onTemplateRender;
        options.hasSelectorCheckbox = primitives.common.Enabled.False;
        options.normalLevelShift = 20;
        options.dotLevelShift = 20;
        options.lineLevelShift = 20;
        options.normalItemsInterval = 10;
        options.dotItemsInterval = 10;
        options.lineItemsInterval = 10;
        options.pageFitMode = 0;
        options.navigationMode = 0;
        options.highlightGravityRadius = 40;
        options.enablePanning = true;

        $("#tree").famDiagram(options);

        $('[name="scrollPanel"]').css({overflow: "hidden"});
        
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
            var bodyWidth = $(window).width() - 30;
            var bodyHeight = $(window).height() - 60;
            $("#tree").css(
            {
                "width": bodyWidth + "px",
                "height": bodyHeight + "px"
            });
        }
        
        //$( "#tree div.placeholder" ).draggable();
        
    });
    
</script>
<?php $this->end(); ?>


<div class="container-fluid bg-gray-lighter">
    <div id="tree" class="people"></div>
</div>
