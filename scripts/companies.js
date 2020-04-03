$(() => {
        $("#add-company-btn").on('click', _addCompany);
        $("[name='update-company-btn']").on('click', _updateCompany);
        $("[name='remove-company-btn']").on('click', _removeCompany);

        function _addCompany() {
            let $btn = $(this);
            let $company_block = $btn.closest("[name='company-block']");
            let name = $company_block.find("[name='name']").val();
            let chief = $company_block.find("[name='chief']").val();
            let address = $company_block.find("[name='address']").val();

            $.ajax({
                url: 'company/add_company.php',
                data: {
                    name: name,
                    chief: chief,
                    address: address,
                },
            }).done(function (data) {
                $("[name='companies-list']").prepend(
                    `<div name="company-block">
                    <label>Company id: ${data}</label><br/>
                    <label>Company name:</label><br/>
                    <input type="text" name="name"  value="${name}"><br/>

                    <label>Company chief:</label><br/>
                    <input type="text" name="chief" value="${chief}"><br/>

                    <label>Company address:</label><br/>
                    <input type="text" name="address" value="${address}"><br/>

                    <button data-id="${data}" name="update-company-btn" type="button">
                        Update
                    </button>

                    <button data-id="${data}" name="remove-company-btn" type="button">
                        Remove
                    </button><br/><br/>
                        </div>`);
                alert("added successful");
            }).fail(function () {
                alert("error with adding: ");
            });
        }

        function _updateCompany() {
            let $btn = $(this);
            let $company_block = $btn.closest("[name='company-block']");

            let id = $btn.attr("data-id");
            let name = $company_block.find("[name='name']").val();
            let chief = $company_block.find("[name='chief']").val();
            let address = $company_block.find("[name='address']").val();

            $.ajax({
                url: 'company/update_company.php',
                data: {
                    id: id,
                    name: name,
                    chief: chief,
                    address: address,
                },
            }).done(function () {
                alert("updated successful");
            }).fail(function () {
                alert("error with adding: ");
            });
        }

        function _removeCompany() {
            let $btn = $(this);
            let $company_block = $btn.closest("[name='company-block']");
            let id = $btn.attr("data-id");

            $.ajax({
                url: 'company/remove_company.php',
                data: {
                    id: id,
                },
            }).done(function () {
                $company_block.remove();
                alert("removed successful");
            }).fail(function () {
                alert("error with removing: ");
            });
        }
    }
);