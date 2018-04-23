$(document).ready(function() {
    //$('#menu').css("height", "100%");
    $('.serviceCheckBox').click(() => {
        if($('input[class="serviceCheckBox"]:checked').length > 0) {
        var cost = 0;
        var duration =0;

        $('input[class="serviceCheckBox"]:checked').each(function() {
            var data = this.value.split(';');
            cost += Number(data[1]);
            duration += Number(data[2]);
        });

        $('#totalPriceAndDuration').text('Total price: ' + cost +'. Car repair time in hours: ' + duration+'.');
        $('#totalPriceAndDuration').show();
        }
        else{
            $('#totalPriceAndDuration').hide();
        }
    });

    $('.carChoice').click((event) => {
        $('#car_numberPlate').val($(event.target).closest('tr').find("td:nth-child(1)").text());
        $('#car_model').val($(event.target).closest('tr').find("td:nth-child(2)").text());
        $('#car_engineType').val($(event.target).closest('tr').find("td:nth-child(3)").text());
        $('#car_transmission').val($(event.target).closest('tr').find("td:nth-child(4)").text());
        $('#car_power').val($(event.target).closest('tr').find("td:nth-child(5)").text());
    });
});