define(function(){
    var timeago = function(timestamp){
        var units = {
            31104000: '年',
            2592000: '月',
            86400: '天',
            3600: '小时',
            60: '分钟',
            0: '秒',
        }; 
        var seconds = Math.round(new Date().getTime() / 1000) - timestamp;
        var divisors = [60, 3600, 86400, 2592000, 31104000];
        var divisor = 0;
        for (var i in divisors) {
            if(seconds >= divisors[i])
                divisor = divisors[i];
        }
        return (divisor > 0 ? Math.round(seconds / divisor) : seconds) + ' ' + units[divisor] + '前';
    }

    return timeago;
});
