<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>VAT Calculator</title>
        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{URL::asset('css/default.css') }}"/>
        <link rel="stylesheet" href="{{URL::asset('css/custom.css') }}"/>
        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/vat.js') }}" defer></script>
    </head>
    <body class="antialiased">
        <div class="relative sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="justify-center text-center intro">
                <h1>Vat Calculator</h1>
                <p>Built proudly using the Laravel framework (Which uses Symfony as a vendor).</p>
                <div class="p-2 flex-shrink-0 bd-highlight">
                    <button class="btn btn-success" id="btn-add">Add new VAT Calculation</button>
                    <a href="/download">
                        <button class="btn btn-warning" id="btn-download">Download as CSV</button>
                    </a>
                    <button class="btn btn-danger" id="btn-delete">Clear table</button>
                </div>
            </div>
            <div class="mt-16">
                <div class="grid grid-cols-1 gap-6 lg:gap-8 text-center">
                    <h3>Historical Calculations</h3>
                    <table class="vat table justify-center table-inverse">
                        <thead>
                            <tr>
                                <th>Original Value</th>
                                <th>Percentage</th>
                                <th>Is VAT Included?</th>
                                <th>With VAT Excluded</th>
                                <th>With VAT Included</th>
                                <th>VAT Cost</th>
                            </tr>
                        </thead>
                        <tbody id="grid">
                            @foreach ($vatCalculator as $data)
                                <tr id="calculation-{{$data->entity_id}}">
                                    <td>£{{$data->value}}</td>
                                    <td>{{$data->percentage}}%</td>
                                    <td>{{$data->included ? "Yes" : "No"}}</td>
                                    <td>{{$data->included ? getExcludingVat($data->value,$data->percentage, true) : ''}}</td>
                                    <td>{{$data->included ? '' : getIncludingVat($data->value,$data->percentage, true)}}</td>
                                    <td>£{{getVatTotal($data->value,$data->percentage, $data->included)}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="formModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="formModalLabel">Create new Vat calculation</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="vatForm" name="vatForm" class="form-horizontal" novalidate="">
                                        <div class="form-group">
                                            <p>VAT Included?</p>
                                            <label class="switch">
                                                <input type="checkbox" checked id="included" name="included">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="value">Monetary Value</label>
                                            <input type="number" required class="form-control" id="value" name="value" placeholder="Monetary Value" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="percentage">VAT Percentage</label>
                                            <input type="number" min="1" max="100" required class="form-control" id="percentage" name="percentage" placeholder="Vat Percentage" value="">
                                            <p>(Percent must be between 0.01 and 100.</p>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Add VAT Rate</button>
                                    <input type="hidden" id="vat_calculators_entity_id" name="vat_calculators_entity_id" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
