$(()=>{
    //telecharger attestation de quitter terri
    const attQuitter=()=>{
        $.ajax({
            url: '/pdf/attestationquitter',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                alertify
                    .success("demande envoyé avec success", () => {
                        alertify.success();
                    });
            },
            error: function(response) {
                console.log(response)
                alertify
                    .error("une error de system essayer plus tard", ()=>{
                        alertify.error();
                    });
            }
        });
    }

    let datedebut='';
    let datefin='';
    $('#attQT').on('click',()=>{
        data={
            empid:$('#attQT').val(),
            datedebut:datedebut.val(),
            datefin:datefin.val(),

        }
    })
})