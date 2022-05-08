@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>Datatable</h2>
                <table id="table_test" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#table_test').DataTable({
            "processing": true,
            data: [{
                    "Id": "1",
                    "Name": "Thomas",
                    "Email": "thomasdc@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                },
                {
                    "Id": "2",
                    "Name": "Tom",
                    "Email": "dctom@gamil.com"
                }
            ],
            columns: [{
                    data: 'Id'
                },
                {
                    data: 'Name'
                },
                {
                    data: 'Email'
                }
            ]
        });
    </script>
@endsection
