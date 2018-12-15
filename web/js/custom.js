var all_section_container;
var ans_type_item = ['text','radio','checkbox'];
var answer_number = 10;
var base_url = document.getElementById('baseurl').value;
var processed_data;
var processed_eingeben_data;
var evaluiering_data = {} ;

/**
 * Function for removing last section
 */
function removeSection(){
    var total_section_number = $('.individual-section-container').length;
    if(total_section_number > 0){
        $('#individual-section-container-'+ total_section_number).remove();
        total_section_number = total_section_number - 1;
    }

    if(total_section_number < 1){
        document.getElementById("remove-last-section").style.display = "none";
        document.getElementById("submit-btn").style.display = "none";
    }
    console.log(total_section_number);
}

/**
 * Function for getting section number or question number of related with any dom element
 * @param dom
 * @param param
 */
function getSectionOrQuestionNumber(dom,param){

    var id = dom.id;
    var arr = id.split('-');

    if(param == 'sec'){
        return arr.pop();
    }else if(param == 'qn'){
        arr.pop();
        return arr.pop();
    }else{
        arr.pop();
        arr.pop();
        return arr.pop();
    }

}

function selectTypeAndGenerateAnsOptionHtml(){
    var current_section_number=  getSectionOrQuestionNumber(this,'sec');
    var qn_number =  getSectionOrQuestionNumber(this,'qn');
    var ans_number =  getSectionOrQuestionNumber(this,'ans');

    var ans_option_type = $("#ans-type-selector-"+ans_number+ "-" +qn_number+ "-" + current_section_number).val();
    var ans_number_selector = document.getElementById("ans-number-selector-"+ans_number+ "-" +qn_number+ "-" + current_section_number);
    if(ans_option_type != ''){
        ans_number_selector.disabled=false;
        ans_number_selector.value='';
    }else{
        ans_number_selector.disabled=true;
        ans_number_selector.value='';
    }
    $('#ans-option-container-'+ ans_number + '-' + qn_number + '-' + current_section_number).remove();
}

function selectNumberAndGenerateAnsOptionHtml(){
    var current_section_number=  getSectionOrQuestionNumber(this,'sec');
    var qn_number =  getSectionOrQuestionNumber(this,'qn');
    var ans_number =  getSectionOrQuestionNumber(this,'ans');

    var ans_option_type = $("#ans-type-selector-"+ans_number+ "-" +qn_number+ "-" + current_section_number).val();
    var ans_number_selector = document.getElementById("ans-number-selector-"+ans_number+ "-" +qn_number+ "-" + current_section_number);
    var ans_option_number = ans_number_selector.value;
    if(ans_option_number != '' && ans_option_type != ''){
        ans_number_selector.disabled=true;
        console.log(ans_option_number);


        var ans_option_container = document.createElement("div");
        ans_option_container.className = 'ans-option-container';
        ans_option_container.id = 'ans-option-container-'+ ans_number + '-' + qn_number + '-' + current_section_number;

        var single_ans_container = document.getElementById('single-ans-container-' + ans_number + '-'+ qn_number + '-' + current_section_number);
        single_ans_container.appendChild(ans_option_container);

        var single_ans_option_type = document.createElement("input");
        single_ans_option_type.type = "text";
        single_ans_option_type.hidden = true;
        single_ans_option_type.name = "single_ans_option_type_"+ ans_number + '_'+ qn_number + '_'+ current_section_number;
        single_ans_option_type.value = ans_option_type;
        ans_option_container.appendChild(single_ans_option_type);

        var single_ans_option_number = document.createElement("input");
        single_ans_option_number.type = "text";
        single_ans_option_number.hidden = true;
        single_ans_option_number.name = "single_ans_option_number_"+ ans_number + '_'+ qn_number + '_'+ current_section_number;
        single_ans_option_number.value = ans_option_number;
        ans_option_container.appendChild(single_ans_option_number);

        for(var i = 1; i <= ans_option_number; i++){

            var single_ans_option_container = document.createElement("div");
            single_ans_option_container.className = 'col-md-6 single-ans-option-container';
            single_ans_option_container.id = 'single-ans-option-container-'+ i + '-'+ ans_number + '-' + qn_number + '-' + current_section_number;

            var single_ans_option_value_container = document.createElement("div");
            single_ans_option_value_container.className = 'col-md-6 single-ans-option-value-container';
            single_ans_option_value_container.id = 'single-ans-option-value-container-' + qn_number + '-' + current_section_number;

            var single_ans_option_value = document.createElement("input");
            single_ans_option_value.type = ans_option_type;

            if(ans_option_type == 'radio' || ans_option_type == 'checkbox'){

                var single_ans_option_text_container = document.createElement("div");
                single_ans_option_text_container.className = 'col-md-6 single-ans-option-text-container';
                single_ans_option_text_container.id = 'single-ans-option-text-container-'+ i + '-'+ ans_number + '-' + qn_number + '-' + current_section_number;

                var single_ans_option_text = document.createElement("input");
                single_ans_option_text.type = "text";
                single_ans_option_text.name = "single_ans_option_text_"+ i +'_'+ ans_number + '_'+ qn_number + '_'+ current_section_number;
                single_ans_option_text.placeholder = 'Write Answer Text Here';
                single_ans_option_text.className = "form-control single-ans-option-text-"+ ans_number + '-'+ qn_number + '-'+ current_section_number;
                single_ans_option_text.id = "single-ans-option-text-" + i +'-'+ ans_number + '-'+ qn_number + '-'+ current_section_number;
                single_ans_option_text.required = true;

                single_ans_option_text_container.appendChild(single_ans_option_text);
                single_ans_option_container.appendChild(single_ans_option_text_container);

                if(ans_option_type == 'radio'){

                    var single_ans_option_value_name = "single_ans_option_value_"+ ans_number + '_' + qn_number + '_'+ current_section_number;

                }else if(ans_option_type == 'checkbox'){

                    var single_ans_option_value_name = "single_ans_option_value_"+ i +'_'+ans_number + '_' + qn_number + '_'+ current_section_number;

                }

            }else{ /*for text box type*/
                var single_ans_option_value_name = "single_ans_option_value_"+ i +'_'+ans_number + '_' + qn_number + '_'+ current_section_number;
                single_ans_option_value.pattern="[0-9]{1,}-[0-9]{1,}";
                single_ans_option_value.placeholder="e.g.'100-200'";
                single_ans_option_value.required = true;
            }

            single_ans_option_value.name = single_ans_option_value_name;
            single_ans_option_value.className = "form-control single-ans-option-value-"+ans_number + '-' + qn_number + '-'+ current_section_number;
            single_ans_option_value.id = "single-ans-option-value-"+ i +'-'+ans_number + '-' + qn_number + '-'+ current_section_number;


            single_ans_option_value_container.appendChild(single_ans_option_value);
            single_ans_option_container.appendChild(single_ans_option_value_container);

            ans_option_container.appendChild(single_ans_option_container);
        }
    }
}

/**
 * Function for generating ans option type and ans number selector for individual answer
 * @param ans_number
 * @param qn_number
 * @param current_section_number
 * @returns {Element}
 */
function createSelectorForAnsTypeAndNumber(ans_number,qn_number,current_section_number){

    // container div for keeping ans type and ans number selector
    var ans_type_number_container = document.createElement("div");
    ans_type_number_container.className = 'col-md-4 ans-type-number-container';

    // container div for keeping ans type selector
    var ans_type_container = document.createElement("div");
    ans_type_container.className = 'col-md-6 ans-type-container';

    // answer type selector label
    var ans_type_selector_label = document.createElement("label");
    ans_type_selector_label.textContent = "Type";
    ans_type_container.appendChild(ans_type_selector_label);

    // answer type selector
    var ans_type_selector = document.createElement("select");
    ans_type_selector.id = "ans-type-selector-"+ ans_number+ "-"+qn_number+"-" + current_section_number;
    ans_type_selector.className = "form-control ans-type-selector";
    ans_type_selector.required = true;
    ans_type_selector.onchange = selectTypeAndGenerateAnsOptionHtml;
    ans_type_selector.options[0] = new Option('- - -', '');
    for(var i = 1; i <= ans_type_item.length ;i++){
        ans_type_selector.options[i] = new Option(ans_type_item[i-1], ans_type_item[i-1]);
    }

    ans_type_container.appendChild(ans_type_selector);
    ans_type_number_container.appendChild(ans_type_container);

    // container div for keeping ans number selector
    var ans_number_container = document.createElement("div");
    ans_number_container.className = 'col-md-6 ans-number-container';

    // answer number selector label
    var ans_number_selector_label = document.createElement("label");
    ans_number_selector_label.textContent = "Number";
    ans_number_container.appendChild(ans_number_selector_label);

    // answer number selector
    var ans_number_selector = document.createElement("select");
    ans_number_selector.id = "ans-number-selector-"+ ans_number+ "-"+qn_number+"-" + current_section_number;
    ans_number_selector.className = "form-control ans-number-selector";
    ans_number_selector.required = true;
    ans_number_selector.disabled = true;
    ans_number_selector.onchange = selectNumberAndGenerateAnsOptionHtml;
    ans_number_selector.options[0] = new Option('- - -', '');
    for(var j = 1; j <= answer_number ;j++){
        ans_number_selector.options[j] = new Option(j, j);
    }

    ans_number_container.appendChild(ans_number_selector);
    ans_type_number_container.appendChild(ans_number_container);

    return ans_type_number_container;

}

/**
 * Function for generating individual answer portion for in each individual question
 */
function generateIndividualAnsHtml(){

    var current_section_number=  getSectionOrQuestionNumber(this,'sec');
    var qn_number =  getSectionOrQuestionNumber(this,'qn');

    var existing_ans_count = $('.single-ans-'+ qn_number + '-'+current_section_number).length;

    // new answer number will be 1 plus with existing answer count
    var ans_number = existing_ans_count + 1;

    /**
     * individual answer container div start
     * */
    var single_ans_container = document.createElement("div");
    single_ans_container.className = 'col-md-12 single-ans-container';
    single_ans_container.id = 'single-ans-container-' + ans_number + '-'+ qn_number + '-' + current_section_number;

    // only answer container div
    var single_ans_inner_container = document.createElement("div");
    single_ans_inner_container.className = 'col-md-8 single-ans-inner-container';

    // individual answer label
    var single_ans_label = document.createElement("label");
    single_ans_label.textContent = "Answer Number " + ans_number;
    single_ans_inner_container.appendChild(single_ans_label);

    // individual answer input
    var single_ans = document.createElement("input");
    single_ans.type = "text";
    single_ans.name = "single_ans_"+ ans_number +'_'+ qn_number + '_'+ current_section_number;
    single_ans.placeholder = 'Write Answer Text Here';
    single_ans.className = "form-control single-ans-"+ qn_number + '-'+current_section_number;
    single_ans.id = "single-ans-" + ans_number +'-'+ qn_number + '-'+ current_section_number;
    single_ans.required = true;

    single_ans_inner_container.appendChild(single_ans);
    single_ans_container.appendChild(single_ans_inner_container);

    // creating html for answer option type and ans option number selector
    var ans_type_number_container = createSelectorForAnsTypeAndNumber(ans_number,qn_number,current_section_number);
    single_ans_container.appendChild(ans_type_number_container);
    /**
     * individual answer container div end
     * */

    // appending individual answer container div into all answer container of an individual question
    var ans_container = document.getElementById('ans-container-' + qn_number + '-' + current_section_number);
    ans_container.appendChild(single_ans_container);

    // appending all ans container div into an individual question container div
    var single_qn_container = document.getElementById('single-qn-container-' + qn_number + '-' + current_section_number);
    single_qn_container.appendChild(ans_container);

}

/**
 * Function for generating individual question in each section
 * */
function generateIndividualQnHtml(){

    var current_section_number = getSectionOrQuestionNumber(this,'sec');
    var existing_qn_count = $('.single-qn-'+current_section_number).length;

    // new question number will be 1 plus with existing question count
    var qn_number = existing_qn_count + 1;

    /**
     * individual question container div start
     * */
    var single_qn_container = document.createElement("div");
    single_qn_container.className = 'col-md-12 single-qn-container';
    single_qn_container.id = 'single-qn-container-' + qn_number + '-' + current_section_number;

    // only question container div
    var single_qn_inner_container = document.createElement("div");
    single_qn_inner_container.className = 'single-qn-inner-container';

    // question label
    var single_qn_label = document.createElement("label");
    single_qn_label.textContent = "Question number "+ qn_number;
    single_qn_inner_container.appendChild(single_qn_label);

    // question input
    var single_qn = document.createElement("input");
    single_qn.type = "text";
    single_qn.name = "single_qn_"+ qn_number + '_'+ current_section_number;
    single_qn.placeholder = 'Write Question';
    single_qn.className = "form-control single-qn-"+current_section_number;
    single_qn.id = "single-qn-"+ qn_number + '-'+ current_section_number;
    single_qn.required = true;
    single_qn_inner_container.appendChild(single_qn);
    single_qn_container.appendChild(single_qn_inner_container);

    // answer container viv for each individual question
    var ans_container = document.createElement("div");
    ans_container.className = 'ans-container';
    ans_container.id = 'ans-container-' + qn_number + '-' + current_section_number;

    // generate answer button
    var single_ans_generator_button = document.createElement("div");
    single_ans_generator_button.className = 'btn btn-info single-ans-generator-button';
    single_ans_generator_button.id = 'single-ans-generator-button-'+ qn_number + '-' + current_section_number;
    single_ans_generator_button.textContent = 'Generate Answer';
    single_ans_generator_button.onclick = generateIndividualAnsHtml;
    ans_container.appendChild(single_ans_generator_button);
    single_qn_container.appendChild(ans_container);
    /**
     * individual question container div end
     * */

    // appending individual question container into all question container of a section
    var questions_container = document.getElementById('questions-container-'+ current_section_number);
    questions_container.appendChild(single_qn_container);
}


/**
 * Function for adding a new section
 * */
function addSection(){

    var all_section_container = document.getElementById("all-section-container");
    var existing_section_count = $('.individual-section-container').length;

    // current section number is 1 plus with existing section count
    var current_section_number = existing_section_count + 1;

    // individual section container div
    var individual_section_container = document.createElement('div');
    individual_section_container.className = 'form-group individual-section-container';
    individual_section_container.id = 'individual-section-container-'+ current_section_number;

    // section number text
    var section_number_text = document.createElement("h3");
    section_number_text.textContent = "Section Number " + current_section_number;
    individual_section_container.appendChild(section_number_text);

    /**
     * Section title container div start
     * */
    var section_title_container = document.createElement("div");
    section_title_container.className = 'section-title-container';

    // section title label
    var section_title_label = document.createElement("label");
    section_title_label.textContent = "Title";
    section_title_container.appendChild(section_title_label);

    // section title input
    var section_title = document.createElement("input");
    section_title.type = "text";
    section_title.name = "section_title_" + current_section_number;
    section_title.placeholder = 'Write Section Title';
    section_title.className = "form-control section-title";
    section_title.id = 'section-title-'+ current_section_number;
    section_title.required = true;
    section_title_container.appendChild(section_title);

    individual_section_container.appendChild(section_title_container);
    /**
     * Section title container div end
     * */


    /**
     * Section description container div start
     * */
    /*var section_description_container = document.createElement("div");
    section_description_container.className = 'section-description-container';

    // description title label
    var section_description_label = document.createElement("label");
    section_description_label.textContent = "Description";
    section_description_container.appendChild(section_description_label);

    // description title input
    var section_description = document.createElement("input");
    section_description.type = "text";
    section_description.name = "section_description_" + current_section_number;
    section_description.placeholder = 'Write Short Description';
    section_description.className = "form-control section-description";
    section_description.id = 'section-description-'+ current_section_number;
    section_description.required = true;
    section_description_container.appendChild(section_description);

    individual_section_container.appendChild(section_description_container);*/
    /**
     * Section description container div end
     * */


    /**
     * all questions container div start
     * */
    var questions_container = document.createElement("div");
    questions_container.className = 'questions-container';
    questions_container.id = 'questions-container-'+ current_section_number;

    // new question generating button
    var single_qn_generator_button = document.createElement("div");
    single_qn_generator_button.className = 'btn btn-info single-qn-generator-button';
    single_qn_generator_button.id = 'single-qn-generator-button-'+ current_section_number;
    single_qn_generator_button.textContent = 'Generate Question';
    single_qn_generator_button.onclick = generateIndividualQnHtml;
    questions_container.appendChild(single_qn_generator_button);

    individual_section_container.appendChild(questions_container);
    /**
     * all questions container div end
     * */

    // individual section container is appended into all section container
    all_section_container.appendChild(individual_section_container);

    // these two button will be showed when atleast one section will be generated
    document.getElementById("remove-last-section").style.display = "block";
    document.getElementById("submit-btn").style.display = "block";

}

/**
 * Function for preparing option data
 * @param form_data
 * @param section_number
 * @param temp_data
 * @param qn_number
 * @param ans_number
 * @param option_count
 * @param option_type
 * @returns {Array}
 */
function prepareOptionData(form_data,section_number,temp_data,qn_number,ans_number,option_count,option_type){
    var option_all_data = {};
    for(var i = 0; i < option_count; i++){
        var option_data = {};
        var option_number = i + 1;
        option_data['option_number'] = option_number;
        var txt_key = 'single_ans_option_text_'+ option_number + '_' + ans_number +'_'+ qn_number + '_'+ section_number;
        var val_key = 'single_ans_option_value_'+ option_number + '_' + ans_number +'_'+ qn_number + '_'+ section_number;
        if(option_type != 'text' ){
            option_data[txt_key] = temp_data[txt_key];
            var state = 'off';
            if(option_type == 'radio'){
                var radio_on_index = form_data.indexOf('single_ans_option_value_'+ ans_number +'_'+ qn_number + '_'+ section_number + '=on');
                var right_option_index = radio_on_index - 1;
                var rigth_option_text = form_data[right_option_index];
                rigth_option_text = rigth_option_text.split('=');
                if(txt_key == rigth_option_text[0]){
                    option_data['rigth_option_text_key'] = rigth_option_text[0];
                    state = 'on';
                }
            }else{
                 if(temp_data[val_key] == 'on')state='on';
            }
            option_data[val_key] = state;
        }else{
            option_data[val_key] = temp_data[val_key];
        }

        option_all_data[i] = option_data;
    }
    return option_all_data;
}

/**
 * Function for preparing answer data
 * @param form_data
 * @param section_number
 * @param temp_data
 * @param qn_number
 * @param ans_count
 * @returns {Array}
 */
function prepareAnsData(form_data,section_number,temp_data,qn_number,ans_count){
    var ans_all_data = {};
    for(var i = 0; i < ans_count; i++){
        var ans_data = {};
        var ans_number = i + 1;
        ans_data['ans_number'] = ans_number;
        ans_data['single_ans_'+ ans_number +'_'+ qn_number + '_'+ section_number] = temp_data['single_ans_'+ ans_number +'_'+ qn_number + '_'+ section_number];
        var option_count = $('.single-ans-option-value-'+ ans_number + '-' + qn_number + '-'+section_number).length;
        ans_data['option_count'] = option_count;
        if(option_count > 0){
            var option_type = temp_data['single_ans_option_type_'+ ans_number +'_'+ qn_number + '_'+ section_number];
            ans_data['option_type'] = option_type;
            ans_data['option'] = prepareOptionData(form_data,section_number,temp_data,qn_number,ans_number,option_count,option_type);
        }

        ans_all_data[i] = ans_data;
    }
    return ans_all_data;

}

/**
 * Function for preparing question data
 * @param form_data
 * @param section_number
 * @param temp_data
 * @param qn_count
 * @returns {Array}
 */
function prepareQnData(form_data,section_number,temp_data,qn_count){
    var qn_all_data = {};
    for(var i = 0; i < qn_count; i++){
        var qn_data = {};
        var qn_number = i + 1;
        qn_data['qn_number'] = qn_number;
        qn_data['single_qn_' + qn_number + '_'+section_number] = temp_data['single_qn_' + qn_number + '_'+section_number];

        var ans_count = $('.single-ans-'+ qn_number + '-'+section_number).length;
        qn_data['ans_count'] = ans_count;

        if(ans_count > 0){
            qn_data['ans'] = prepareAnsData(form_data,section_number,temp_data,qn_number,ans_count);
        }

        qn_all_data[i] = qn_data;
    }
    return qn_all_data;
}

/**
 * Function for preparing section data
 * @param form_data
 * @param total_section_number
 * @param temp_data
 * @returns {Array}
 */
function prepareSectionData(form_data,total_section_number,temp_data){

    var section_all_data = {};
    for(var i = 0; i < total_section_number; i++){
        var section_data = {};
        var section_number = i+1;
        section_data['section_number'] = section_number;
        section_data['section_title_'+section_number] = temp_data['section_title_'+section_number];
        //section_data['section_description_'+section_number] = temp_data['section_description_'+section_number];

        var qn_count = $('.single-qn-'+section_number).length;
        section_data['qn_count'] = qn_count;
        if(qn_count > 0){
            section_data['qn'] = prepareQnData(form_data,section_number,temp_data,qn_count);
        }

        section_all_data[i] = section_data;
    }

    return section_all_data;
}


function toObject(arr) {
    var rv = {};
    for (var i = 0; i < arr.length; ++i)
        rv[i] = arr[i];
    return rv;
}

/**
 * Function for collecting all form input data
 * @param data
 */
function getData(data){
    var total_section_number = $('.individual-section-container').length;
    var minimum_option_count = $('.single-ans-option-value-'+ 1 + '-' + 1 + '-'+1).length;
    if(total_section_number > 0 && minimum_option_count >= 0){
        //var form_data = $(data).serialize();
        var form_data_serialize_array = $(data).serializeArray();
        var form_data = [];
        for(var i = 0; i < form_data_serialize_array.length; i++){  // preparing all for data in a array for farther use
            form_data[i] = form_data_serialize_array[i]['name']+'='+form_data_serialize_array[i]['value'];
        }
        console.log(form_data);
        var temp_data = [];
        for(var k = 0; k < form_data.length; k++){  // preparing all for data in a array for farther use
            var temp_val= form_data[k];
            temp_val = temp_val.split('=');
            temp_data[temp_val[0]] = temp_val[1];
        }
        console.log(temp_data);
        console.log(temp_data['additional_description']);

        var all_data = {};
        all_data['round'] = temp_data['round'];
        all_data['additional_description'] = temp_data['additional_description'];
        all_data['section_count'] = total_section_number;
        all_data['section'] = prepareSectionData(form_data,total_section_number,temp_data);

        console.log('all data:');
        console.log(all_data);
        $('#preview-popup-body').empty();
        processed_data = all_data;
        $.ajax({
            url: base_url+"/site/preview",
            type: "post",
            dataType: 'html',
            data: {all_data:all_data},
            success: function(response){
                console.log(response);
                $('#preview-popup-body').html(response);
                $('#preview-button').trigger('click');

            },
            error: function(){
                console.log('error');
            }
        });
    }else{
        alert('Insufficient data. Complete data entry till option level')
    }
}

function saveData(){

    if(processed_data){
        $.ajax({
            url: base_url+"/site/storedata",
            type: "post",
            //dataType: 'json',
            data: {processed_data:processed_data},
            success: function(response){
                console.log(response);
                if(response == true){
                    alert('Question saved successfully');
                    window.location.href = base_url+"/questionset/index";
                }
            },
            error: function(){
                console.log('error');
            }
        });
    }
}

function checkQn(data){
    var round = data.value;
    console.log(round);
    $.ajax({
        url: base_url+"/site/checkqnexists",
        type: "post",
        //dataType: 'json',
        data: {round:round},
        success: function(response){
            console.log(response);
            if(response == true){
                alert('There already exists a questionset for round '+ round);
                data.value = '';
            }
        },
        error: function(){
            console.log('error');
        }
    });
}

function prviewEingeben(data){

    var form_data_serialize_array = $(data).serializeArray();
    console.log(form_data_serialize_array);
    var form_data = [];

    $.each( form_data_serialize_array, function( key, value ) {
        var name_str = value['name'];
        if(name_str.indexOf('single_ans_option_value_radio_') == -1){
            form_data.push(value['name']+'='+value['value']);
        }
    });

    var radio_list = $("input[type='radio']:checked", "#section-set-form");
    $.each( radio_list, function( key, value ) {
        var radio_type_id = value.id;
        var radio_type_value = value.value;
        var arr = radio_type_id.split('-');
        var radio_on_option = 'single_ans_option_value_'+ arr[1] + '=' + radio_type_value;
        form_data.push(radio_on_option);
    });

    console.log(form_data);
    var eingeben_data = {};
    $.each( form_data, function( key, value ) {
        var temp_val= value;
        temp_val = temp_val.split('=');
        eingeben_data[temp_val[0]] = temp_val[1];
    });

    console.log(eingeben_data);

    $('#eingeben-preview-popup-body').empty();
    processed_eingeben_data = eingeben_data;
    $.ajax({
        url: base_url+"/eingeben/previeweingeben",
        type: "post",
        dataType: 'html',
        data: {eingeben_data:eingeben_data},
        success: function(response){
            console.log(response);
            $('#eingeben-preview-popup-body').html(response);
            $('#eingeben-preview-button').trigger('click');
        },
        error: function(){
            console.log('error');
        }
    });
}

function saveEingebenData() {
    if(processed_eingeben_data){
        //console.log(processed_eingeben_data);
        $.ajax({
            url: base_url+"/eingeben/storeeingebendata",
            type: "post",
            dataType: 'html',
            data: {processed_eingeben_data:processed_eingeben_data},
            success: function(response){
                console.log(response);
                if(response == true){
                    //alert('Eingeben saved successfully');
                    window.location.href = base_url+"/site/spieler";
                }
            },
            error: function(){
                console.log('error');
            }
        });
    }
}

$(document).ready(function(){
    $('#tab-1').addClass('active-tab');
    $('#testfrage-1').addClass('active-testfrage');
    $('#evaluierung-1').addClass('active-evaluierung');
    $('.evaluierung-input :input[type=text]').prop('required',true);
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