$(() => {
        $("#add-contract-btn").on('click', _addContract);
        $("[name='update-contract-btn']").on('click', _updateContract);
        $("[name='remove-contract-btn']").on('click', _removeContract);

        function _addContract() {
            let $btn = $(this);
            let $contract_block = $btn.closest("[name='contract-block']");
            let company = $contract_block.find("[name='company']").val();
            let number = $contract_block.find("[name='number']").val();
            let name = $contract_block.find("[name='name']").val();
            let sum = $contract_block.find("[name='sum']").val();
            let data_start = $contract_block.find("[name='data-start']").val();
            let data_end = $contract_block.find("[name='data-end']").val();
            let prepaid = $contract_block.find("[name='prepaid']").val();

            $.ajax({
                url: 'contract/add_contract.php',
                data: {
                    company: company,
                    number: number,
                    name: name,
                    sum: sum,
                    data_start: data_start,
                    data_end: data_end,
                    prepaid: prepaid,
                },
            }).done(function (data) {
                $("[name='contracts-list']").prepend(
                    ` <div name="contract-block">
            <label>Contract id: ${data}</label><br/>

            <label>Contract company:</label><br/>
            <input type="number" name="company" value="${company}"><br/>

            <label>Contract number:</label><br/>
            <input type="number" name="number" value="${number}"><br/>

            <label>Contract name:</label><br/>
            <input type="text" name="name" value="${name}"><br/>

            <label>Contract sum:</label><br/>
            <input type="text" name="sum" value="${sum}"><br/>

            <label>Contract data start:</label><br/>
            <input type="date" name="data-start" value="${data_start}"><br/>

            <label>Contract data end:</label><br/>
            <input type="date" name="data-end" value="${data_end}"><br/>

            <label>Contract prepaid:</label><br/>
            <input type="text" name="prepaid" value="${prepaid}"><br/>

            <button data-id="${data}" name="update-contract-btn" type="button">
                Update
            </button>

            <button data-id="${data}" name="remove-contract-btn" type="button">
                Remove
            </button>
            <br/>
            <br/>
        </div>`);
                alert("added successful");
            }).fail(function () {
                alert("error with adding");
            });
        }

        function _updateContract() {
            let $btn = $(this);
            let $contract_block = $btn.closest("[name='contract-block']");
            let id = $btn.attr("data-id");
            let company = $contract_block.find("[name='company']").val();
            let number = $contract_block.find("[name='number']").val();
            let name = $contract_block.find("[name='name']").val();
            let sum = $contract_block.find("[name='sum']").val();
            let data_start = $contract_block.find("[name='data-start']").val();
            let data_end = $contract_block.find("[name='data-end']").val();
            let prepaid = $contract_block.find("[name='prepaid']").val();

            $.ajax({
                url: 'contract/update_contract.php',
                data: {
                    id: id,
                    company: company,
                    number: number,
                    name: name,
                    sum: sum,
                    data_start: data_start,
                    data_end: data_end,
                    prepaid: prepaid,
                },
            }).done(function () {
                alert("updated successful");
            }).fail(function () {
                alert("error with update");
            })
        }

        function _removeContract() {
            let $btn = $(this);
            let $contract_block = $btn.closest("[name='contract-block']");
            let id = $btn.attr("data-id");

            $.ajax({
                url: 'contract/remove_contract.php',
                data: {
                    id: id,
                },
            }).done(function () {
                $contract_block.remove();
                alert("removed successful");
            }).fail(function () {
                alert("error with removing: ");
            });
        }
    }
);