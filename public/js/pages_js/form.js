/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 12/05/2022 - 17:20:59
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 12/05/2022
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
/*  **********Les fonctions a appelé*************    */
// $(function() {
//     // $('select').chosen();
// });

function send_encrypt_form(form) {

    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: new FormData(form),
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            swal({
                type: 'success',
                title: titre,
                text: text,
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-primary'
            })
            $(".input-vide").val("");
            $("input").val("");
            $("select").val("");
            $("textarea").text("");
            $("textarea").val()
        },
        error: function(data) {
            swal({
                type: 'error',
                title: "Echec",
                text: 'Opération echoué!',
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-danger'
            })
        }
    });
}


function send_encrypt_form_cours(form) {

    $.ajax({
        type: $(form).attr('method'),
        url: $(form).attr('action'),
        data: new FormData(form),
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            switch (response) {
                case 2:
                case "2":

                    swal({
                        type: 'error',
                        title: "Opération échouée",
                        text: 'Le fichier du cours doit etre une vidéo ou un pdf',
                        confirmButtonText: 'Fermer',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-danger'
                    })
                    break;
                case 3:
                case "3":

                    swal({
                        type: 'error',
                        title: "Opération échouée",
                        text: 'Veuillez inserer un fichier image',
                        confirmButtonText: 'Fermer',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-danger'
                    })
                    break;

                default:
                    swal({
                        type: 'success',
                        title: titre,
                        text: text,
                        confirmButtonText: 'Fermer',
                        buttonsStyling: false,
                        confirmButtonClass: 'btn btn-lg btn-primary'
                    })
                    $(".input-vide").val("");
                    $("input").val("");
                    $("select").val("");
                    $("textarea").text("");
                    $("textarea").val();
                    $(".text-area").val("");
                    break;
            }

        },
        error: function(data) {
            swal({
                type: 'error',
                title: "Echec de l'opération",
                text: "L'opération a été un échec !",
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-danger'
            })
        }
    });
}

function send_form_perso(method, url, donnees, titre, text) {
    $.ajax({
        type: method,
        url: url,
        data: donnees,
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            swal({
                type: 'success',
                title: titre,
                text: text,
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-primary'
            })
            $(".input-vide").val("");
            $(".input-vide").val("");
            $("input").val("");
            $("select").val("");
            $("textarea").text("");
            //$("input").chosen()
            $("textarea").val()
        },
        error: function(data) {
            // console.log(data);
            swal({
                type: 'error',
                title: "Opération échouée",
                text: 'Veuillez recommencer svp!',
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-danger'
            })
        }
    });
}

function send_form(form, titre, text) {
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // console.log(response);
            /*  swal(titre,text,"success"); */
            //console.log("sucess");
            swal({
                type: 'success',
                title: titre,
                text: text,
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-primary'
            })
            $(".input-vide").val("");
            $(".input-vide").val("");
            $("input").val("");
            $("select").val("");
            $("textarea").text("");
            //$("input").chosen()
            $("textarea").val()
            $(".text-description").val("");
        },
        error: function(data) {
            swal({
                type: 'error',
                title: "Opération échouée",
                text: 'Veuillez recommencer svp!',
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-danger'
            })
        }
    });
}



function send_form2(form, titre, text, details) {

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize() + '&details_cours=' + details,
        dataType: "JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            swal({
                type: 'success',
                title: titre,
                text: text,
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-primary'
            })
            $(".input-vide").val("");
            $(".input-vide").val("");
            $("input").val("");
            $("select").val("");
            $("textearea").text("");
            // $("input").chosen();
            $("textarea").val()
        },
        error: function(data) {
            swal({
                type: 'error',
                title: "Opération échouée",
                text: text,
                confirmButtonText: 'Fermer',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-lg btn-danger'
            })
        }
    });
}




function uploadform(form, titre, text) {
    var url = $(form).attr("action");
    var ser = $(form).serialize();
    var donnee = new FormData(form);
    //console.log(donnee);
    // console.log(ser);
    $.ajax({
        type: "post",
        cache: false,
        contentType: false,
        processData: false,
        url: url,
        data: donnee,
        dataType: "json",
        success: function(response) {

            swal(titre, text, "success");
            $(".input-vide").val("");
            $(".input-vide").val("");
            $("input").val("");
            $("select").val("");
            $("textearea").text("");
            // $("input").chosen()
            $("textarea").val()
        },
        error: function(reponse) {
            swal('Dommage!', "L'enregistrement a été un échec. Reprenez SVP!", 'error')
        }
    });
}

/* *************************************** FIN DES FONCTION A APPELER ***************************************** */



function date_format_fr(date) {
    var dateTime = new Date(date)
    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
    var date_fr = dateTime.toLocaleDateString(undefined, options);
    return date_fr

}

function taskDate(dateMilli) {
    var d = (new Date(dateMilli) + '').split(' ');
    d[2] = d[2] + ',';

    return [d[0], d[1], d[2], d[3]].join(' ');
}

function convert(str) {
    var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
    return [date.getFullYear(), mnth, day].join("-");
}

function date_convert(param) {
    const date = new Date(param);
    const hoursAndMinutes = date.getHours() + ':' + date.getMinutes();
    return hoursAndMinutes;
}


function date_format_fr_old(date) {

    var dateTime = new Date(date)

    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
    var date_fr = dateTime.toLocaleDateString(undefined, options);
    return date_fr
}


function date_format_fr2(date) {
    var recup_format_date = date.split(" ")
    var recup_heure = recup_format_date[1].split(":")
    var recup_date = recup_format_date[0].split("/")

    if (recup_format_date[2] == 'PM') {
        recup_heure[0] = parseInt(recup_heure[0]) + 12
    }

    recup_date = `${recup_date[2]}-${recup_date[1]}-${recup_date[0]} ${recup_heure[0]}:${recup_heure[1]}:00`

    var dateTime = new Date(recup_date)

    const options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric' };
    var date_fr = dateTime.toLocaleDateString(undefined, options);
    return date_fr
}

//fonction qui retourne id de l'url du depart
function get_url(position) {
    var url = document.location.href
    var separateur = url.split("/")
    var id = separateur[separateur.length - position]
    id = id.replace("#", "")
    return id;
}

function format_num(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


function toCapilize(s) {
    var mot = s.split(" ")
    var chaine = ''
    for (let i = 0; i < mot.length; i++) {
        const element = mot[i];
        var new_mot = ''
        chaine += element[0].toUpperCase();
        for (let a = 1; a < element.length; a++) {
            new_mot += element[a];

        }
        chaine += new_mot + ' '

    }
    return chaine
}