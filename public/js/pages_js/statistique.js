/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 04/10/2024 - 15:35:45
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 04/10/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    rapport_stat_general();
    rapport_stat_dons();
    rapport_stat_catechese();
    rapport_start_montant_total_annee_encours();
    liste_evenement_venir();

    var annee = new Date().getFullYear()
    var mois = new Date().getMonth() + 1
    rapport_stat_dons(mois, annee)
    $("#mois").change(function() {
        var mois = $(this).val()
        var annee = $("#annee").val()
        rapport_stat_dons(mois, annee)
    });
    $("#annee").change(function() {
        var annee = $(this).val();
        var mois = $("#mois").val()
        rapport_stat_dons(mois, annee)

    });
});

function rapport_stat_general() {
    $.ajax({
        type: "get",
        url: "/stat_glogale",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response) {
            //console.log(response);
            $("#nombre_paroissien").text(format_num(response["nombre_paroissien"]))
            $("#nombre_non_paroissien").text(format_num(response["nombre_non_paroissien"]))
            $("#nbre_mouvement").text(format_num(response["nbre_mouvement"]))
            $("#nbre_doc_archive").text(format_num(response["nbre_doc_archive"]))

        }
    });

}

function rapport_stat_dons(mois, annee) {
    $.ajax({
        type: "get",
        url: "/stat_dons/" + mois + "/" + annee,
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response) {
            // console.log(response);
            $("#nbre_total_don_recu").text(format_num(response["nbre_total_don_recu"]))
            $("#dons_recus").text(format_num(response["dons_recus"]))

            // Récupère la liste des principaux donateurs
            var liste_donateurs = response["list_principaux_donateurs"];
            rapport_stats = response
            var tableau = '<table id="liste_tableau_dons" class="display table table-striped table-bordered" style="width:100% !important">' +
                '<thead class="bg-white text-black">' +
                '<h4>Liste des principaux donateurs</h4>' +
                '<tr>' +
                '<th>Nom</th>' +
                '<th>Type Don</th>' +
                '<th>Contact</th>' +
                '<th>Date Don</th>' +
                '<th>Montant</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            liste_donateurs.forEach(function(donateur) {
                tableau += '<tr>' +
                    '<td>' + donateur.nom_prenom + '</td>' +
                    '<td>' + donateur.type_don + '</td>' +
                    '<td>' + date_format_fr(donateur.date_don) + '</td>' +
                    '<td>' + donateur.contact + '</td>' +
                    '<td>' + format_num(donateur.montant) + '</td>' +
                    '</tr>';
            });

            tableau += '</tbody></table>';
            $("#liste_dons").html(tableau);
            appel_data_table("liste_tableau_dons");
        }
    });

}


function rapport_stat_catechese() {
    $.ajax({
        type: "get",
        url: "/start_catechese",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // console.log("Réponse reçue :", response);

            // Vérification si les valeurs existent dans la réponse
            if (response["nombre_catechumene_inscris_annee_en_cours"]) {
                $("#nombre_catechumene_inscris_annee_en_cours").text(format_num(response["nombre_catechumene_inscris_annee_en_cours"]));
            }

            if (response["montant_total_genere_par_catechese_annee_encours"]) {
                $("#montant_total_genere_par_catechese_annee_encours").text(format_num(response["montant_total_genere_par_catechese_annee_encours"]) + 'F');
            }

            var nombre_catechese_par = response["nombre_catechese_par_session"];
            if (nombre_catechese_par && Array.isArray(nombre_catechese_par)) {
                // Parcours des résultats et affichage dans les éléments HTML
                nombre_catechese_par.forEach(function(session) {
                    if (session.lib_session_catechese === 'Session Enfant') {
                        $("#nombre_enfants").text(session.total);
                    } else if (session.lib_session_catechese === 'Session Jeune') {
                        $("#nombre_jeunes").text(session.total);
                    } else if (session.lib_session_catechese === 'Session Adulte') {
                        $("#nombre_adultes").text(session.total);
                    }

                });
            } else {
                console.warn("Les données de session sont incorrectes ou manquantes.");
            }
        },
        error: function(error) {
            console.error("Erreur lors de la récupération des données par session :", error);
        }
    });
}

function rapport_start_montant_total_annee_encours() {
    $.ajax({
        type: "get",
        url: "/start_montant_total_annee_encours",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response) {
            // console.log(response);
            $("#montant_total_pour_lannee").text(format_num(response["montant_total_pour_lannee"]))
            $("#montantTotalDepenseAnneEncours").text(format_num(response["montantTotalDepenseAnneEncours"]))
            $("#reste_en_caisse").text(format_num(response["reste_en_caisse"]))

        }
    });

}

function liste_evenement_venir() {
    $.ajax({
        type: "get",
        url: "liste_des_evenements_non_realises",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function(response) {
            list_evenement_a_venir = response
            var tableau = '<table id="liste_tableau_evenement" class="display table table-striped table-bordered" style="width:100% !important">' +
                '<thead class="bg-white text-black">' +
                '<h4>Liste des évènements</h4>' +
                '<tr>' +
                '<th>Lib. Evenement</th>' +
                '<th>Date Ev.</th>' +
                '<th>Description</th>' +
                '<th>Heure Evenement</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';

            list_evenement_a_venir.forEach(function(evenement) {
                tableau += '<tr>' +
                    '<td>' + evenement.lib_evenement + '</td>' +
                    '<td>' + date_format_fr(evenement.date_evement) + '</td>' +
                    '<td>' + evenement.description + '</td>' +
                    '<td>' + evenement.heure_evenement + '</td>' +
                    '</tr>';
            });

            tableau += '</tbody></table>';
            $("#liste_evenement").html(tableau);
            appel_data_table("liste_tableau_evenement");
        }
    });

}

function appel_data_table(id_tableau) {
    $('#' + id_tableau).dataTable({
        dom: 'Bfrltip',
        lengthMenu: [
            [5, 10, 15, 20, 25, 30, -1],
            [5, 10, 15, 20, 25, 30, "Tout"]
        ],
        retrieve: true,
        responsive: true,
        fixedHeader: true,
        colReorder: true,
        buttons: ['excel', 'pdf'],
        language: {
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered": "(filtré à partir de _MAX_ éléments au total)",
            "sLengthMenu": "Afficher _MENU_ éléments",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement...",
            "sSearch": "Rechercher:",
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