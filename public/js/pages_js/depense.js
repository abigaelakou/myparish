/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 05/10/2024 - 17:39:16
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 05/10/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_depense_mensuelle();
    liste_depense_annee_encours();
    liste_toute_depenses();

    var annee = new Date().getFullYear()
    var mois = new Date().getMonth() + 1
    liste_depense_mensuelle(mois, annee)
    $("#mois").change(function() {
        var mois = $(this).val()
        var annee = $("#annee").val()
        liste_depense_mensuelle(mois, annee)
    });
    $("#annee").change(function() {
        var annee = $(this).val();
        var mois = $("#mois").val()
        liste_depense_mensuelle(mois, annee)

    });

});

function liste_depense_mensuelle(mois = null, annee = null) {
    let url = "/listeDepensesMensuelles";

    if (mois && annee) {
        url += "/" + mois + "/" + annee;
    }

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function(response) {
            table_depense_mensuelle(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des dépenses.');

        }
    });
}

function table_depense_mensuelle(response) {
    list_depenses_mens = response
    var tableau = '<table id="liste_depense_men" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Description</th>' +
        '<th>Montant</th>' +
        '<th>Date</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_depenses_mens.forEach(function(list_depenses_men) {
        tableau += '<tr>' +
            '<td>' + list_depenses_men.description + '</td>' +
            '<td>' + list_depenses_men.montant + '</td>' +
            '<td>' + date_format_fr(list_depenses_men.date_depense) + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_depense(' + list_depenses_men.id + ');" class="btn btn-success mr-3" >' +
            'Modifier' +
            '</button>' +
            '<button type="button" onclick="supprimer_depense(' + list_depenses_men.id + ');" class="btn btn-danger mr-2" title="Supprimer">' +
            'Supprimer' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_depenses_mensuelles").html(tableau);
    appel_data_table("liste_depense_men");
}

function modal_depense(i) {

    list_depenses_mens.forEach(element_modif => {
        if (Number(element_modif.id) === Number(i)) {
            $("#id_depense").val(element_modif.id);
            $("#modif_montant").val(element_modif.montant);
            $("#modif_date_depense").val(element_modif.date_depense);
            $("#modif_description").val(element_modif.description);

        }
    });
    $("#editDepenseModal").modal("show");
}


$('#editDepenseForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Depense !"
    text = "Modification de la dépense effectuée "
    send_form(form, titre, text)
    $("#editDepenseModal").modal("hide")
    setTimeout(() => {
        liste_depense_mensuelle()
        liste_depense_annee_encours()
        liste_toute_depenses()
    }, 200);
});

function supprimer_depense(id) {
    swal({
        title: 'Voulez-vous vraiment supprimer?',
        text: "Cette opération est irréversible!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Oui!',
        cancelButtonText: 'Non!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function() {
        $.ajax({
            type: "get",
            url: "/supp_depense/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "Cette dépense n'est plus prise en compte", "success");
                liste_depense_mensuelle()
                liste_depense_annee_encours()
                liste_toute_depenses()
            }
        });
    }, function(dismiss) {
        if (dismiss === 'Annuler') {
            swal(
                'Annulé',
                'Votre demande a été annulé :)',
                'error'
            )
        }
    })

}
// ******************************** LISTE DEPENSE ANNEE ENCOURS*****************************
function liste_depense_annee_encours() {
    $.ajax({
        type: "GET",
        url: "/depenses/annee-en-cours",
        dataType: "json",
        success: function(response) {
            table_depense_anne_encours(response);
        }
    });
}

function table_depense_anne_encours(response) {
    list_depense_encours = response
    var tableau = '<table id="liste_tableau" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Description</th>' +
        '<th>Montant</th>' +
        '<th>Date</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_depense_encours.forEach(function(list_depense) {
        tableau += '<tr>' +
            '<td>' + list_depense.description + '</td>' +
            '<td>' + list_depense.montant + '</td>' +
            '<td>' + date_format_fr(list_depense.date_depense) + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#listeDepensesAnneeEnCours").html(tableau);
    appel_data_table("liste_tableau");
}

// ********************************** LISTE DE TOUTES DEPENSES **************************************

function liste_toute_depenses() {
    $.ajax({
        type: "GET",
        url: "/depenses/toutes",
        dataType: "json",
        success: function(response) {
            table_toutes_depenses(response);
        }
    });
}

function table_toutes_depenses(response) {
    list_toutes_depense = response
    var tableau = '<table id="liste_depense_toutes" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Description</th>' +
        '<th>Montant</th>' +
        '<th>Date</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_toutes_depense.forEach(function(list_toutes) {
        tableau += '<tr>' +
            '<td>' + list_toutes.description + '</td>' +
            '<td>' + list_toutes.montant + '</td>' +
            '<td>' + date_format_fr(list_toutes.date_depense) + '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#listeToutesDepenses").html(tableau);
    appel_data_table("liste_depense_toutes");
}

//******************************************************************************************************************
function appel_data_table(id_tableau) {
    $('#' + id_tableau).dataTable({
        dom: 'Bfrltip',
        lengthMenu: [
            [10, 15, 20, 25, 30, -1],
            [10, 15, 20, 25, 30, "Tout"]
        ],
        retrieve: true,
        responsive: true,
        fixedHeader: true,
        colReorder: true,
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        language: {
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "sLengthMenu": "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher :",
            "sZeroRecords": "Aucun élément correspondant trouvé",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            }
        }
    });
}