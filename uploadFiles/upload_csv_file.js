$("#inputFileForm" ).on("submit",function (e) { 
    var dataString = $(this).serialize();
    console.log("work")
    $.ajax({
        type : "POST",
        url : "upload_csv_file.php",
        data : dataString,
        success: function(data){
            alert("Record Successfully Made")
            window.alert(data)
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: ", textStatus, errorThrown);
            alert("There was an error updating the record.");
        }
    });
    e.preventDefault();
});