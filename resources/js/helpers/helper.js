export function getMonthName(data) {
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    return  months[data.getMonth()];
}

export function plotCalendar(data) {
    var d = [];
    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    if(data.dtStart!= null && data.dtEnd!= null)
    {
        var start = new Date(data.dtStart);
        var end = new Date(data.dtEnd);
        var loop = new Date(start);
        
        while(loop <= end){
           d.push({'day_number':loop.getDate(),'event_date':(loop.getMonth()+1)+"/"+loop.getDate()+"/"+loop.getFullYear(), 'event_day':days[loop.getDay()], 'event_description':''});  
           var newDate = loop.setDate(loop.getDate() + 1);
           loop = new Date(newDate);
        }
        return  d;
    }
}

export function plotEvents(data) {
    
    var arrNew = [];
    var dayNum = new Date();

    for (var i = 0; i < data.length; i++) 
    {
        dayNum = new Date(data[i].event_date);
        arrNew.push({'day_number':dayNum.getDate(),'event_date':data[i].event_date, 'event_day':data[i].event_day, 'event_description':data[i].event_description});       
    }
    return arrNew;
    
}
