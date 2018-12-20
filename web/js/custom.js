var base_url = document.getElementById('baseurl').value;
var evaluiering_data = {} ;
var correct_email_domain = 'uni-goettingen.de';

function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
    return rv;
}

$(document).ready(function(){
    $('#tab-1').addClass('active-tab');
    $('#testfrage-1').addClass('active-testfrage');
    $('#evaluierung-1').addClass('active-evaluierung');
    $('.evaluierung-input :input[type=text]').prop('required',true);

    //validating email adress of benutzer form
    $('#benutzer-email').on('blur',function (e) {
        var email_str = e.target.value;
        if(!email_str == ''){
            var email_str_arr = email_str.split("@");
            var email_domain = email_str_arr[1];
            if(!email_domain || email_domain.indexOf(correct_email_domain) === -1) {
                e.target.value = email_str_arr[0];
                alert('Bitte verwenden Sie eine Göttinger E-Mail-Adresse');
            }
        }
    })
});

/**
 * fuction for testfarge tracing for round 1
 * @param round
 */
function testfragecompletion(round){
    $.ajax({
        url: base_url+"/ajax/testfragecompletion",
        type: "post",
        data: {round:round},
        success: function(response){
            console.log(response);
            if(response == true){
                console.log('round saved successfully');
                window.location.href = base_url+"/eingabe/create?round="+round;
            }
        },
        error: function(){
            console.log('error');
        }
    });
}

/**
 * method for checking testFrage input
 * @param data
 * @param level
 * @param test_val
 */
function testFrageInput(data,level,test_val){
    var form_data_serialize_array = $(data).serializeArray();
    console.log(form_data_serialize_array);

    if(level == 4 ) { //for test frage 4 the test process will end for round 1
        var wert_Mais, wert_HHS, wert_Fleisch;
        wert_Mais = form_data_serialize_array[0].value;
        wert_HHS = form_data_serialize_array[1].value;
        wert_Fleisch = form_data_serialize_array[2].value;
        wert_Fleisch = wert_Fleisch.replace(",", ".");

        console.log(test_val.source);
        var preis = test_val.source.split("_");
        var round = 1;
        if((wert_Mais == preis[0]) && (wert_HHS == preis[1]) && (wert_Fleisch == preis[2])) {
            testfragecompletion(round);
        }else{
            alert("Ihre Angabe ist leider nicht korrekt. Bitte beantworten Sie die Frage(n) noch einmal. Vielen Dank!");
        }
    }else{
        if(form_data_serialize_array[0].value == test_val){
            console.log(test_val);
            var next_tab_id = '#tab-' + (level+1);
            $(next_tab_id).addClass('active-tab');
            var current_testfrage_id = '#testfrage-' + level;
            var next_testfrage_id = '#testfrage-' + (level+1);
            $(current_testfrage_id).removeClass('active-testfrage');
            $(next_testfrage_id).addClass('active-testfrage');
        }else{
            alert("Ihre Angabe ist leider nicht korrekt. Bitte beantworten Sie die Frage noch einmal. Vielen Dank!");
        }
    }
}


/**
 * method for validate input
 * @param level
 * @param fields
 * @returns {boolean}
 */
function validateInput(level,fields){
    var is_valid = true;
    $.each( fields, function( key, value ) {

        if(value == 'radio'){
            var field = $("input:radio[name="+key+"]");
        }else{
            var field = $("input:checkbox[name="+"'"+key+"[]'"+"]");
        }

        if(!field.is(":checked")){
            is_valid = false;
            console.log(key + ' missing');
            field.focus();
            return false;
        }
    });
    return is_valid;
}

/**
 * function for storing evaluering data
 * @param data
 * @param level
 * @returns {boolean}
 */
function evaluierungInput(data,level){

    if(level == 1){
        var evaluierung_fields = {f2:'radio',f3:'radio',f4:'checkbox',f6:'checkbox'};
    }else if(level == 2){
         evaluierung_fields = {f8:'radio',f9:'radio',f10:'radio'};
    }else if(level == 3){
         evaluierung_fields = {XY1:'radio',XY2:'radio',XY3:'radio',XY4:'radio',XY5:'radio',XY6:'radio',XY7:'radio',XY8:'radio',XY9:'radio',XY10:'radio'};
    }else{ // for level 4
         evaluierung_fields = {f12:'radio',f13:'radio'};
    }

    if(!validateInput(level,evaluierung_fields)){
        alert('Bitte beantworten Sie alle Fragen dieser Seite. Vielen Dank!');
        return false;
    }

    var form_data_serialize_array = $(data).serializeArray();
    evaluiering_data[level] = form_data_serialize_array;
    console.log(evaluiering_data);

    if(level == 4){ // end level of Planspielevaluierung test
        var round = 8;
        console.log();
        $.ajax({
            url: base_url+"/ajax/storeeval",
            type: "post",
            dataType: 'json',
            data: {round:round, evaluiering_data:evaluiering_data},
            success: function(response){
                console.log(response);
                if(response == true){
                    console.log('round saved successfully');
                    window.location.href = base_url+"/eingabe/create?round="+round;
                }
            },
            error: function(){
                console.log('error');
            }
        });
    }

    var next_tab_id = '#tab-' + (level+1);
    $(next_tab_id).addClass('active-tab');
    var current_testfrage_id = '#evaluierung-' + level;
    var next_testfrage_id = '#evaluierung-' + (level+1);
    $(current_testfrage_id).removeClass('active-evaluierung');
    $(next_testfrage_id).addClass('active-evaluierung');
}

/**
 * function for loading individual user result
 * @param data
 * @returns {boolean}
 */
function loadResult(data){
    var field = $("input:radio[name='result_type']");
    if(!field.is(":checked")){
        console.log('Result type missing');
        field.focus();
        return false;
    }

    var form_data_serialize_array = $(data).serializeArray();
    console.log(form_data_serialize_array);

    $.ajax({
        url: base_url+"/ajax/loadresult",
        type: "post",
        dataType: 'html',
        data: {round:form_data_serialize_array[0]['value'],name:form_data_serialize_array[1]['value'],type:form_data_serialize_array[2]['value']},
        success: function(response){
            console.log(response);
            $('#result-container').html(response);
            if(response == ''){
                alert('No eingabe or result not calculated');
            }

        },
        error: function(){
            console.log('error');
        }
    });
}