(function ($) {
    // объект отвечает за отображение отметок на фото.
    var marks = function (element)
    {
        var data = element.data('_data');
        var marksContainer = $('.marks-container', element);
        var labelsContainer = $('.mlabels-container', element);
        var labels = $('.mlabels', labelsContainer);
        var _this = this;

        this.init = function ()
        {
            //Активируем имеющиеся теги
            for (var key in data.options.marks) {
                var mark = data.options.marks[key];
                _this.add(mark);
            }

            
            if ($(labels).html() !== '') {
                $(labelsContainer).css('display', 'block');
                
                // Активируем библиотеку tooltip
                $('[data-toggle="tooltip"]').tooltip('show');

                setTimeout(_this._hideAllMarks, 1000);
            }
            

            
            //marksContainer.hover(_this._showAllMarks, _this._hideAllMarks);
        };
        
        this.add = function (mark)
        {
            $('<div class="mark" data-mark-id="' + mark.id + '" data-toggle="tooltip" data-animation="" data-placement="bottom" title="' + _this._title(mark) + '"><div></div></div>')
                .hover(_this._showMark, _this._hideMark)
                .css({
                    top: mark.leftTopY + '%',
                    left: mark.leftTopX + '%',
                    width: (mark.rightBottomX - mark.leftTopX) + '%',
                    height: (mark.rightBottomY - mark.leftTopY) + '%'
                }).appendTo(marksContainer);
                
            _this._label(mark);
            
        };
        
        this._hideAllMarks = function()
        {
            marksContainer.find('.mark > div').hide();
            $('[data-toggle="tooltip"]').tooltip('hide');
        };
        
        this._showAllMarks = function()
        {
            marksContainer.find('.mark > div').show();
            $('[data-toggle="tooltip"]').tooltip('show');
        };
        
        this._showMark = function () {
            _this._hideAllMarks();
            marksContainer.find('.mark[data-mark-id="' + $(this).attr('data-mark-id') + '"] > div').show();
        };

        this._hideMark = function () {
            marksContainer.find('.mark[data-mark-id="' + $(this).attr('data-mark-id') + '"] > div').hide();
        };        
        
        this._label = function(mark)
        {
            var title = _this._title(mark);
            var object = title;
            if (mark.Person !== '') {
                object = '<span title="' + title + '">' + title + '</span>';
            }
       
            $('<li class="mlabel" data-mark-id="' + mark.id + '">' + object + '<i>, </i></li>')
                .appendTo(labels)
                .hover(_this._showMark, _this._hideMark);
        };
        
        this._title = function(mark)
        {
            var title;
            if (mark.Person !== '') {
                title = mark.Person.first_name + ' ' + mark.Person.last_name;
            } else if (mark.title !== '') {
                title = mark.title;
            } else {
                title = 'Имя не задано';
            }
            
            return title;
        };

        this.init();
    };

    //Методы плагина photoLabel
    var photoMarks = {

        //Инициализирует плагин
        init: function (options)
        {
            options = $.extend({
                addPostData: {}, //Произвольные данные (ключ => значение), добавленные в POST во время добавления отметки. Обычно здесь добавляют imgId.
                startHandler: '#mark-button', //Элемент, при нажатии на который произойдет запуск отметок
                onStart: function () {}, //Событие - начало отметок.
                onStop: function () {}, //Событие - завершение отметок.
                addTagUrl: "", //Адрес, который будет вызван при добавлении метки
                removeTagUrl: "", //Адрес скрипта, который будет вызван при удалении метки
                onAddTag: function () {}, //Событие - сохранение отметки
                onDeleteTag: function () {}, //Событие - удаление отметки
                isAdmin: 0, //Если 1, то возле каждой отметки появится крестик для удаления
                viewerId: -1, //Возле отметки с этим пользователем появится крестик для удаления
                tagDeletedText: 'Отметка удалена.',
                noFriendText: 'Список пуст'
            }, options);

            var $_this = this;
            
            return this.each(function () {
                
                var data = {
                    options: options,
                    width: $(this).find('img').attr('data-width'),
                    height: $(this).find('img').attr('data-height')
                    //state: 'stop'
                };
                
                $(this).data('_data', data);
                
                data.marks = new marks($_this);
                
                $(options.startHandler).click(function (e) {
                    e.preventDefault();
                    photoMarks.start.call($_this);
                });
            });
        },
        
        start: function()
        {
            var $_this = $(this);
            
            return this.each(function () {
                $('.viewer-item').css('cursor', 'crosshair');
                
                var ias = $('.viewer-item').imgAreaSelect({ 
                    instance: true,
                    onSelectEnd: function(img, selection) {
                        
                        $.getJSON('/people/getPeopleJson.json', function(data){
                            var content = $('<ul class="people-list"></ul>');

                            $.each(data, function(indx, element){
                                $('<li class="person-field" data-id="' + element.Person.id + '"></li>').append(
                                    element.Person.last_name + ' ' + element.Person.first_name
                                ).click({Person: element.Person, Mark: selection}, addUser).appendTo(content);
                            });
                            
                            $(img).popover({
                                'content': content,
                                'html': true,
                                'title': 'Выберите человека'
                            });

                            $(img).popover('show');
                            
                        });
                        
                    }
                });
                
                var addUser = function(e) {
                    var width = $_this.data('_data').width;
                    var height = $_this.data('_data').height;
                    
                    var markData = {
                        'item_id': $_this.data('_data').options.itemId,
                        'person_id': e.data.Person.id,
                        'leftTopX': e.data.Mark.x1 / width * 100,
                        'leftTopY': e.data.Mark.y1 / height * 100,
                        'rightBottomX': e.data.Mark.x2 / width * 100,
                        'rightBottomY': e.data.Mark.y2 / height * 100,
                        'confirm': '1'
                    };
                    
                    $.post('/marks/add', markData, function (response) {
                        if (response) {
                            
                        }
                    }, 'json');
                };
                
            });
        },
        
        stop: function()
        {
            
        }
    };

    $.fn.photoMarks = function (method) {
        
        if (photoMarks[method]) {
            return photoMarks[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return photoMarks.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.photoMarks');
        }
    };

})(jQuery);