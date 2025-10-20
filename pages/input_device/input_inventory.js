$("#upload-device" ).on("submit",function (e) { 
    var dataString = $(this).serialize();
    console.log("work")
    $.ajax({
        type : "POST",
        url : "../../DB/add_new_device.php",
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


document.getElementsByClassName("see-list")[0].addEventListener("click",function(){
    location.replace("../list_devices/list_devices.html");
    console.log("Work");
})