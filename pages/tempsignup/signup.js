$("#signup" ).on("submit",function (e) { 
    var dataString = $(this).serialize();
    // alert(dataString);
    // console.log("work")
    $.ajax({
        type : "POST",
        url : "../../DB/signup.php",
        data : dataString,
        success: function(data){
            alert("Record Successfully Updated")
            window.alert(data)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: ", textStatus, errorThrown);
            alert("There was an error updating the record.");
        }
    });
    e.preventDefault();
});