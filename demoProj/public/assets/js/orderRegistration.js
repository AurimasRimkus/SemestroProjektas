$(document).ready(function() {
    /* When any service checkbox is checked, change total order's price and duration. */
    $('.serviceCheckBox').click(() => {
        $('#serviceTimeHead').empty();
        $('#car_submit').prop('disabled', true);
        if($('input[class="serviceCheckBox"]:checked').length > 0) {
            $('.form_datetime').show();
            var cost = 0;
            var duration =0;

            $('input[class="serviceCheckBox"]:checked').each(function() {
                var data = this.value.split(';');
                cost += Number(data[1]);
                duration += Number(data[2]);
            });

            /* Allows to place only 5h long order */
            $('input[class="serviceCheckBox"]:not(:checked)').each(function() {
                var time = this.value.split(';');
                if (duration + Number(time[2]) > 5){
                    this.disabled = true;
                }else{
                    this.disabled = false;
                }
            });

            $('#totalPriceAndDuration').text('Total price: ' + cost +'. Car repair time in hours: ' + duration +'.');
            $('#totalPriceAndDuration').append('<br /><br />Click to choose day and time for your service:');

            if($('.form_datetime').val() != "")
            {
                getFreeTimesForService();
            }
        }else{
            $('.serviceCheckBox').prop('disabled', false);
            $('#serviceTime').empty();
            $('.form_datetime').hide();
            $('#availableTimesError').hide();
            $('#totalPriceAndDuration').text('No services were selected.');
        }
    });

    /* When clicked on certain car from your list, its data is out into a form */
    $('.carChoice').click((event) => {
        $('#car_numberPlate').val($(event.target).closest('tr').find("td:nth-child(1)").text());
        $('#car_model').val($(event.target).closest('tr').find("td:nth-child(2)").text());
        $('#car_engineType').val($(event.target).closest('tr').find("td:nth-child(3)").text());
        $('#car_transmission').val($(event.target).closest('tr').find("td:nth-child(4)").text());
        $('#car_power').val($(event.target).closest('tr').find("td:nth-child(5)").text());
    });

    /* When we choose a date from a calendar, does a ajax request to get available service times to apply */
    $('.form_datetime').datetimepicker({
        format: 'yyyy-mm-dd',
        weekStart: 1,
        startDate: new Date((new Date()).valueOf() + 1000*3600*24),
        endDate: new Date((new Date()).valueOf() + 1000*3600*24*30),
        daysOfWeekDisabled: [0, 6],
        autoclose: true,
        minView: 2,
        maxView: 3
    });

    /* Disables registration button */
    $('.form_datetime').change(() => {
        $('#serviceTimeHead').empty();
        $('#car_submit').prop('disabled', true);
        getFreeTimesForService();
    });

    /* Disables registration button */
    $('#serviceTime').on( 'click', 'input[name=chosenTime]:radio', () => {
        $('#car_submit').prop('disabled', false);
    });

    /* Gets available times for services */
    function getFreeTimesForService(){
        $('#serviceTime').empty();
        var duration = 0;
        $('input[class="serviceCheckBox"]:checked').each(function() {
            var data = this.value.split(';');
            duration += Number(data[2]);
        });
        var date = $('.form_datetime').val();
        $.ajax({
            url: "/availableServiceTimes",
            type: "POST",
            dataType: "json",
            data: {
                "date": date,
                "duration": duration
            },
            success:function (data) {
                var times = data.times;
                if(times.length > 0){
                    $('#availableTimesError').hide();
                     var tableHeader = '<tr><th>Time</th><th>Select</th></tr>';
                     $('#serviceTimeHead').append(tableHeader);
                    for(i = 0; i < times.length; i++){
                        var time = '<tr><td>' + times[i] +
                            '</td><td><input type="radio" name="chosenTime" value="' + constructDateTime(times[i]) + '"></input></td></tr>';
                        $('#serviceTime').append(time);
                    }
                }else{
                    $('#availableTimesError').show();
                }

            }
        });
    }

    function constructDateTime(time){
        var times = time.split(" - ");
        return $('.form_datetime').val() + " " + times[0] + "/" + $('.form_datetime').val() + " " + times[1];
    }
});
