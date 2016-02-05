<script>
    function calmPmts() {
        var ls = JSON.parse(localStorage.jsdbwa);
        ls[5]["static_vals"][0]["cc_mpmts"] = 0;
        for (var key in ls[7]["cc_rows"]) {
            ls[5]["static_vals"][0]["cc_mpmts"] += Number(ls[7]["cc_rows"][key]["cc_mpmt"]);
        }
        localStorage.jsdbwa = JSON.stringify(ls);
    }

    function calBal() {
        var ls = JSON.parse(localStorage.jsdbwa);
        ls[5]["static_vals"][0]["cc_balance"] = 0;
        for (var key in ls[7]["cc_rows"]) {
            ls[5]["static_vals"][0]["cc_balance"] += Number(ls[7]["cc_rows"][key]["cc_bal"]);
        }
        localStorage.jsdbwa = JSON.stringify(ls);
    }

    function addCCRow() {
        var ls = JSON.parse(localStorage.jsdbwa);

        ls[6]["cc_rows_num"] += 1;
        ls[7]["cc_rows"].push({
            cc_name: "New CC Name",
            cc_date: "1st",
            cc_apr: 0.15,
            cc_mpmt: 50,
            cc_bal: 9001
        });

        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function removeCCRow(row) {
        var ls = JSON.parse(localStorage.jsdbwa);
        var rowtd = $(row).data("ccrow");
        ls[7]["cc_rows"].splice(rowtd, 1);
        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function editRow(row) {
        var ls = JSON.parse(localStorage.jsdbwa);
        if ($(row).data("ccrow") != undefined) {
            if ($(row).attr('name') == "name") {
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_name"] = $(row).val();
            } else if ($(row).attr('name') == "date"){
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_date"] = $(row).val();
            } else if ($(row).attr('name') == "apr"){
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_apr"] = $(row).val();
            } else if ($(row).attr('name') == "mpmt"){
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_mpmt"] = $(row).val();
            } else if ($(row).attr('name') == "bal"){
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_bal"] = $(row).val();
            }
        }
        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    buildPage();
    $("#add-new-card").click(function () {
       addCCRow();
    });

    function buildPage() {
        calmPmts();
        calBal();
        var ls = JSON.parse(localStorage.jsdbwa);

        for (var key in ls[7]["cc_rows"]) {
            var name = ls[7]["cc_rows"][key]["cc_name"];
            var date = ls[7]["cc_rows"][key]["cc_date"];
            var apr = ls[7]["cc_rows"][key]["cc_apr"];
            var mpmt = ls[7]["cc_rows"][key]["cc_mpmt"];
            var bal = ls[7]["cc_rows"][key]["cc_bal"];

            var template_builder = ''+
            '<div data-ccrow="${key}" class="row">'+
            '    <div class="col-md-2 col-xs-2"><input type="text" data-ccrow="${key}" name="name" value="${name}" onblur="editRow(this)"></div>'+
            '    <div class="col-md-2 col-xs-2"><input type="text" data-ccrow="${key}" name="date" value="${date}" onblur="editRow(this)"></div>'+
            '    <div class="col-md-2 col-xs-2"><input type="text" data-ccrow="${key}" name="apr" value="${apr}" onblur="editRow(this)"></div>'+
            '    <div class="col-md-2 col-xs-2"><input type="text" data-ccrow="${key}" name="mpmt" value="${mpmt}" onblur="editRow(this)"></div>'+
            '    <div class="col-md-2 col-xs-2"><input type="text" data-ccrow="${key}" name="bal" value="${bal}" onblur="editRow(this)"></div>'+
            '    <div class="col-md-2 col-xs-2"><button onclick="removeCCRow(this)" data-ccrow="${key}">Delete</button></div>'+
            '</div>'+
            '';
            var template_key_built  = template_builder.replace(/\$\{key\}/gi, key);
            var template_name_built = template_key_built.replace(/\$\{name\}/gi, name);
            var template_date_built = template_name_built.replace(/\$\{date\}/gi, date);
            var template_apr_built  = template_date_built.replace(/\$\{apr\}/gi, apr);
            var template_mpmt_built = template_apr_built.replace(/\$\{mpmt\}/gi, mpmt);
            var template_bal_built  = template_mpmt_built.replace(/\$\{bal\}/gi, bal);


            var template_built = template_bal_built;
            document.getElementById("cc-table").innerHTML = template_built;

        }
        var tbal = ls[5]["static_vals"][0]["cc_balance"];
        var mpmts = ls[5]["static_vals"][0]["cc_mpmts"];

        var template_builder = '' +
        '<div><span>Min Payments: ${mpmts}</span></div>' +
        '<div><span>Balance: ${tbal}</span></div>'+
        '';
        var template_mpmts_built  = template_builder.replace(/\$\{mpmts\}/gi, mpmts);
        var template_tbal_built = template_mpmts_built.replace(/\$\{tbal\}/gi, tbal);

        var template_built = template_tbal_built;
        document.getElementById("cc-table").innerHTML += template_built;
    }

</script>

<button onclick="showls()">Show localStorage</button>
<div id="page-container">
    <h3 id="expense_header">Credit Card Manager</h3>
    <span id="add-new-card"><b>+Add Credit Card</b></span><br><br>

    <div id="cc-table">

    </div>
</div>
