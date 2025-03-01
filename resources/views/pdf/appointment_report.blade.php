<!DOCTYPE html>
<html>

<head>
    <title>Appointment Report - {{ $appointmentData->id }}</title>
    <style>
        html {
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .my_table table {
            border-collapse: collapse;
            border: 2px solid rgb(200, 200, 200);
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        .my_table table,
        .my_table td,
        .my_table th {
            border: 1px solid rgb(190, 190, 190);
            padding: 10px 20px;
            text-align: center;
        }

        .my_table th {
            background-color: rgb(235, 235, 235);
        }

        .my_table tr:nth-child(even) td {
            background-color: rgb(250, 250, 250);
        }

        .my_table tr:nth-child(odd) td {
            background-color: rgb(245, 245, 245);
        }

        caption {
            padding: 10px;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
        }

        h2 {
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
<table style="width:100%;">
    <tr>
        @if(isset($display_logo->value) && $display_logo->value == 'yes' && isset($company->logo) && !empty(@$company->logo))
            <td style="width:25%">
                <img style="width: 120px;height: auto;" src="{{public_path(@$company->logo)}}">
            </td>
        @endif
        <td colspan="2" style="text-align: center;">
            <h2>@isset($company->company_name) {{ @$company->company_name }} @else {{ __('ECOM') }} @endisset</h2>
            @isset($company->company_address) {{ $company->company_address }}<br> @else {{ __('Mauritius') }}<br> @endisset
            @isset($company->brn_number) BRN: {{ $company->brn_number }} @endisset @if(isset($company->vat_number) && isset($company->brn_number)) | @endisset @isset($company->vat_number) VAT: {{ $company->vat_number }} @endisset @if(isset($company->vat_number) || isset($company->brn_number)) <br> @endisset
            @isset($company->company_address) Email: {{ $company->company_email }} @else Email: {{ __('noreply@ecom.mu') }} @endisset | @isset($company->company_phone) Phone: {{ $company->company_phone }} @endisset @isset($company->company_fax) | Fax: {{ $company->company_fax }} @endisset <br>
        </td>
    </tr>
</table>

<table style="width:100%">
    <tr>
        <td>
            <br><b>Appointment To:</b><br>
            {{$appointmentData->patient_firstname}} {{$appointmentData->patient_lastname}}<br>
            @if(!empty($appointmentData->consultation_place_address)) {{$appointmentData->consultation_place_address}}<br> @endif
            @if(!empty($appointmentData->patient_city)) {{$appointmentData->patient_city}}<br> @endif
            @if(!empty($appointmentData->patient_email)) {{$appointmentData->patient_email}}<br> @endif
            @if(!empty($appointmentData->patient_phone)) {{$appointmentData->patient_phone}}<br> @endif
        </td>
        <td style="width:100px"></td>
        <td style="text-align:right">
            <br><b>Appointment Information:</b><br>
            <br>Appointment Date: {{ @$appointmentData->appointment_date_time_display??'' }}
            <br>Consultation Start Time: {{ \Carbon\Carbon::parse($appointmentData->consultation_start_time)->format('d/m/Y g:i A') }}
            <br>Consultation End Time: {{ \Carbon\Carbon::parse($appointmentData->consultation_end_time)->format('d/m/Y g:i A') }}
            <br>Doctor Name: {{ $appointmentData->display_doctor_name??'' }}
        </td>
    </tr>
</table>

<h3><div style="text-align:center">Medical Report</div></h3>

<!-- Presenting Complaints Section -->
@if($presentingComplaints)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>Presenting Complaints</b></caption>
            <tr>
                <th>Complaints</th>
            </tr>
            <tr>
                <td>{{ $presentingComplaints->compliant_text }}</td>
            </tr>
        </table>
    </div>
@endif
<!-- Vitals Section -->
@if($vital)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>Vitals</b></caption>
            <tr>
                <th>Height</th>
                <th>Weight</th>
                <th>Abd. Circumference</th>
                <th>BMI</th>
                <th>Pulse</th>
                <th>Blood Pressure</th>
                <th>Blood Sugar</th>
            </tr>
            <tr>
                <td>{{ $vital->height }} cm</td>
                <td>{{ $vital->weight }} kg</td>
                <td>{{ $vital->circumference }} cm</td>
                <td>{{ $vital->bmi }}</td>
                <td>{{ $vital->pulse }} bpm</td>
                <td>{{ $vital->sys_blood_pressure }}/{{ $vital->dia_blood_pressure }} mmHg</td>
                <td>{{ $vital->blood_sugar }} mmol/L</td>
            </tr>
        </table>
    </div>
@endif
<!-- Physical Examination Section -->
@if($physicalExamination)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>Physical Examination</b></caption>
            <tr>
                <th>Pickle Comments</th>
                <th>CVS Comments</th>
                <th>RS Comments</th>
                <th>CNS Comments</th>
            </tr>
            <tr>
                <td>{{ $physicalExamination->e_comments }}</td>
                <td>{{ $physicalExamination->cvs_comments }}</td>
                <td>{{ $physicalExamination->rs_comments }}</td>
                <td>{{ $physicalExamination->cns_comments }}</td>
            </tr>
        </table>
    </div>
@endif
<!-- Diagnosis Section -->
@if($diagnosisData)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>Diagnosis</b></caption>
            <tr>
                <th>Provisional Diagnosis</th>
                <th>Diagnosis</th>
            </tr>
            @php
                $provisional_diagnosis = json_decode($diagnosisData->provisional_diagnosis, true);
                $diagnosis = json_decode($diagnosisData->diagnosis, true);
            @endphp
            @if(!empty($provisional_diagnosis))
                @foreach($provisional_diagnosis as $prov)
                    <tr>
                        <td>{{ $prov }}</td>
                        @if($loop->first)
                            <td rowspan="{{ count($provisional_diagnosis) }}">
                                <table style="width: 100%;">
                                    <tr>
                                        <th>Diagnosis</th>
                                    </tr>
                                    @foreach($diagnosis as $diag)
                                        <tr>
                                            <td>{{ $diag }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </table>
    </div>
@endif

<!-- Medical Advice Section -->
@if($medicalAdvice)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>Medical Advice</b></caption>
            <tr>
                <th>Prescription</th>
                <th>Procedure</th>
            </tr>
            <tr>
                <td>{{ $medicalAdvice->prescription }}</td>
                <td>{{ $medicalAdvice->procedure }}</td>
            </tr>
        </table>
    </div>
@endif
<!-- Med-Vigilance Section -->
@if($medvigilance)
    <div class="my_table">
        <table style="width:100%">
            <caption><b>MedVigilance</b></caption>
            <tr>
                <th>Investigations</th>
                <th>Radiology</th>
                <th>Equipment</th>
                <th>Comments</th>
            </tr>
            <tr>
                <td>{{ $medvigilance->investigations }}</td>
                <td>{{ $medvigilance->radiology }}</td>
                <td>{{ $medvigilance->equipment }}</td>
                <td>{{ $medvigilance->medvigilance }}</td>
            </tr>
        </table>
    </div>
@endif
</body>

</html>
