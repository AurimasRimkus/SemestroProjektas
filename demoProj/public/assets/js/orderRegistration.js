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

    // $('.carChoice').click(() => {
    //     $(this).parent().siblings().each(function() {
    //         var textval = $(this).text(); // this will be the text of each <td>
    //         alert(textval);
    //         console.log("Ciklas");
    //     });
    //
    //     console.log("Ne ciklas");
    //     //closest('tr').find('td')
    //
    //     // var tableRow = $(this).closest("tr");
    //     // var numberPlate = tableRow.find("td:nth-child(2)");
    //     // console.log(numberPlate);
    //     //
    //     // $(this).closest('tr').find('td').each(function() {
    //     //     var textval = $(this).text();
    //     //     console.log(textval);
    //     // });
    //     //
    //     // // $.each($numberPlate, function() {                // Visits every single <td> element
    //     // //     console.log($(this).text());         // Prints out the text within the <td>
    //     // // });
    //     //
    //     // $('#totalPriceAndDuration').text('Veikia button ' + numberPlate);
    //     // $('#car_numberPlate').val(numberPlate);
    // });
});