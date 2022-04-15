<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Address Book</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <section class="main-container">
            <h2 class="text-center">ADDRESS BOOK</h2>
            <div class="row mb-4 mt-4">
                <div class="form-group col-md-4 m-l-2">
                    <input class="form-control" id="txtSearch" name="txtSearch" placeholder="Search" aria-controls="example1" type="text" />
                </div>
                <div class="col-md-8">
                    <input type="button" class="btn btn-primary create-button" value="Create User" data-bs-toggle="modal" data-bs-target="#createModal" />
                </div>
            </div>
            <table class="table" id="contact-table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone number</th>
                    <th scope="col">View</th>
                  </tr>
                </thead>
                <tbody id="contact-table-body">
                </tbody>
            </table>
        </section>

        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="contact-form" id="contactForm" method="get" action="">
                        <div class="contact-item">
                            <div class="item">
                                <label for="name">Name:</label>
                            </div>
                            <div class="item">
                                <input type="text" name="name">
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="item">
                                <label for="address">Address:</label>
                            </div>
                            <div class="item l-align">
                                <input type="text" name="address">
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="item">
                                <label for="email">Email:</label>
                            </div>
                            <div class="item">
                                <input type="email" name="email">
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="item">
                                <label for="mobile">Phone:</label>
                            </div>
                            <div class="item">
                                <input type="number" maxlength="11" name="mobile">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
            </div>
        </div>


        <!--View Modal-->
        <div class="modal" id="viewModal" tabindex="-1" aria-labelledby="viewModal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Contact Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="$('#viewModal').hide();"></button>
                </div>
                <div class="modal-body container-fluid">
                    <div class="row">
                        <div class="col">Full Name</div>
                        <div class="col" id="contact-name"></div>
                    </div>
                    <div class="row">
                        <div class="col">Address</div>
                        <div class="col"  id="contact-address"></div>
                    </div>
                    <div class="row">
                        <div class="col">Email</div>
                        <div class="col" id="contact-email"></div>
                    </div>
                    <div class="row">
                        <div class="col">Phone</div>
                        <div class="col" id="contact-phone"></div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" onclick="$('#viewModal').hide();" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function(){
                var contacts = [];
                var seletedIndex = [];

                fetchContacts();
                function fetchContacts() {
                    $.ajax({
                        type: "GET",
                        url: "/fetch-contacts",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            bindContactDataTOTable(response.contacts);
                        }
                    });
                }

                var myArray = [
                    {'name':'Michael Wayne', 'address':'Kottayam District', 'email':'Michael@gmail.com','phone':'9633565656'},
                    {'name':'Mila Kunis', 'address':'Kollam District', 'email':'Mila@gmail.com','phone':'96968865656'},
                    {'name':'Paul Dano', 'address':'Alappuzha District', 'email':'Paul@gmail.com','phone':'9696568656'},
                    {'name':'Dennis Williams', 'address':'Kottayam District', 'email':'Dennis@gmail.com','phone':'9696568656'},
                    {'name':'Tim Drake', 'address':'Tvm District', 'email':'Tim@gmail.com','phone':'9696565696'},
                    {'name':'Erik Bana', 'address':'Kottayam District', 'email':'Erik@gmail.com', 'phone':'9696565656'},
                ]

                $('#txtSearch').on('keyup', function() {
                    var value = $(this).val();
                    var data = filterTable(value, myArray);
                    bindContactDataTOTable(data);
                });


                function filterTable(value, data) {
                    var filteredData = [];
                    for (var i=0; i<data.length; i++) {
                        value = value.toLowerCase();
                        var name = data[i].name.toLowerCase();

                        if (name.includes(value)) {
                            filteredData.push(data[i]);
                        }
                    }
                    return filteredData;
                }

                function bindContactDataTOTable(data) {
                    $('#contact-table-body').html('');
                    data.forEach(function(userData, i) {
                        $('#contact-table-body').append(
                            `<tr>
                                <th scope="row">${i+1}</th>
                                <td>${userData.name}</td>
                                <td>${userData.address}</td>
                                <td>${userData.email}</td>
                                <td>${userData.phone}</td>
                                <td>
                                    <button type="button" data="${i}" class="btn btn-primary btn-sm view-btn">View</button>
                                </td>
                            </tr>`
                        )
                    })
                }

                $('.view-btn').on('click', function(){
                    seletedIndex = $(this).attr('data');
                    const userData = myArray[seletedIndex];
                    $('#contact-name').text(userData.name);
                    $('#contact-address').text(userData.address);
                    $('#contact-email').text(userData.email);
                    $('#contact-phone').text(userData.phone);

                    $('#viewModal').modal('show');
                });
            });

            $('#contactForm').validate({ // initialize the plugin
                    rules: {
                        name: {
                            required: true,
                            minlength: 5
                        },
                        address:  {
                            required: true,
                            minlength: 10
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        mobile: {
                            required: true,
                            digits: true,
                            minlength: 8
                        }
                    }, messages: {
                        name: {
                            required: "Please enter a name",
                            minlength: "Minimum length 5"
                        },
                        address: {
                            required: "Please enter your address",
                            minlength: "Minimum length 10"
                        },
                        email: {
                            required: "Please enter an email",
                            email: "Email must be in 'example@email.com' format"
                        },
                        mobile: {
                            required: "Please enter a phone number",
                            digits: "Phone number cannot be characters",
                            minlength: "Minimum length 8"
                        },
                    }
                });
        </script>
    </body>
</html>