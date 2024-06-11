<!DOCTYPE html>
<html>
<head>
    <title>Checksheet PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header-table, .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table th, .header-table td, .detail-table th, .detail-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .header-table th, .detail-table th {
            background-color: #f2f2f2;
        }
        .section-title {
            font-size: 1.2em;
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: left;
            color: #333;
        }
        .card-body {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .tab-content {
            margin-top: 20px;
        }
        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Checksheet Details</h1>
    <table class="header-table">
        <tr>
            <td><strong>Document Number:</strong> {{ $checksheetHead->document_number }}</td>
            <td><strong>Department:</strong> {{ $checksheetHead->department }}</td>
        </tr>
        <tr>
            <td><strong>Machine Name:</strong> {{ $checksheetHead->machine_name }}</td>
            <td><strong>Effective Date:</strong> {{ $checksheetHead->effective_date }}</td>
        </tr>
        <tr>
            <td><strong>Manufacturing Date:</strong> {{ $checksheetHead->manufacturing_date }}</td>
            <td><strong>Planning Date:</strong> {{ $checksheetHead->planning_date }}</td>
        </tr>
        <tr>
            <td><strong>Actual Date:</strong> {{ $checksheetHead->actual_date }}</td>
            <td><strong>PIC:</strong> {{ $checksheetHead->pic }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Remark:</strong> {{ $checksheetHead->remark }}</td>
        </tr>
    </table>

    <div class="card-body">
        <div class="modal-body">
            @php
                $groupedResults = $checksheetDetails->groupBy('checksheet_type');
            @endphp
            <div class="tab-content" id="checksheetTabsContent">
                @foreach ($groupedResults as $checksheetType => $itemsByType)
                    <div class="section-title"><h2>{{ $checksheetType }}</h2></div>
                    <hr>
                    @php
                        $groupedItems = $itemsByType->groupBy('checksheet_category');
                    @endphp
                    @foreach ($groupedItems as $checksheetCategory => $items)
                        <h4>{{ $checksheetCategory }}</h4>
                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Spec</th>
                                        <th>Act</th>
                                        <th>B</th>
                                        <th>R</th>
                                        <th>G</th>
                                        <th>PP</th>
                                        <th>Judge</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->spec }}</td>
                                            <td>{{ $item->act }}</td>
                                            <td>{{ $item->B ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->R ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->G ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->PP ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->judge }}</td>
                                            <td>{{ $item->remarks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($checksheetCategory == 'Preventive Maintenance')
                            <hr>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
