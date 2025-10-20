function history(exported_data){
    let history_pane = document.createElement("div");
    let history_table = document.createElement("table");
    for(let i = 0; i < exported_data.length; i++){
        let history_row = document.createElement("tr")
        history_row.append(document.createElement("td").innerHTML = exported_data[i][0])
        history_row.append(document.createElement("td").innerHTML = exported_data[i][1])
    }
}
