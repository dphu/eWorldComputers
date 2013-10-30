<style>
    div.felement {
        margin:3%;
        border: none;
        height: auto;
        width: auto;
        float: left;
    }   
    div.filter div{
        diplay:inline;
        width:200px;
        height:auto;
        padding: 15px;
        margin: 20px;
        border:1px solid black;
        /*background-color:#ff0000;*/
        -moz-border-radius:25px; /* Firefox */
        border-radius:25px;
    }  
    div.filter{
        margin-left:auto;
        margin-right:auto;;
    }  


    fieldset {
        border:2px black;
    }
    service_form{
        margine-left:auto;
        margine-right:auto;
        padding-left:50px; 
        padding-right:50px;
    }
    fieldset{
        float:left;
        border: 1px solid #000;
        margin-left:50px;
        margin-right:50px;
        -moz-border-radius:25px; /* Firefox */
        border-radius:25px;
    }
</style>

<form class="service_form">
    <p id="l">V138</p>
    <div class="filter" >
        <div class="felement">
            <label> Users: </label>
            <select id="cusfilter">
                <option value="Name" >Name</option>
                <option value="Email">Email</option>
                <option value="Phone">Phone Number</option>
            </select>
            <select size="7" id="user" >
            </select>
            <label>Search:</label>
            <input size="10" type="text" name="filter" id="filter" />
        </div>
        <div class="felement">
            <label> Service: </label>  
            <select id="servfilter">
                <option value="All" >All</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <select size="7" id="service" >
            </select>
            <button type="button" id='add'>Add</button>
            <button type="button" id='update'>Update</button>
            <button type="button" id='remove'>Remove</button>
        </div>
    </div>
    <div>
        <fieldset>
            <legend>Service Information</legend>
            <div class="felement">
                <label>Service ID:</label>
                <input type="text" name="id" id="id" readonly="true"/>
            </div>
            <div class="felement">
                <label>Item:</label>
                <input type="text" name="item" id="item" />
            </div>
            <div class="felement">
                <label>Service Type:</label>
                <input type="text" name="sertype" id="sertype" />
            </div>
            <div class="felement">
                <label>Status:</label>

                <select id="status">
                    <option value="Pending Service" >Pending Service</option>
                    <option value="Being Serviced">Being Serviced</option>
                    <option value="Ready for Pickup">Ready for Pickup</option>
                </select>

            </div>
            <div class="felement">
                <label>In date:</label>
                <button type="button" id='itime'>Today</button>
                <input type="date" name="idate" id="idate" />
            </div>
            <div class="felement">
                <label>Out date:</label>
                <button type="button" id='otime'>Today</button>
                <input type="date" name="odate" id="odate" />
            </div>
            <div class="felement">
                <label>In Condition:</label>
                <textarea cols="25" rows="5" id="icondition"> </textarea>
            </div>
            <div class="felement">
                <label>Out Condition:</label>
                <textarea cols="25" rows="5" id="ocondition"> </textarea>
            </div>
        </fieldset>
    </div>
    <!--<button type="button" id='add'>Add New User</button> !-->
</form>
<script>
    var customer;
    var service;
    function getCustomers() {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url() . 'main/ajax_get_customers/' ?>',
            dataType: 'json',
            async: false,
            success: function(data) {
                console.log(data);
                //alert("success");
                customer = data;
                listCustomers();
                //customer=jQuery.parseJSON(JSON.stringify(data));
                //customer = JSON.parse(data).split(",");
                //alert(JSON.stringify(data));    
            },
            error: function(response)
            {
                console.log(response);
                alert("Failed to get cutomer list");
            }
        });
        return 0;
    }
    $(function() {
        $('#filter').keyup(function() {
            listCustomers($('#filter').val());
        });
    });
    function listCustomers() {
        filter = $('#filter').val();
        search = false;
        if (filter !== "" || filter !== null) {
            search = true;
        }
        dispay = true;
        listType = $('#cusfilter').val();
        selectedValue = $('#user').find(":selected").val();
        $('#user').empty();
        $.each(customer, function(index, value) {
            display = false;
            switch (listType) {
                case 'Name':
                    firstN = customer[index]['fname'];
                    lastN = customer[index]['lname'];
                    result2 = lastN + " " + firstN;
                    result = firstN + " " + lastN;
                    if (search && (firstN.toLowerCase().substring(0, filter.length) === filter.toLowerCase()
                        || lastN.toLowerCase().substring(0, filter.length) === filter.toLowerCase() || result.toLowerCase().substring(0, filter.length) === filter.toLowerCase() || result2.toLowerCase().substring(0, filter.length) === filter.toLowerCase())) {
                        display = true;
                    }
                    break;
                case 'Email':
                    result = customer[index]['email'];
                    if (search && (result.toLowerCase().substring(0, filter.length) === filter.toLowerCase()
                )) {
                        display = true;
                    }
                    break;
                case 'Phone':
                    result = customer[index]['phone'];
                    if (search && (result.toLowerCase().substring(0, filter.length) === filter.toLowerCase()
                )) {
                        display = true;
                    }

                    result = "(" + result.substring(0, 3) + ") " + result.substring(3, 6) + " - " + result.substring(6, 15);
                    break;
            }
            if (display === true)
                $('#user').append("<option value='" + customer[index]['id'] + "'>" + result + "</option>");

        });

        $('#user').val(selectedValue);

    }
    function getServices() {
        $.ajax({
            type: 'post',
            url: '<?php echo base_url() . 'main/ajax_get_services/' ?>',
            dataType: 'json',
            async: false,
            success: function(data) {
                console.log(data);
                // alert("success");
                service = data;
                console.log(service);
                //customer=jQuery.parseJSON(JSON.stringify(data));
                //customer = JSON.parse(data).split(",");
                //alert(JSON.stringify(data));    
            },
            error: function(response)
            {
                console.log(response);
                alert("Failed to get service list");
            }
        });
    }
    $(document).ready(function() {
        getServices();
        getCustomers();
        $("#cusfilter option[value='Name']").attr("selected", "selected");
        $("#servfilter option[value='All']").attr("selected", "selected");
        $('#status').val("");
        $('#id').css('background-color', '#dddddd');
        $('#odate').attr('readonly', true).css('background-color', '#dddddd');
        $('#idate').attr('readonly', true).css('background-color', '#dddddd');
        $('#ocondition').attr('readonly', true).css('background-color', '#dddddd');
        $('#otime').attr('disabled', true).fadeTo(0, 0.5);
        $('#itime').attr('disabled', true).fadeTo(0, 0.5);
        $('#add').attr('disabled', true).fadeTo(0, 0.5);
        $('#remove').attr('disabled', true).fadeTo(0, 0.5);
        $('#update').attr('disabled', true).fadeTo(0, 0.5);
    });

    $(function() {
        $('#update').click(function() {
            if (reqfield()) {
                var data = {
                    'id': $('#id').val(),
                    'cus_id': $('#user').find(":selected").val(),
                    'item': $('#item').val(),
                    'sertype': $('#sertype').val(),
                    'status': $('#status').val(),
                    'idate': $('#idate').val(),
                    'odate': $('#odate').val(),
                    'icondition': $('#icondition').val(),
                    'ocondition': $('#ocondition').val()
                };
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'main/ajax_update_service_item/' ?>',
                    dataType: 'json',
                    async: false,
                    data: data,
                    success: function(response)
                    {
                        //console.log(response);
                        //alert("Success");
                        //delete service;
                        //$('*').removeAttr('selected');
                        //$('#user').val(data['cus_id']);
                        getServices();
                        $('#service').empty();
                        listServiceItems(data['cus_id']);
                        $('#service').val(data['id']);
                        loadDataToFields(data['id']);
                       
                        //loadDataToFields(data['id']);



                        // $('#service option[value='+data['id']+']').attr("selected", true);

                    },
                    error: function(response)
                    {
                        console.log(response);
                        alert("Action Failed");
                    }
                });
            }
            else {
                alert("Fill in required fields.");
            }
        });
    });
    $(function() {
        $('#add').click(function() {
            if (reqfield()) {
                var data = {
                    'cus_id': $('#user').find(":selected").val(),
                    'item': $('#item').val(),
                    'sertype': $('#sertype').val(),
                    'status': $('#status').val(),
                    'idate': $('#idate').val(),
                    'odate': $('#odate').val(),
                    'icondition': $('#icondition').val(),
                    'ocondition': $('#ocondition').val()
                };
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'main/ajax_add_service_item/' ?>',
                    dataType: 'json',
                    async: false,
                    data: data,
                    success: function(response)
                    {
                        console.log(response);
                        //alert("Success");
                        delete service;
                        getServices();
                        $('#service').empty();
                        listServiceItems($('#user').find(":selected").val());

                    },
                    error: function(response)
                    {
                        console.log(response);
                        alert("Action Failed");
                    }
                });

            }
            else {
                alert("fill in required fields.");

            }
        });
    });
    $(function() {
        $('#remove').click(function() {
            if (reqfield()) {
                var data = {
                    'id': $('#service').find(":selected").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'main/ajax_remove_service_item/' ?>',
                    dataType: 'json',
                    async: false,
                    data: data,
                    success: function(response)
                    {
                        console.log(response);
                        delete service;
                        cus_id = $('#user').find(":selected").val();
                        $('*').removeAttr('selected');
                        $('#user').val(cus_id);
                        getServices();
                        $('#service').empty();
                        listServiceItems(cus_id);
                        $('#service').val(data['id']);
                        emptyFields();
                    },
                    error: function(response)
                    {
                        console.log(response);
                        alert("Action Failed");
                    }
                });

            }
            else {
                alert("Fill in required fields.");

            }
        });
    });

    function todayDate() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        var todayDate = yyyy + "-" + mm + "-" + dd;
        return todayDate;
    }
    $(function() {
        $('#itime').click(function() {
            $('#idate').val(todayDate());
        });
    });
    $(function() {
        $('#otime').click(function() {
            $('#odate').val(todayDate());
        });
    });
    function filterService(index) {

        filter = $('#servfilter').find(":selected").val();
        console.log(filter);
        if (filter === 'All') {
            return true;
        }
        else if (filter === 'Active' && service[index]['odate'] === '0000-00-00') {
            return true;
        }
        else if (filter === 'Inactive' && service[index]['odate'] !== '0000-00-00') {
            return true;
        }
        return false;


    }
    function listServiceItems(selectedValue) {

        $.each(service, function(index, value) {
            if (selectedValue === service[index]['cus_id'] && filterService(index)) {
                console.log("filter:" + filterService(index));

                $('#service').append("<option value='" + service[index]['id'] + "'>" + service[index]['item'] + "</option>");

            }
        });
    }
    $(function() {
        $('#servfilter').change(function() {
            var selectedValue = $('#user').find(":selected").val();
            $('#service').empty();
            emptyFields();
            listServiceItems(selectedValue);
        });

    });
    $(function() {
        $('#user').change(function() {
            var selectedValue = $(this).find(":selected").val();
            $('#service').empty();
            emptyFields();
            listServiceItems(selectedValue);
        });

    });
    $(function() {
        $('#cusfilter').change(function() {
            var selectedValue = $('#user').val();
            console.log(selectedValue);
            $('#user').empty();
            $('#filter').val("");
            listCustomers();
            $('#user').val(selectedValue);
        });

    });
    $(function() {
        $('#user').focusin(function() {
            $('#service').find(":selected").removeAttr("selected");
            emptyFields();
            $('#add').attr('disabled', false).fadeTo(0, 1);
            $('#remove').attr('disabled', true).fadeTo(0, 0.5);
            $('#update').attr('disabled', true).fadeTo(0, 0.5);
            $('#otime').attr('disabled', true).fadeTo(0, 0.5);
            $('#itime').attr('disabled', false).fadeTo(0, 1);
            $('#odate').attr('readonly', true).css('background-color', '#dddddd');
            $('#idate').attr('readonly', false).css('background-color', '#ffffff');
            $('#ocondition').attr('readonly', true).css('background-color', '#dddddd');
        });
    });
    $(function() {
        $('#user').focusout(function() {
            $('#service').find(":selected").removeAttr("selected");
            emptyFields();
            $('#add').attr('disabled', false).fadeTo(0, 1);
            $('#remove').attr('disabled', true).fadeTo(0, 0.5);
            $('#update').attr('disabled', true).fadeTo(0, 0.5);
            $('#otime').attr('disabled', true).fadeTo(0, 0.5);
            $('#itime').attr('disabled', false).fadeTo(0, 1);           
            $('#odate').attr('readonly', true).css('background-color', '#dddddd');
            $('#idate').attr('readonly', false).css('background-color', '#ffffff');
            $('#ocondition').attr('readonly', true).css('background-color', '#dddddd');
        });
    });/*
    function focusout() {
        $('#otime').attr('disabled', true).fadeTo(0, 0.5);
        $('#itime').attr('disabled', true).fadeTo(0, 0.5);
        $('#add').attr('disabled', true).fadeTo(0, 0.5);
        $('#remove').attr('disabled', true).fadeTo(0, 0.5);
        $('#update').attr('disabled', true).fadeTo(0, 0.5);
        $('*').removeAttr("selected");
    }
    function focusin() {
        if (typeof ($('#service').find(":selected").val()) !== 'undefined') {
            $('#add').attr('disabled', true).fadeTo(0, 0.5);
            $('#remove').attr('disabled', false).fadeTo(0, 1);
            $('#update').attr('disabled', false).fadeTo(0, 1);
            $('#otime').attr('disabled', false).fadeTo(0, 1);
            $('#itime').attr('disabled', false).fadeTo(0, 1);
        }
    }*/
    $(function() {
        $('#service').focus(function() {
            console.log($('#service').find(":selected").val());
            if (typeof ($('#service').find(":selected").val()) !== 'undefined') {
                $('#add').attr('disabled', true).fadeTo(0, 0.5);
                $('#remove').attr('disabled', false).fadeTo(0, 1);
                $('#update').attr('disabled', false).fadeTo(0, 1);
                $('#otime').attr('disabled', false).fadeTo(0, 1);
                $('#itime').attr('disabled', false).fadeTo(0, 1);
                $('#odate').attr('readonly', false).css('background-color', '#ffffff');
                $('#idate').attr('readonly', false).css('background-color', '#ffffff');
                $('#ocondition').attr('readonly', false).css('background-color', '#ffffff');
            }
        });
    });
    function reqfield() {
        var valid = true;
        valid &= ($('#item').val() !== "");
        valid &= ($('#sertype').val() !== "");
        valid &= ($('#status').val() !== "");
        valid &= ($('#idate').val() !== "");
        valid &= ($('#icondition').val() !== "");
        return valid;
    }
    function emptyFields() {
        $('#id').val("");
        $('#item').val("");
        $('#sertype').val("");
        $('#status').val("");
        $('#idate').val("");
        $('#odate').val("");
        $('#icondition').val("");
        $('#ocondition').val("");
    }

    $(function() {
        $('#service').change(function() {
            var selectedValue = $(this).find(":selected").val();
            if (typeof ($('#service').find(":selected").val()) !== 'undefined') {
                $('#add').attr('disabled', true).fadeTo(0, 0.5);
                $('#remove').attr('disabled', false).fadeTo(0, 1);
                $('#update').attr('disabled', false).fadeTo(0, 1);
                $('#otime').attr('disabled', false).fadeTo(0, 1);
                $('#itime').attr('disabled', false).fadeTo(0, 1);
                $('#odate').attr('readonly', false).css('background-color', '#ffffff');
                $('#idate').attr('readonly', false).css('background-color', '#ffffff');
                $('#ocondition').attr('readonly', false).css('background-color', '#ffffff');
            }
            $.each(service, function(index, value) {
                if (service[index]['id'] === selectedValue) {
                    emptyFields();
                    loadDataToFields(index);
                    return 0;
                }
            });

        });

    });
    function loadDataToFields(index) {
        console.log("index: "+index);
   
        console.log("reading property: "+service[index]['item']);
        $('#id').val(service[index]['id']);
        $('#item').val(service[index]['item']);
        $('#sertype').val(service[index]['sertype']);
        $('#status').val(service[index]['status']);
        $('#idate').val(service[index]['idate']);
        $('#odate').val(service[index]['odate']);
        $('#icondition').val(service[index]['icondition']);
        $('#ocondition').val(service[index]['ocondition']);
    }
    function clock() {
        var now = new Date();
        var outStr = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
        setTimeout('clock()', 1000);
    }

</script>

