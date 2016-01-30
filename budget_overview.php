<script>
    function resetls() {
        alert("Resetting jsd-bwa. Refresh page.");
        localStorage.removeItem("jsdbwa");
    }

    function showls() {
        console.log(localStorage.jsdbwa);
    }
    ///Start non debugging features
    $(function() {
        if (typeof(Storage) !== "undefined") {
            if (localStorage.jsdbwa == null) {
                console.log("Initializing BWA array");
                var initBWA = [];
                initBWA.push({
                    title: "Unnamed Budget Project"
                });
                initBWA.push({
                    income_rows_num: 0
                });
                initBWA.push({
                    expense_rows_num: 0
                });
                initBWA.push({
                    income_rows: []
                });
                initBWA.push({
                    expense_rows: []
                });
                initBWA.push({
                    static_vals: [{
                            net_income: 0,
                            cc_mpmts: 0,
                            cc_balance: 0
                        }]
                });
                initBWA.push({
                    cc_rows_num: 0
                });
                initBWA.push({
                    cc_rows: []
                });
                localStorage.jsdbwa = JSON.stringify(initBWA);
                showls();
            }
        } else {
            alert("We are sorry, your device does not support localStorage. This application depends on it to save data.");
        }
        buildPage();
    });

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
        // document.title = ls[0]["title"] + " | Budget Web App";
        // document.getElementById("title").innerHTML = ls[0]["title"];

        document.getElementById("income-table").innerHTML = `
        <tr>
            <th><span id='income_header'>INCOME</span></th>
            <th onclick="addIncomeRow()">+New Field</th>
        </tr>
        `;
        document.getElementById("expense-table").innerHTML = `
        <tr>
            <th><span id='expense_header'>EXPENSES</span></th>
            <th onclick="addExpenseRow()">+New Field</th>
        </tr>
        `;

        for (var key in ls[3]["income_rows"]) {
            var name = ls[3]["income_rows"][key]["row_name"];
            var value = ls[3]["income_rows"][key]["row_value"];
            document.getElementById("income-table").innerHTML += `
            <tr data-irow="${key}">
                <td>
                    <input type="text" data-irow="${key}" name="name" value="${name}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-irow="${key}" name="val" value="${value}" onblur="editRow(this)">
                </td>
                <td>
                    <button onclick="removeIncomeRow(this)" data-irow="${key}">Delete</button>
                </td>
            </tr>
            `;
        }
        for (var key in ls[4]["expense_rows"]) {
            var name = ls[4]["expense_rows"][key]["row_name"];
            var value = ls[4]["expense_rows"][key]["row_value"];
            document.getElementById("expense-table").innerHTML += `
            <tr data-erow="${key}">
                <td>
                    <input type="text" data-erow="${key}" name="name" value="${name}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-erow="${key}" name="val" value="${value}" onblur="editRow(this)">
                </td>
                <td>
                    <button onclick="removeExpenseRow(this)" data-erow="${key}">Delete</button>
                <td/>
            </tr>
            `;
        }
        var net = buildNet();
        document.getElementById("total_income").innerHTML = net;
    }
    </script>

<button onclick="resetls()">Reset localStorage</button>
<button onclick="showls()">Show localStorage</button>
    <div id="page-container">
        <h2 id="title"></h2>
        <table id="income-table">

        </table>
        <table id="expense-table">

        </table>
        <div id="total_income">

        </div>
    </div>
