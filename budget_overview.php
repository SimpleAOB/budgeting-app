<script>
    function resetls() {
        alert("Resetting jsd-bwa. Refresh page.");
        localStorage.removeItem("jsdbwa");
    }

    function showls() {
        console.log(localStorage.jsdbwa);
    }
    ///Start non debugging features
    buildPage();
    function addIncomeRow() {
        var ls = JSON.parse(localStorage.jsdbwa);

        ls[1]["income_rows_num"] += 1;
        ls[3]["income_rows"].push({
            row_name: "New Income Field",
            row_value: 0
        });

        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function removeIncomeRow(row) {
        var ls = JSON.parse(localStorage.jsdbwa);
        var rowtd = $(row).data("irow");
        ls[3]["income_rows"].splice(rowtd, 1);
        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function addExpenseRow() {
        var ls = JSON.parse(localStorage.jsdbwa);

        ls[2]["expense_rows_num"] += 1;
        ls[4]["expense_rows"].push({
            row_name: "New Expense Field",
            row_value: 0
        });

        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function removeExpenseRow(row) {
        var ls = JSON.parse(localStorage.jsdbwa);
        var rowtd = $(row).data("erow");
        ls[4]["expense_rows"].splice(rowtd, 1);
        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function editRow(row) {
        var ls = JSON.parse(localStorage.jsdbwa);
        if ($(row).data("irow") != undefined) {
            if ($(row).attr('name') == "name") {
                ls[3]["income_rows"][$(row).data("irow")]["row_name"] = $(row).val();
            } else if ($(row).attr('name') == "val"){
                ls[3]["income_rows"][$(row).data("irow")]["row_value"] = $(row).val();
            }
        } else if ($(row).data("erow") != undefined) {
            if ($(row).attr('name') == "name") {
                ls[4]["expense_rows"][$(row).data("erow")]["row_name"] = $(row).val();
            } else if ($(row).attr('name') == "val"){
                ls[4]["expense_rows"][$(row).data("erow")]["row_value"] = $(row).val();
            }
        }

        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    function buildNet() {
        var ls = JSON.parse(localStorage.jsdbwa);
        ls[5]["static_vals"][0]["net_income"] = 0;
        for (var key in ls[3]["income_rows"]) {
            ls[5]["static_vals"][0]["net_income"] += Number(ls[3]["income_rows"][key]["row_value"]);
        }
        for (var key in ls[4]["expense_rows"]) {
            ls[5]["static_vals"][0]["net_income"] -= Number(ls[4]["expense_rows"][key]["row_value"]);
        }
        localStorage.jsdbwa = JSON.stringify(ls);
        return ls[5]["static_vals"][0]["net_income"];
    }

    function buildPage() {
        var ls = JSON.parse(localStorage.jsdbwa);

        document.getElementById("income-table").innerHTML = "";
        document.getElementById("expense-table").innerHTML = "";
        for (var key in ls[3]["income_rows"]) {
            var name = ls[3]["income_rows"][key]["row_name"];
            var value = ls[3]["income_rows"][key]["row_value"];

            var template_builder = ''+
            '<div data-irow="${key}" class="row">'+
            '    <div id="income_name${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2"><input type="text" name="name" value="${name}" data-irow="${key}" onblur="editRow(this)"></div>'+
            '    <div id="income_input${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2"><input type="text" name="val" value="${value}" data-irow="${key}" onblur="editRow(this)"></div>'+
            '    <div id="income_del${key}" onclick="removeIncomeRow(this)" data-irow="${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2">Delete</div>'+
            '</div>'+
            '';
            var template_key_built = template_builder.replace(/\$\{key\}/gi, key);
            var template_name_built = template_key_built.replace(/\$\{name\}/gi, name);
            var template_value_built = template_name_built.replace(/\$\{value\}/gi, value);

            //template_built is equal to the final build stage
            var template_built = template_value_built;
            document.getElementById("income-table").innerHTML += template_built;
        }
        for (var key in ls[4]["expense_rows"]) {
            var name = ls[4]["expense_rows"][key]["row_name"];
            var value = ls[4]["expense_rows"][key]["row_value"];

            var template_builder = ''+
            '<div data-erow="${key}" class="row">'+
            '    <div id="expense_name${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2"><input type="text" name="name" value="${name}" data-erow="${key}" onblur="editRow(this)"></div>'+
            '    <div id="expense_input${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2"><input type="text" name="val" value="${value}" data-erow="${key}" onblur="editRow(this)"></div>'+
            '    <div id="expense_del${key}" onclick="removeExpenseRow(this)" data-erow="${key}" class="col-md-4 col-md-offset-2 col-xs-4 col-xs-offset-2">Delete</div>'+
            '</div>'+
            '';
            var template_key_built = template_builder.replace(/\$\{key\}/gi, key);
            var template_name_built = template_key_built.replace(/\$\{name\}/gi, name);
            var template_value_built = template_name_built.replace(/\$\{value\}/gi, value);

            //template_built is equal to the final build stage
            var template_built = template_value_built;
            document.getElementById("expense-table").innerHTML += template_built;
        }
        var net = buildNet();
        document.getElementById("total_incomeSum").innerHTML = net;
    }
    </script>

<button onclick="resetls()">Reset localStorage</button>
<button onclick="showls()">Show localStorage</button>
    <div onload="pageInit()" id="page-container">
        <h2 id="title"></h2>
        <div class="income_header">
            <h2 onclick="addIncomeRow()">Income</h2>
        </div>
        <div id="income-table">

        </div>
        <div class="expense_header">
            <h2 onclick="addExpenseRow()">Expenses</h2>
        </div>
        <div id="expense-table">

        </div>
        <div id="total_income">
            <div id="expense_name" class="col-md-4 col-xs-6 col-md-offset-3"><h3 id="expense_header">Total Income: </h3></div>
            <div id="expense_input" class="col-md-2 col-xs-2"><h3 id="total_incomeSum"></h3></div>
        </div>
    </div>
