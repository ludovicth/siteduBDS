$(document).ready(function() {
    $('#calendar').fullCalendar({
        events: 'js/json-events.php',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        minTime: "8:00am",
        maxTime: "11:00pm",
        defaultView: "agendaWeek",
        firstDay: "1",
        monthNames: ['Janvier', 'FÃ©vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'AoÃ»t', 'Septembre', 'Octobre', 'Novembre', 'DÃ©cembre'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        titleFormat: {
            month: 'MMMM yyyy',
            week: "d[ MMMM][ yyyy]{ - d MMMM yyyy}",
            day: 'dddd d MMMM yyyy'
        },
        buttonText: {
            today: 'aujourd\'hui',
            day: 'jour',
            week: 'semaine',
            month: 'mois',
            prev: '&lt;',
            next: '&gt;'
        },
        axisFormat: 'H:mm',
        timeFormat: {
            '': 'H:mm',
            agenda: 'H:mm{ - H:mm}'
        },
        allDayText: 'Jour Entier',
        eventRender: function(event, element) {
            if (event.type==="événement"){
                element.find('.fc-event-title');
            }
            else {
                element.find('.fc-event-title').append("<br/>VS. " + event.adversaire + "<br/>Lieu : " + event.lieu);
            }
        },
        eventClick: function(calEvent) {
            if (calEvent.type==="événement"){
                s = "<span style=\"font-weight:bold\">"+calEvent.title+"</span>";
                s += "<br>Le "+$.fullCalendar.formatDate(calEvent.start, "dd/MM/yyyy");
                s += "<br><em>"+calEvent.descriptif+"</em><br></p>";
                //s += "<p style=\"font-size: smaller\">Identifiant : "+calEvent.id+"</p>"; Ce commentaire pourra être réactivé si on ajoute un jour une fonction pour retirer l'événement
                $("#message").empty().append(s);
                $("#popupDialog").dialog();
            }
            else {
                s = "<span style=\"font-weight:bold\">Le "+$.fullCalendar.formatDate(calEvent.start, "dd/MM/yyyy")+" de "+$.fullCalendar.formatDate(calEvent.start, "H:mm")+" à  "+$.fullCalendar.formatDate(calEvent.end, "H:mm")+"</span>";
                s += "<br><b>"+calEvent.title+"</b> vs. "+calEvent.adversaire+"<br>";
                s += "Lieu : "+calEvent.lieu+"<br>";
                s += "Joueur(s) : "+calEvent.joueurs+"<br>";
                s += "<em>"+calEvent.pub+"</em><br></p>";
                s += "<p style=\"font-size: smaller\">Identifiant : "+calEvent.id+"</p>";
                $("#message").empty().append(s);
                $("#popupDialog").dialog();
            }
        }
    });
});

// utiliser https://www.enseignement.polytechnique.fr/informatique/INF441/mobile/enex/site/js/enex.mobile.js pour aide au code