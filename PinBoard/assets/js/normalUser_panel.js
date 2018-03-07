$( document ).ready(function() {

let searchJobsPlCounter = 0;
let searchCountriesPlCounter = 0;
let searchAreaInCountryCounter = 0;

window.searchJobsPl = searchJobsPl;
function searchJobsPl() {
    let jobLength = $("#new_job_pl").val().length;
    if(jobLength > 1 && searchJobsPlCounter == 0) {
        searchJobsPlAjax();
    }
}

function searchJobsPlAjax() {
    $.ajax({
        url: "/searchJobs/pl",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_job_pl'), {
                source: [{ list: response }]
            });
            searchJobsPlCounter += 1;
        }
    });
}

window.searchCountriesPl = searchCountriesPl;
function searchCountriesPl() {
    let countryLength = $("#new_country_pl").val().length;
    if(countryLength > 1 && searchCountriesPlCounter == 0) {
        searchCountriesPlAjax();
    }
}

function searchCountriesPlAjax() {
    $.ajax({
        url: "/searchCountries/pl",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_country_pl'), {
                source: [{ list : response }]
            });
            searchCountriesPlCounter += 1;
        }
    });
}

window.searchAreaInCountry = searchAreaInCountry;
function searchAreaInCountry() {
    let areaLength = $("#new_area").val().length;
    if(areaLength > 1 && searchAreaInCountryCounter == 0) {
        searchAreaInCountryAjax();
    }
}

const searchAreaInCountryAjax = () => {
    const country = $("#select_country option:selected").text();
    $.ajax({
        url: "/searchAreaInCountry",
        type: "post",
        data: { country : country },
        success: function (response)  {
            horsey(document.getElementById('new_area'), {
                source: [{ list : response }]
            });
            searchAreaInCountryCounter += 1;
        }
    })
}

window.resetSearchAreaInCountryCounter = resetSearchAreaInCountryCounter;
function resetSearchAreaInCountryCounter() {
    return searchAreaInCountryCounter = 0;
}

window.disableChooseCities = disableChooseCities;
function disableChooseCities() {
    $(".chooseCities").addClass("inputDisabled");
}


window.disableWholeArea = disableWholeArea;
function disableWholeArea() {
    $(".wholeArea").addClass("inputDisabled");
}

window.enableChooseCities = enableChooseCities;
function enableChooseCities() {
    $(".chooseCities").removeClass("inputDisabled");
}

window.enableWholeArea = enableWholeArea;
function enableWholeArea() {
    $(".wholeArea").removeClass("inputDisabled");
}

window.chooseCity = chooseCity;
function chooseCity() {
    $(".maps").css("display", "block");
}

window.hideChooseCity = hideChooseCity;
function hideChooseCity() {
    $(".maps").css("display", "none");
}

window.nextCity = nextCity;
function nextCity() {
    $(".city:last").clone().insertAfter(".city:last");
    $(".input_city:last").val('');
    if (!$(".city:last .removeCity").length > 0) {
        $(".city:last").append('<button onclick="removeCity()" class="removeCity">Usuń</button>')
    }
}

window.removeCity = removeCity;
function removeCity() {
    $(".removeCity").parent().parent().css("background", "black");
}

window.addTask = addTask;
function addTask() {
   const job = $("#new_job_pl").val();
   const country = $("#select_country").val();
   const area = $("#new_area").val();
   let city = [];
   const date = $("#select_date").val();
    //
    // $(".input_city").each(function(index, value) {
    //     if ($(".input_city").val().length > 1) {
    //         console.log('aa');
    //     } else {
            city.push('wholeArea');
        // }

   console.log(job, country, area, city, date);

   $.ajax({
       url: "/addTask",
       type: "post",
       data : { job : job, country : country, area : area, city : city, date : date },
       success: function(response) {
           if(response == 1) {
               console.log('success');
           }
           if(response == 0) {
               console.log('error');
           }
       }
   })
}

});