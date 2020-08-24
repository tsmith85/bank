/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// load all ajax scripts
function loadAjax() {
    loadAccountsList();
}

// Ajax call to load the list of accounts
function loadAccountsList() {    
    $.get("../ajax/account_list.php", function(html) {
        $("#load_accounts").html(html);
    });
}

// Ajax call to load the detail of the selected account
function loadAccountDetail(data) {    
    $.get("../ajax/account_detail.php?account=" + encodeURIComponent(data), function(html) {
        $("#load_accounts").html(html);
    });
}

// display account details of the one selected
function accountDetail() {     
    var e = e || window.event;
    var data = [];
    var target = e.srcElement || e.target;

    while(target && target.nodeName !== "TR") {
        target = target.parentNode;
    }

    if(target) {
        var cells = target.getElementsByTagName("td");

        for(var i = 0; i < cells.length; i++) {
            data.push(cells[i].innerHTML);
        }
    }
    
    loadAccountDetail(data[0]);
};

// function to credit one of the users own accounts
function submitTransfer() {
    
    var xhttp = new XMLHttpRequest();
    
    var account = document.getElementById("account_no").innerHTML;
    var amount = document.getElementById("transfer_amount").value;
    var transfer = document.getElementById("account_list_cmb").value;
    
    xhttp.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            document.getElementById("transfer_status").innerHTML = this.responseText;
        }
    };
    
    xhttp.open("POST", "../ajax/submit_transfer.php?account=" + encodeURIComponent(account) + 
            "&amount=" + encodeURIComponent(amount) + "&transfer=" + encodeURIComponent(transfer) , true);
    xhttp.send();
    
    //loadAccountDetail(account);
}

// Function to credit a new persons account
function submitTransferPerson() {
    
    var xhttp = new XMLHttpRequest();
    
    var account = document.getElementById("account_no").innerHTML;
    var amount = document.getElementById("transfer_amount_person").value;
    var transfer = document.getElementById("transfer_account_no").value;
    
    xhttp.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            document.getElementById("transfer_status").innerHTML = this.responseText;
        }
    };
    
    xhttp.open("POST", "../ajax/submit_transfer_person.php?account=" + encodeURIComponent(account) + 
            "&amount=" + encodeURIComponent(amount) + "&transfer=" + encodeURIComponent(transfer) , true);
    xhttp.send();
    
    //loadAccountDetail(account);
}

