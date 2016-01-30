<script>

    function addCCRow() {
        var ls = JSON.parse(localStorage.jsdbwa);

        ls[6]["cc_rows_num"] += 1;
        ls[7]["cc_rows"].push({
            cc_name: "New CC Name",
            cc_date: "1st",
            cc_apr: 0.15,
            cc_min_pmt: 50,
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
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_min_pmt"] = $(row).val();
            } else if ($(row).attr('name') == "bal"){
                ls[7]["cc_rows"][$(row).data("ccrow")]["cc_bal"] = $(row).val();
            }
        }
        localStorage.jsdbwa = JSON.stringify(ls);
        buildPage();
    }

    $(function () {
        buildPage();
    });
    $("#add-new-card").click(function () {
       addCCRow();
    });

    function buildPage() {
        var ls = JSON.parse(localStorage.jsdbwa);
        document.getElementById("cc-table").innerHTML = `
            <tr>
                <th>Card Name</th>
                <th>Due Date</th>
                <th>APR</th>
                <th>Min Pmt</th>
                <th>Balance</th>
            </tr>
        `;
        for (var key in ls[7]["cc_rows"]) {
            var name = ls[7]["cc_rows"][key]["cc_name"];
            var date = ls[7]["cc_rows"][key]["cc_date"];
            var apr = ls[7]["cc_rows"][key]["cc_apr"];
            var mpmt = ls[7]["cc_rows"][key]["cc_min_pmt"];
            var bal = ls[7]["cc_rows"][key]["cc_bal"];
            document.getElementById("cc-table").innerHTML += `
            <tr data-ccrow="${key}">
                <td>
                    <input type="text" data-ccrow="${key}" name="name" value="${name}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-ccrow="${key}" name="date" value="${date}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-ccrow="${key}" name="apr" value="${apr}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-ccrow="${key}" name="mpmt" value="${mpmt}" onblur="editRow(this)">
                </td>
                <td>
                    <input type="text" data-ccrow="${key}" name="bal" value="${bal}" onblur="editRow(this)">
                </td>
                <td>
                    <button onclick="removeCCRow(this)" data-ccrow="${key}">Delete</button>
                </td>
            </tr>
            `;
        }
    }

</script>

<button onclick="showls()">Show localStorage</button>
<div id="page-container">
    <h1>Credit Card Manager</h1>
    <span id="add-new-card">+Add Credit Card</span>
    <table id="cc-table">

    </table>
</div>
