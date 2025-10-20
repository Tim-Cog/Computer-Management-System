const reassignParent = document.getElementsByClassName("reassign-parent")[0];
const translucent = document.getElementsByClassName("translucent")[0];
const historyContainer = document.getElementsByClassName("history-container")[0];

const assignmentVars = [
    document.getElementById("assigned-to"),
    document.getElementById("assigned-on"),
    document.getElementById("department"),
    document.getElementById("branch")
]
let keepEarlierName, keepEarlierDate;
// let dbData = [];
// let assignmentData = [];


document.getElementsByClassName("refresh")[0].addEventListener("click",function(){
    refresh();
});

document.getElementsByClassName("add-new-device")[0].addEventListener("click",function(){
    location.replace("../input_device/input_inventory.html");
    console.log("Work");
})

document.getElementsByClassName("close-button")[0].addEventListener("click",function(){
    document.getElementsByClassName("no-results")[0].style.display = "none"
})

document.getElementsByClassName("close-reassign-window")[0].addEventListener("click",function(){
   reassignParent.style.display = "none"
   translucent.style.display = "none";
})

document.getElementsByClassName("cancel")[0].addEventListener('click',
    function(){
        translucent.style.display = "none";
        reassignParent.style.display = "none";
    }
)

translucent.addEventListener("click",function(){
    translucent.style.display = "none";
    reassignParent.style.display = "none";
    historyContainer.style.display = "none";

})

document.getElementById("assigned-to").addEventListener("focusout",function(){
    if(keepEarlierName && keepEarlierName!= document.getElementById("assigned-to").value && keepEarlierDate && keepEarlierDate== document.getElementById("assigned-on").value){
        assignmentVars[1].value = null
        assignmentVars[2].value = null
        assignmentVars[3].value = null
    }
})

document.getElementById("assigned-on").addEventListener("focusout",function(){
    if(keepEarlierName && keepEarlierName== document.getElementById("assigned-to").value && keepEarlierDate && keepEarlierDate!= document.getElementById("assigned-on").value){
        assignmentVars[0].value = null
        assignmentVars[2].value = null
        assignmentVars[3].value = null
    }
})


function callJSON(PHPFile){
    let list_all = document.getElementsByClassName("all-info")[0];
    while(list_all.lastChild && list_all.lastChild.tagName === "TR"){
        // console.log("Deisappear");
        list_all.lastChild.remove();
    }
    // console.log(PHPFile[0])
    for(let i = 0 ; i < PHPFile.length; i++){
        let newRow = document.createElement("tr");
        newRow.setAttribute("class","records")
        list_all.append(newRow)
        for(const column in PHPFile[i]){
            let newCell = document.createElement("td");
            newCell.style.fontSize = "small"
            newCell.innerHTML = PHPFile[i][column];
            newRow.append(newCell)
        }
        let reassign = document.createElement("td");
        let deviceHistoryWrapper = document.createElement("button")
        newRow.childNodes[11].style.display = "none"
        newRow.childNodes[12].style.display = "none"

        reassign.innerHTML="REASSIGN";
        reassign.setAttribute("class","reassign-button")
        deviceHistoryWrapper.setAttribute("class","click-background-image")
        deviceHistoryWrapper.setAttribute("type","submit")
        deviceHistoryWrapper.setAttribute("form","submit-history")

        deviceHistoryWrapper.addEventListener("click",function(){
            translucent.style.display = "block";
            historyContainer.style.display = "block";
            while(historyContainer.lastChild && historyContainer.lastChild.tagName === "TR"){
                historyContainer.lastChild.remove();
            }
            document.getElementById("submit-history-id").value = reassign.parentElement.firstChild.innerHTML;
        })
        

        //Increase Opacity when the reassign box opens
        reassign.addEventListener("click",function(){
            translucent.style.display = "block";
            reassignParent.style.display = "block";
            document.getElementById("device-name").value = reassign.parentElement.firstChild.innerHTML;
            document.getElementById("device-model").value = reassign.parentElement.children[1].innerHTML
            document.getElementById("serial-number").value = reassign.parentElement.children[3].innerHTML
            document.getElementById("department").value = reassign.parentElement.children[8].innerHTML
            document.getElementById("branch").value = reassign.parentElement.children[9].innerHTML
            document.getElementById("assigned-to").value = reassign.parentElement.children[10].innerHTML
            document.getElementById("assigned-on").value = reassign.parentElement.children[11].innerHTML
            document.getElementById("returned-on").value = reassign.parentElement.children[12].innerHTML

            for(let j = 8; j < 13; j++){
                // console.log(reassign.parentElement.children[j].innerHTML, " - ", j)
                if(reassign.parentElement.children[j].innerHTML == null && j != 12){
                    console.log("condition 1")
                    break;
                }else if(reassign.parentElement.children[j].innerHTML == "" && j == 12){
                    document.getElementById("department").setAttribute("readonly","readonly")
                    document.getElementById("branch").setAttribute("readonly","readonly")
                    document.getElementById("assigned-to").setAttribute("readonly","readonly")
                    document.getElementById("assigned-on").setAttribute("readonly","readonly")
                    // document.getElementById("returned-on").setAttribute("readonly","readonly")
                    document.getElementById("updteOrInsert").value = "yes"
                    console.log("condition 2")
                }else if(reassign.parentElement.children[j].innerHTML != "  " && j==12){
                    document.getElementById("department").value = null;
                    document.getElementById("branch").value = null;
                    document.getElementById("assigned-to").value = null;
                    document.getElementById("assigned-on").value = null;
                    document.getElementById("returned-on").value = null;
                    console.log("condition 3")
                }
            }

            keepEarlierName = document.getElementById("assigned-to").value;
            keepEarlierDate = document.getElementById("assigned-on").value;
        })

        newRow.append(deviceHistoryWrapper)
        newRow.append(reassign)
    }
    return PHPFile;
}



function refresh(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callJSON(JSON.parse(this.responseText));
        }
    };
    xhttp.open("POST", "../../DB/list_all_devices.php", true);
    xhttp.send();
}


window.addEventListener("load",refresh);


//Prevent input when date is wrong
document.getElementById("assigned-on").addEventListener("focus",function(){
    if(new Date(document.getElementById("assigned-on").value) > new Date(document.getElementById("returned-on").value)){
        document.getElementById("warning").style.display = "block"
        document.getElementById("assigned-on").value = null;
        document.getElementById("returned-on").value = null;
    }else{
        document.getElementById("warning").style.display = "none"
    }
})

document.getElementById("returned-on").addEventListener("focus",function(){
    if(new Date(document.getElementById("assigned-on").value) > new Date(document.getElementById("returned-on").value)){
        document.getElementById("warning").style.display = "block"
        document.getElementById("assigned-on").value = null;
        document.getElementById("returned-on").value = null;
    }else{
        document.getElementById("warning").style.display = "none"
    }
})

document.getElementById("assigned-on").addEventListener("change",function(){
    if(new Date(document.getElementById("assigned-on").value) > new Date(document.getElementById("returned-on").value)){
        document.getElementById("warning").style.display = "block"
        document.getElementById("assigned-on").value = null;
        document.getElementById("returned-on").value = null;
    }else{
        document.getElementById("warning").style.display = "none"
    }
})

document.getElementById("returned-on").addEventListener("change",function(){
    if(new Date(document.getElementById("assigned-on").value) > new Date(document.getElementById("returned-on").value)){
        document.getElementById("warning").style.display = "block"
        document.getElementById("assigned-on").value = null;
        document.getElementById("returned-on").value = null;
    }else{
        document.getElementById("warning").style.display = "none"
    }
})



//update function
    $("#reassign-form" ).on("submit",function (e) { 
        var dataString = $(this).serialize();
        // alert(dataString);
        console.log("work")
        $.ajax({
            type : "POST",
            url : "../../DB/assignment_info.php",
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


    //search function
    $("#search-form" ).on("submit",function(e){
        var searchString = $(this).serialize();
        alert(searchString);
        // console.log("work")
        $.ajax({
            type : "POST",
            url : "../../DB/search_device.php",
            data : searchString,
            success : function(data){
                //alert("search completed");
                alert(data)
                if(data === "No results found"){
                    document.getElementsByClassName("no-results")[0].style.display = "block"
                }else{
                    document.getElementsByClassName("no-results")[0].style.display = "none"
                    callJSON(JSON.parse(data));
                }
            },
            error : function(jqXHR, textStatus, errorThrown){
                console.error("Eror: ", textStatus, errorThrown);
                alert("There was an error during the search");
            }
        });
        e.preventDefault();
    });


    $("#submit-history" ).on("submit",function(e){
        var historyString = $(this).serialize();
        // alert(dataString);
        console.log("work")
        $.ajax({
            type : "POST",
            url : "../../DB/find_history.php",
            data : historyString,
            success : function(data){
                console.log(data)
                
                let historyData = JSON.parse(data);
                (function(){
                    for(let i = 0; i < historyData.length; i++){
                        let newRow = document.createElement("tr");
                        newRow.setAttribute("class","history-records")
                        historyContainer.append(newRow)
                        for(const column in historyData[i]){
                            let newCell = document.createElement("td");
                            newCell.innerHTML = historyData[i][column];
                            newRow.append(newCell)
                        }
                    }
                })()
                // alert(data)
            },
            error : function(jqXHR, textStatus, errorThrown){
                console.error("Eror: ", textStatus, errorThrown);
                alert("There was an error during the search");
            }
        });
        e.preventDefault();
    });