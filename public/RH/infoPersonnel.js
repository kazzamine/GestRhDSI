$(()=>{

    //function uses ajax to update data and get response
    const updateInfo=(data)=>{
        $.ajax({
            url: '/empMenu/listEmp/empInfo/updateinfo',
            method: 'POST',
            async: false,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(responseText) {
                if (responseText == 'success') {
                    alertify
                        .success("les information d'employé ont été modifier", ()=>{
                            alertify.success();
                        });
                } else {
                    console.log(responseText)
                    alertify
                        .error("les information d'employé n'ont pas modifier verifier les informations entrer", ()=>{
                            alertify.error();
                        });
                }
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
    //get elements

    let btnupdate=$('#updateInfo');
    let grade=$('#grade');
    let telephone=$('#txtPhone');
    let devision=$('#devision');
    let service=$('#service');
    let adresse=$('#txtAdresse');
    //on click event to update
    $('#updateInfo').on("click",()=>{
        let data={
            cin:btnupdate.data('user-id'),
            grade:grade.val(),
            devision:devision.val(),
            service:service.val(),
            telephone:telephone.val(),
            adresse:adresse.val()
        }
        //calling function
        updateInfo(data);

    })

});