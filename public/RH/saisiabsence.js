$(()=>{

    //function to add absence
    const saisiAbsence=()=>{
        $.ajax({
            url: '/RH/absence/absencemenu/ajouterabsence',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                if (responseText == 'success') {
                    alertify
                        .success("Enregistrer avec success", ()=>{
                            alertify.success();
                        });
                } else {
                    console.log(responseText)
                    alertify
                        .error('Error essayer plus tard', ()=>{
                            alertify.error();
                        });
                }
            },
            error: function(response) {
                console.log(response)
                alertify
                    .error("Error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
    }


    let absentCB=$('.absent');
    let dateJour=$('#dateAbsence');
    let dateEntre=$('.dateEntre');
    let dateSortie=$('#dateSortie');

    $('#btnSaveAbsence').on('click',()=>{
        console.log('clicked')
        // if(absentCB[0].val()){
        //     console.log('absent')
        // }
        for (var i = 0; i < absentCB.length; i++) {
            console.log(dateEntre.val())
            if(absentCB[i].checked==true){
                console.log(absentCB[i].dataset.persoId)
            }
        }

    })


    //ajouter certificat medical
    const addcertificat=(data)=>{
        $.ajax({
            url: '/RH/absence/personnelAbsence/addcert',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                    alertify
                        .success("certificat ajouter avec success", ()=>{
                            alertify.success();
                        });
               }
            ,
            error: function(response) {
                console.log(response)
                alertify
                    .error("Error!! verifier ce que tu as saisi", ()=>{
                        alertify.error();
                    });
            }
        });
    }

    let dateDebutCert=$('#datedebutCer');
    let datefinCert=$('#datefinCert');
    let justification=$('#typeJust');
    $('#saveCert').on('click',()=>{
        let data={
            datedebutCer:dateDebutCert.val(),
            datefinCert:datefinCert.val(),
            justification:justification.val(),
            empid:$('#saveCert').val()
        }
        if(dateDebutCert.val()==='' || datefinCert.val()==='' || justification.val()===''){
            alertify
                .warning("il faut remplir tous les champs", ()=>{
                    alertify.warning();
                });
        }else{
            addcertificat(data);
        }

    })


});