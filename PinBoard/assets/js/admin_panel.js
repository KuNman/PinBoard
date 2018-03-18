let searchJobsEnCounter = 0;
let searchJobsPlCounter = 0;
let searchJobsFrCounter = 0;
let searchCountriesEnCounter = 0;
let searchCountriesPlCounter = 0;
let searchCountriesFrCounter = 0;
let searchAreaInCountryCounter = 0;

window.addNewJobName = addNewJobName;
function addNewJobName () {
    const new_job_en = $("#new_job_en").val();
    const new_job_pl = $("#new_job_pl").val();
    const new_job_fr = $("#new_job_fr").val();
    $.ajax({
        url: "/addNewJobName",
        type: "post",
        data: { new_job_en : new_job_en, new_job_pl : new_job_pl, new_job_fr : new_job_fr },
        success: function(response) {
            console.log('ok');
        }
    })
};

window.addNewCountryName = addNewCountryName;
function addNewCountryName() {
    const new_country_en = $("#new_country_en").val();
    const new_country_pl = $("#new_country_pl").val();
    const new_country_fr = $("#new_country_fr").val();
    $.ajax({
        url: "/addNewCountryName",
        type: "post",
        data: { new_country_en : new_country_en, new_country_pl : new_country_pl, new_country_fr : new_country_fr },
        success: function(response) {
            console.log('ok');
        }
    })
};

window.addNewAreaName = addNewAreaName;
function addNewAreaName() {
    const area = $("#new_area").val();
    const country = $("#select_country option:selected").text();
    $.ajax({
        url: "/addNewAreaName",
        type: "post",
        data: { area : area, country : country },
        success: function(response) {
            console.log('ok');
        }
    })
};

window.searchJobsEn = searchJobsEn;
function searchJobsEn() {
    let jobLength = $("#new_job_en").val().length;
    if(jobLength > 1 && searchJobsEnCounter == 0) {
        searchJobsEnAjax();
    }
};

window.searchJobsPl = searchJobsPl;
function searchJobsPl() {
    let jobLength = $("#new_job_pl").val().length;
    if(jobLength > 1 && searchJobsPlCounter == 0) {
        searchJobsPlAjax();
    }
};

window.searchJobsFr = searchJobsFr;
function searchJobsFr() {
    let jobLength = $("#new_job_fr").val().length;
    if(jobLength > 1 && searchJobsFrCounter == 0) {
        searchJobsFrAjax();
    }
};

window.searchCountriesEn = searchCountriesEn;
function searchCountriesEn() {
    let countryLength = $("#new_country_en").val().length;
    if(countryLength > 1 && searchCountriesEnCounter == 0) {
        searchCountriesEnAjax();
    }
};

window.searchCountriesPl = searchCountriesPl;
function searchCountriesPl() {
    let countryLength = $("#new_country_pl").val().length;
    if(countryLength > 1 && searchCountriesPlCounter == 0) {
        searchCountriesPlAjax();
    }
};

window.searchCountriesFr = searchCountriesFr;
function searchCountriesFr() {
    let countryLength = $("#new_country_fr").val().length;
    if(countryLength > 1 && searchCountriesFrCounter == 0) {
        searchCountriesFrAjax();
    }
};

window.searchAreaInCountry = searchAreaInCountry;
function searchAreaInCountry() {
    let areaLength = $("#new_area").val().length;
    if(areaLength > 1 && searchAreaInCountryCounter == 0) {
        searchAreaInCountryAjax();
    }
};

function searchJobsEnAjax() {
    $.ajax({
        url: "/searchJobs/en",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_job_en'), {
                source: [{ list: response }]
            });
            searchJobsEnCounter += 1;
        }
    });
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

function searchJobsFrAjax() {
    $.ajax({
        url: "/searchJobs/fr",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_job_fr'), {
                source: [{ list: response }]
            });
            searchJobsFrCounter += 1;
        }
    });
}

function searchCountriesEnAjax() {
    $.ajax({
        url: "/searchCountries/en",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_country_en'), {
                source: [{ list : response }]
            });
            searchCountriesEnCounter += 1;
        }
    });
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

function searchCountriesFrAjax() {
    $.ajax({
        url: "/searchCountries/fr",
        type: "post",
        success: function(response) {
            horsey(document.getElementById('new_country_fr'), {
                source: [{ list : response }]
            });
            searchCountriesFrCounter += 1;
        }
    });
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

window.addJobEnName = addJobEnName;
function addJobEnName(name_pl, name_en) {
    $.ajax({
        url: "/addJobEnName",
        type: "post",
        data: { name_pl: name_pl, name_en: name_en},
        success: function(response) {
            console.log('ok');
        }
    });
}

window.addJobFrName = addJobFrName;
function addJobFrName(name_pl, name_fr) {
    $.ajax({
        url: "/addJobFrName",
        type: "post",
        data: { name_pl: name_pl, name_fr: name_fr },
        success: function(response) {
            console.log('ok');
        }
    });
}

window.activateTask = activateTask;
function activateTask(id, userId) {
    $.ajax({
        url: "/activateTask/"+id+'/'+userId,
        type: "post",
        data: { id: id },
        success: function(response) {
            console.log('activated');
        }
    });
}


window.deactivateTask = deactivateTask;
function deactivateTask(id, userId) {
    $.ajax({
        url: "/deactivateTask/"+id+'/'+userId,
        type: "post",
        data: { id: id },
        success: function(response) {
            console.log('deactivated');
        }
    })
}