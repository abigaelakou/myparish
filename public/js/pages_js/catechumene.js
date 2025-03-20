/**
 * @description      : 
 * @author           : AbigaelHOMENYA
 * @group            : 
 * @created          : 11/09/2024 - 11:37:58
 * 
 * MODIFICATION LOG
 * - Version         : 1.0.0
 * - Date            : 11/09/2024
 * - Author          : AbigaelHOMENYA
 * - Modification    : 
 **/
$(document).ready(function() {
    liste_des_catechumene();
    liste_des_catechumene_inscrits_attente();
    liste_catechumenes_avec_decisions();
    // console.log($('#form-container').length);
    liste_catechumenes_fini();
    liste_des_catechumene_inscrits();
    liste_classes_catechese();

});

function liste_des_catechumene() {
    $.ajax({
        type: "GET",
        url: "/liste_catechumene",
        dataType: "json",
        success: function(response) {
            table_catechumene(response);
        }
    });
}


function table_catechumene(response) {
    list_catechumene = response
    var tableau = '<table id="liste_cat_tab" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Contact</th>' +
        '<th>Email</th>' +
        '<th>Nom & Prenom(s) Père</th>' +
        '<th>Contact Père</th>' +
        '<th>Nom & Prenom(s) Mère</th>' +
        '<th>Contact Mère</th>' +
        '<th>Nom & Prenom(s) Parain/Maraine</th>' +
        '<th>Contact Parain/Maraine</th>' +
        '<th>Sacrements reçus</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_catechumene.forEach(function(list_cat) {
        tableau += '<tr>' +
            '<td>' + list_cat.name + '</td>' +
            '<td>' + list_cat.contact + '</td>' +
            '<td>' + list_cat.email + '</td>' +
            '<td>' + list_cat.nom_prenom_pere + '</td>' +
            '<td>' + list_cat.contact_pere + '</td>' +
            '<td>' + list_cat.nom_prenom_mere + '</td>' +
            '<td>' + list_cat.contact_mere + '</td>' +
            '<td>' + list_cat.nom_prenom_parain + '</td>' +
            '<td>' + list_cat.contact_parain + '</td>' +
            '<td>' + list_cat.sacrement_recu + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_modif_catechumene(' + list_cat.id + ');" class="btn btn-success mr-1" title="Modifier">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '<button type="button" onclick="supprimer_catechumene(' + list_cat.id + ');" class="btn btn-danger mr-1" title="Supprimer">' +
            '<i class="icon-pencil-alt2"></i>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_des_catechumenes").html(tableau);
    appel_data_table("liste_cat_tab");
}


function modal_modif_catechumene(i) {
    list_catechumene.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_catechumene").val(element_modif.id)
            $("#modif_name").val(element_modif.name)
            $("#modif_email").val(element_modif.email)
            $("#modif_contact").val(element_modif.contact)
            $("#modif_nom_prenom_pere").val(element_modif.nom_prenom_pere)
            $("#modif_contact_pere").val(element_modif.contact_pere)
            $("#modif_nom_prenom_mere").val(element_modif.nom_prenom_mere)
            $("#modif_contact_mere").val(element_modif.contact_mere)
            $("#modif_nom_prenom_parain").val(element_modif.nom_prenom_parain)
            $("#modif_contact_parain").val(element_modif.contact_parain)

            // Gérer la sélection multiple pour les sacrements reçus
            var sacrements = JSON.parse(element_modif.sacrement_recu); // Si c'est stocké sous forme JSON
            $("#modif_sacrement_recu").val(sacrements).trigger('change');
        }
    });
    $("#editCatechumeneModal").modal("show")
}


$('#editCatechumeneForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Info Catechumène !"
    text = "Modification des informations  effectuée "
    send_form(form, titre, text)
    $("#editCatechumeneModal").modal("hide")
    setTimeout(() => {
        liste_des_catechumene()
    }, 200);
});

function supprimer_catechumene(id) {
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
            url: "/supp_catechumene/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "Ce catechumène ne fait plus de votre base!", "success");
                liste_des_catechumene()
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
/////////////**************************************************************************************************///////////
function liste_des_catechumene_inscrits_attente() {
    $.ajax({
        type: "GET",
        url: "/listeInscritsAttente",
        dataType: "json",
        success: function(response) {
            table_catechumene_inscrits_attente(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des catéchumènes en attente.');
        }
    });
}

function table_catechumene_inscrits_attente(response) {
    list_catechumene_attente = response
    var tableau = '<table id="liste_cat_attente" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Année catéchetique</th>' +
        '<th>Date Inscription</th>' +
        // '<th>Niveau Catéchetique</th>' +
        // '<th>Session</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_catechumene_attente.forEach(function(list_cat_att) {
        const id_inscription = list_cat_att.paiements.length > 0 ? list_cat_att.paiements[0].id_inscription : null; // Vérifier si paiements existe
        if (id_inscription) {
            tableau += '<tr>' +
                '<td>' + list_cat_att.catechumene.name + '</td>' +
                '<td>' + list_cat_att.annee_catechetique + '</td>' +
                '<td>' + date_format_fr(list_cat_att.date_inscription) + '</td>' +
                // '<td>' + list_cat_att.lib_niveau + '</td>' +
                // '<td>' + list_cat_att.lib_session_catechese + '</td>' +
                '<td>' +
                '<button type="button" onclick="completerPaiement(' + id_inscription + ');" class="btn btn-primary">' +
                'Achever paiement' +
                '</button>' +
                '</button>' +
                '</td>' +
                '</tr>';
        }
    });

    tableau += '</tbody></table>';
    $("#catechumene_inscris_attente").html(tableau);
    appel_data_table("liste_cat_attente");
}

function completerPaiement(id_inscription) {
    $.ajax({
        type: "GET",
        url: '/getForm/' + id_inscription,
        success: function(response) {
            // Vérifiez si la réponse contient une erreur
            if (response.message) {
                alert(response.message);
                return;
            }

            // Remplir les champs du formulaire avec les données récupérées
            $("#id_inscription").val(response.id_inscription);
            $("#montant").val(response.montant);

            // Afficher la modale
            $("#editPaiementModal").modal("show");
        },
        error: function(xhr, status, error) {
            console.error('Échec de l\'appel AJAX :', error);
        }
    });
}

$('#editPaiementForm').on('submit', function(e) {
    e.preventDefault(); // Empêche le rechargement de la page
    var form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // Sérialise les données du formulaire
        success: function(response) {
            if (response.success) {
                $('#editPaiementModal').modal('hide');
                // table_catechumene_inscrits_attente();

                // Remplissez les champs de la modale avec les détails du reçu
                $('#modalNomPrenom').text(response.recu.nom_prenom);
                $('#modalMontant').text(response.recu.montant + ' FCFA');
                $('#modalContact').text(response.recu.contact);
                $('#modalDatePaiement').text(new Date(response.recu.date_paiement).toLocaleDateString('fr-FR'));
                $('#modalDownloadLink').attr('href', `/download/recu/${response.recu.id_paiement}`);
                // Afficher la modale
                $('#recuModal').modal('show');
                table_catechumene_inscrits_attente();
            } else {
                alert('Le paiement a échoué.');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText); // Affiche l'erreur dans la console
        }
    });
});

//******************* */ LISTE DES CATECHUMENES INSCRIS POUR L'ANNEE EN COURS********************************
function liste_des_catechumene_inscrits() {
    $.ajax({
        type: "GET",
        url: "/listeInscritsPayer",
        dataType: "json",
        success: function(response) {
            table_catechumene_inscrits(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des catéchumènes inscrits.');
        }
    });
}

function table_catechumene_inscrits(response) {
    list_catechumene_inscris = response
    var tableau = '<table id="liste_cat_inscris" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Date Inscription</th>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Niveau catechetique</th>' +
        '<th>Session</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_catechumene_inscris.forEach(function(list_cat_inscr) {
        tableau += '<tr>' +
            '<td>' + date_format_fr(list_cat_inscr.date_paiement) + '</td>' +
            '<td>' + list_cat_inscr.nom_prenom + '</td>' +
            '<td>' + list_cat_inscr.niveau + '</td>' +
            '<td>' + list_cat_inscr.session + '</td>' +
            '<td>' +
            '<button type="button" onclick="" class="btn btn-primary">' +
            '' +
            '</button>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#catechumene_inscris").html(tableau);
    appel_data_table("liste_cat_inscris");
}

//*********************************      DECISION FINALE   *************************************** */
function liste_catechumenes_avec_decisions() {
    $.ajax({
        type: "GET",
        url: "/getListeCatechumenesAvecDecisions",
        dataType: "json",
        success: function(response) {
            // console.log(response);
            table_catechumene_avec_decisions(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des décisions.');
        }
    });
}

function table_catechumene_avec_decisions(response) {
    list_decision = response
    var tableau = '<table id="liste_cat_decision" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Niveau catéchetique</th>' +
        '<th>Session</th>' +
        '<th>T. Présence Catechese</th>' +
        '<th>T. Présence Messe</th>' +
        '<th>T. Présence CEB</th>' +
        '<th>Moy Finale</th>' +
        '<th>Décision Finale</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_decision.forEach(function(liste) {
        tableau += '<tr>' +
            '<td>' + liste.nom_prenom + '</td>' +
            '<td>' + liste.niveau + '</td>' +
            '<td>' + liste.session + '</td>' +
            '<td>' + liste.total_presence_catechese + '</td>' +
            '<td>' + liste.total_presence_messes + '</td>' +
            '<td>' + liste.total_presence_ceb + '</td>' +
            '<td>' + liste.moy_final + '</td>' +
            '<td>' + liste.decision_finale + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_decision_catechumene(' + liste.id + ')" class="btn btn-danger">' + 'Modifier'
        '</button>' +
        '</button>' +
        '</td>' +
        '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_decision_final").html(tableau);
    appel_data_table("liste_cat_decision");
}


function modal_decision_catechumene(i) {
    // console.log(list_decision);
    list_decision.forEach(element_modif => {
        if (element_modif.id == i) {
            $("#id_decisions_catechese").val(element_modif.id)
            $("#modif_moy_final").val(element_modif.moy_final)
            $("#modif_id_catechumene").val(element_modif.id_catechumene)
            $("#modif_total_presence_catechese").val(element_modif.total_presence_catechese)
            $("#modif_total_presence_messes").val(element_modif.total_presence_messes)
            $("#modif_total_presence_ceb").val(element_modif.total_presence_ceb)
            $("#modif_decision_finale").val(element_modif.decision_finale)
        }
    });
    $("#editDecisionModal").modal("show")


}

$('#editDecisionForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Décision !"
    text = "Modification des décisions  effectuée "
    send_form(form, titre, text)
    $("#editDecisionModal").modal("hide")
    setTimeout(() => {
        liste_catechumenes_avec_decisions()
    }, 200);
});
////******************************** CATECHUMENES FINIS ************************************************* */
function liste_catechumenes_fini() {
    $.ajax({
        type: "GET",
        url: "/getliste_catechumene_fini",
        dataType: "json",
        success: function(response) {
            // console.log(response);
            table_catechumene_fini_abandon(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des décisions.');
        }
    });
}

function table_catechumene_fini_abandon(response) {
    list_fini = response
    var tableau = '<table id="liste_cat_fini" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom & Prénom(s)</th>' +
        '<th>Niveau catéchetique</th>' +
        '<th>Session</th>' +
        '<th>Decision Final</th>' +
        '<th>Année catechetique</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_fini.forEach(function(liste_fini) {
        tableau += '<tr>' +
            '<td>' + liste_fini.nom_prenom + '</td>' +
            '<td>' + liste_fini.niveau + '</td>' +
            '<td>' + liste_fini.session + '</td>' +
            '<td>' + liste_fini.decision_finale + '</td>' +
            '<td>' + liste.annee_catechetique + '</td>' +
            '<td>' +
            //     '<button type="button" onclick="modal_decision_catechumene(' + liste.id + ')" class="btn btn-danger">' + 'Modifier'
            // '</button>' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_catechumne_fini_abandon").html(tableau);
    appel_data_table("liste_cat_fini");
}
// ****************************************GESTION DES CLASSES CATECHESES******************************
function liste_classes_catechese() {
    $.ajax({
        type: "GET",
        url: "/listeClasseCatechese",
        dataType: "json",
        success: function(response) {
            // console.log(response);
            table_des_classes(response);
        },
        error: function(xhr, status, error) {
            alert('Erreur lors de la récupération des classes.');
        }
    });
}

function table_des_classes(response) {
    list_classe_cate = response
    var tableau = '<table id="liste_cat_" class="display table table-striped table-bordered" style="width:100% !important">' +
        '<thead class="bg-white text-black">' +
        '<tr>' +
        '<th>Nom classe</th>' +
        '<th>Niveau</th>' +
        '<th>Session</th>' +
        '<th>Action</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>';

    list_classe_cate.forEach(function(liste_class) {
        tableau += '<tr>' +
            '<td>' + liste_class.lib_classe_cate + '</td>' +
            '<td>' + liste_class.niveau + '</td>' +
            '<td>' + liste_class.session + '</td>' +
            '<td>' +
            '<button type="button" onclick="modal_classe_catechese(' + liste_class.id + ')" class="btn btn-success mr-3" >' +
            'Modifier' +
            '</button>' +
            '<button type="button" onclick="supprimer_classe_cate(' + liste_class.id + ')" class="btn btn-danger mr-2" title="Supprimer">' +
            'Supprimer' +
            '</button>' +
            '</td>' +
            '</tr>';
    });

    tableau += '</tbody></table>';
    $("#liste_classe_catechese").html(tableau);
    appel_data_table("liste_cat_");
}

function modal_classe_catechese(i) {
    // console.log("Liste des classes :", list_classe_cate);

    list_classe_cate.forEach(element_modif => {
        // console.log("Élément courant :", element_modif); // Log de l'élément courant
        if (Number(element_modif.id) === Number(i)) {
            $("#id_classe").val(element_modif.id);
            $("#modif_lib_classe_cate").val(element_modif.lib_classe_cate);
            $("#modif_id_session").val(element_modif.id_session);
            $("#modif_id_niveau").val(element_modif.id_niveau);

        }
    });
    $("#editClasseModal").modal("show");
}


$('#editClasseForm').submit(function(e) {
    e.preventDefault();
    form = $(this)
    titre = "Modification Classe !"
    text = "Modification de la classe effectuée "
    send_form(form, titre, text)
    $("#editClasseModal").modal("hide")
    setTimeout(() => {
        liste_classes_catechese()
    }, 200);
});

function supprimer_classe_cate(id) {
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
            url: "/supp_classe_catechese/" + id,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                swal("Supprimé!", "Cette classe ne fait plus de votre base!", "success");
                liste_classes_catechese()
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
// ********************************* LES AFFECTATIONS ***************************************************

$.ajax({
    url: '/liste-catechumenes',
    type: 'GET',
    data: {
        niveau: selectedNiveauId,
        session: selectedSessionId
    },
    success: function(data) {
        // Traitement des données retournées
        $('#result-list').html(data);
    },
    error: function(xhr) {
        console.log('Erreur :', xhr.responseText);
    }
});


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