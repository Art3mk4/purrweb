(function() { 

    //настройки работы
    var options = {
        range_time: 12,
        range_scroll: 4,
        viewed: 5,
    };

    //функция для генерации диапазона времени
    var genTimeArray = function(time){
        var time_array = [];
        time[0] = parseInt(time[0]);
        var min_hour = time[0] - options.range_time;
        var max_hour = time[0] + options.range_time;


        for(hour = min_hour; hour <= max_hour; hour++){
            current_hour = hour;
            minutes = '00';
            
            if(current_hour > 23)
                current_hour = current_hour - 24;

            if(current_hour < 10)
                current_hour = '0' + current_hour;

            if(current_hour == time[0])
                minutes = time[1];

            time_array.push(current_hour + ':' + minutes);
        }                

        return time_array;        
    }

    //функция для печати массива времени
    var printTimeArray = function(time_array, $div){
        $div.html('');
        for(key in time_array){
            if(key == options.range_time)
                time_array[key] = '<strong>' + time_array[key] + '</strong>';
            $div.append('<tr><td><a href="#">' + time_array[key] + '</a></td></tr>');
        }
    }

    //функция для определения текущего номера строки по порядку
    var getOrderTableRow = function($table){
        var order = 0;
        $table.find('tr').each(function(index){
            order++;
            if($(this).find('strong').length)
                return false;            
        });

        return order;
    }

    //функция для анимации перемещения диапазона
    var animateTimeTable = function($table, dir){
        var height = $table.find('tr').height();
        var top_position = Math.abs($table.position().top);
        //высчитываем сдвиг
        var offset = options.range_scroll * height;

        //если нет других анимаций
        if(!$table.hasClass('isAnimate')){
            if(dir == 'up'){
                //если крутить не куда, то ничего не делаем
                if(top_position == 0)
                    return true;
                //если у нас сдвиг больше позиции сверху, то мы уходим за границу
                if(top_position - offset < 0)
                    offset = top_position;

                //анимируем
                startAnimate($table, offset, dir);
                        
            } else if(dir == 'down'){
                //если крутить не куда, то ничего не делаем
                if(top_position + options.viewed * height == $table.height())
                    return true;
                //если у нас остаток для сдвига меньше самого сдвига
                var after_animate = $table.height() - (top_position + height * options.viewed);
                if(after_animate <= options.range_scroll * height)
                    offset = after_animate;
                
                //анимируем
                startAnimate($table, offset, dir);
            }
        }

        return true;
    }

    var startAnimate = function($table, offset, dir){
        //выставляем направление анимации для css
        if(dir == 'up')
            dir = '+=';
        else if(dir == 'down')
            dir = '-=';
        //делаем блокировку от повторной анимации
        $table.addClass('isAnimate');
        //выполняем анимацию
        $table.animate({
            top: dir + offset + "px",
        }, 'slow', function(){
            //снимаем блокировку
            $table.removeClass('isAnimate'); 
        });

        return true;
    }


    $(document).ready(function(){

        $('.select-time').on({
            click: function(){
                var $container = $(this).parents('.time-container');
                var $input = $container.find('input');            
                var $time = $container.find('.time');
                
                if($time.is(':hidden')){	                            
	                //берем время                        
	                var time = $input.attr('time').split(':');
	                //генерируем диапазон
	                var times = genTimeArray(time);
	                                
	                //печатаем диапазон в контейнер
	                printTimeArray(times, $time.find('table'));                
	                
	                //показываем для выбора
	                $time.css('z-index', '100').show();
	
	                //высчитываем высоту
	                $time.find('.container').css('height', function(){
	                    return options.viewed * $time.find('table tr').height();
	                });
	                
	                //вычисляем сдвиг диапазона времени чтобы текущее время было в середине
	                var height = $time.find('tr').height();
	                var order = getOrderTableRow($time.find('table'));
	                //текущее время будет в центре выпадающего списка
	                var offset = height * (order - Math.ceil(options.viewed/2));
	
	                //делаем сдвиг 
	                $time.find('table').css('top', '-' + offset + 'px');
				} else {
					$time.css('z-index', '1').hide();
				}
                return false;
            },
        });

        //выбор какого либо значения
        $('.time table tr td a').on({
            click: function(){
                //берем инпут и сохраняем в него то что выбрали
                var $container = $(this).parents('.time-container');
                var $input = $container.find('input');
                $input.val($(this).text());
                $input.focus();

                return false;
            },
        });

        //скролл
        $('.time table').on({
            mousewheel: function(e, delta){
                //тут вроде все понятно
                var $table = $(this);
                
                if(delta > 0)
                    animateTimeTable($table, 'up');
                else
                    animateTimeTable($table, 'down');

                return false;
            },
        });

        //клик в любом месте
        $('body').on({
            click: function(){
                $('.time').css('z-index', '1').hide();
            },
        });

        //кнопки вверх низ
        $('.time .up').on({
            click: function(e){
                var $table = $(this).parents('.time-container').find('table');
                            
                animateTimeTable($table, 'up');

                return false;
            },
        });
        $('.time .down').on({
            click: function(e){
                var $table = $(this).parents('.time-container').find('table');
                
                animateTimeTable($table, 'down');

                return false;
            },
        });

        //маска поля
        $('input[rel="time"]').mask("29:69");
    });
})();
