<?php
$this->start('title');
echo $this->Html->titleForLayout(__('Media'));
$this->end();

$this->start('nav');
echo $this->element('nav');
$this->end();

$this->start('jinclude');
echo $this->Html->script('scripts');
$this->end();
?>

<?php $this->start('jscript'); ?>
<script type="text/javascript">
    
    function form(comment_id)
    {
        var parent = '';
        var reply_id = '';
        if (comment_id !== undefined) {
            reply_id = 'data-reply-id = "' + comment_id + '"';
            parent = '<input name="parent_id" value="' + comment_id + '" type="hidden" />';
        }
        
        var form =  '<div class="comment-form">' +
                        '<form class="form-horizontal" ' + reply_id + '>' +
                            parent +
                            '<div class="form-group">' +
                                '<div class=col-md-12>' +
                                    '<textarea name="body" class="form-control" rows="4"></textarea>' +
                                '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<div class=col-md-12>' +
                                    '<button type="submit" class="btn btn-primary">Отправить</button>' +
                                '</div>' +
                            '</div>' +
                        '</form>' +
                    '</div>';
            
        return form;
    }
    
$(document).ready(function () {

    $('.comment-add').on('click', function (e) {
        e.preventDefault();

        $('.comment-add').css('display', 'none');
        $('.reply-comment').css('display', 'block');
        $('.reply-comment-block').html('');
        $('.comment-block').html(form());
        $('.comment-block textarea').focus();
    });
    
    $('.media-list').on('click', '.reply-comment', function(e){
        e.preventDefault();
        
        var comment_id = $(this).attr('data-reply-comment-id');
        
        $('.comment-block, .reply-comment-block').html('');
        $('.comment-add, .reply-comment').css('display', 'block');
        
        $('[data-reply-comment-id = ' + comment_id + ']').css('display', 'none');
        
        $('[data-reply-comment-block-id = ' + comment_id + ']').html(form(comment_id));
        $('[data-reply-comment-block-id = ' + comment_id + '] textarea').focus();
    });

    $('.comment-block').on('submit', '.form-horizontal', function (e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: '<?= $this->Html->url(array('controller' => 'comments', 'action' => 'add', $this->params['pass'][0], 'admin' => false)); ?>',
            data: $(this).serialize(),
            dataType: 'html',
            beforeSend: function(){
                
            },
            success: function(data) {
                $('.comment-add').css('display', 'block');
                $('.comment-block').html('');
                $('.media-list').append(data);
            }
        });
    });
    
    $('.media-list').on('submit', '.reply-comment-block .form-horizontal', function (e) {
        e.preventDefault();
        
        var parent_id = $(this).attr('data-reply-id');
        
        $.ajax({
            type: 'POST',
            url: '<?= $this->Html->url(array('controller' => 'comments', 'action' => 'add', $this->params['pass'][0], 'admin' => false)); ?>',
            data: $(this).serialize(),
            dataType: 'html',
            beforeSend: function(){
                
            },
            success: function(data) {
                $('.reply-comment').css('display', 'block');
                $('.reply-comment-block').html('');
                $('[name=comment_' + parent_id + '] .media-body:first').append(data);
            }
        });
    });
});
</script>
<?php $this->end(); ?>

<div class="viewer">
    <div class="container-fluid">
        <div class="row">
            <div class="viewer-top">
            <?php echo $this->Item->linkBAckCollection(); ?>
            </div>
        </div>
        <div class="row">
            <div class="viewer-content">
                <div class="viewer-item">
                <?php echo $this->Item->viewerImage($item); ?>
                </div>
                <?php echo $this->Item->viewerNav($itemsPrev, $itemsNext); ?>
            </div>
        </div>
        <div class="row">
            <div class="viewer-bottom"></div>
        </div>
    </div>
</div>


<div class="bg-gray-lighter">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1>Многие думают, что Lorem Ipsum</h1>
                <div class="created">Опубликовано: 14 декабря 2017</div>
            </div>
            <div class="col-md-2 hidden-xs hidden-sm">
                <div class="row statistics">
                    <div class="col-xs-6">
                        <div class="quantity">200</div>
                        <span class="title">закладок</span>
                    </div>
                    <div class="col-xs-6">
                        <div class="quantity">400,000</div>
                        <span class="title">просмотров</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row description">
            <div class="col-md-12">
                Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь. Если вам нужен Lorem Ipsum для серьёзного проекта, вы наверняка не хотите какой-нибудь шутки, скрытой в середине абзаца. Также все другие известные генераторы Lorem Ipsum используют один и тот же текст, который они просто повторяют, пока не достигнут нужный объём. Это делает предлагаемый здесь генератор единственным настоящим Lorem Ipsum генератором. Он использует словарь из более чем 200 латинских слов, а также набор моделей предложений. В результате сгенерированный Lorem Ipsum выглядит правдоподобно, не имеет повторяющихся абзацей или "невозможных" слов.
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="comment-add">Добавить комментарий</a>
                <div class="comment-block"></div>
                <ul class="media-list">
                <?php echo $this->Item->comments($comments); ?>
                </ul>
                <a href="#" class="comment-add">Добавить комментарий</a>
            </div>

        </div>
    </div>
</div>
