$(()=>{

    //function to add absence
    const saisiAbsence=()=>{

    }


    let absentCB=$('.absent');
    let congeCB=$('.conge');

    $('#btnabsence').on('click',()=>{
        for (var i = 0; i < absentCB.length; i++) {
            if(absentCB[i].checked==true)
            console.log(absentCB.val())
        }

        if(absentCB.checked==true){
           console.log(absentCB.val())

        }else if( congeCB.checked==true){
           console.log(congeCB.val())
        }
    })


});