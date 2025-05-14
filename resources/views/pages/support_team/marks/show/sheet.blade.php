<table class="table table-bordered table-responsive text-center">
    <thead>
    <tr>
        <th rowspan="2">S/N</th>
        <th rowspan="2">SUBJECTS</th>
        <th rowspan="2">CA1<br><input type="number" id="ca1Max" value="{{ $markSetup->ca1 }}" min="1" class="header-input"></th>
        <th rowspan="2">CA2<br><input type="number" id="ca2Max" value="{{ $markSetup->ca2 }}" min="1" class="header-input"></th>
        <th rowspan="2">EXAMS<br><input type="number" id="examsMax" value="{{ $markSetup->exam }}" min="1" class="header-input"></th>
        <th rowspan="2">TOTAL<br><input type="number" id="totalMax" value="{{ $markSetup->total }}" min="1" class="header-input" readonly></th>
        <th rowspan="2">GRADE</th>
        {{-- <th rowspan="2">SUBJECT <br> POSITION</th> --}}
        <th rowspan="2">REMARKS</th>
    </tr>
    </thead>

    <tbody>
    @foreach($subjects as $sub)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sub->name }}</td>
            @foreach($marks->where('subject_id', $sub->id)->where('exam_id', $ex->id) as $mk)
                <td>{{ ($mk->t1) ?: '-' }}</td>
                <td>{{ ($mk->t2) ?: '-' }}</td>
                <td>{{ ($mk->exm) ?: '-' }}</td>
                <td>
                    @if($ex->term === 1) {{ ($mk->tex1) }}
                    @elseif ($ex->term === 2) {{ ($mk->tex2) }}
                    @elseif ($ex->term === 3) {{ ($mk->tex3) }}
                    @else {{ '-' }}
                    @endif
                </td>

                {{--3rd Term--}}
                {{-- @if($ex->term == 3)
                     <td>{{ $mk->tex3 ?: '-' }}</td>
                     <td>{{ Mk::getSubTotalTerm($student_id, $sub->id, 1, $mk->my_class_id, $year) }}</td>
                     <td>{{ Mk::getSubTotalTerm($student_id, $sub->id, 2, $mk->my_class_id, $year) }}</td>
                     <td>{{ $mk->cum ?: '-' }}</td>
                     <td>{{ $mk->cum_ave ?: '-' }}</td>
                 @endif--}}

                {{--Grade, Subject Position & Remarks--}}
                <td>{{ ($mk->grade) ? $mk->grade->name : '-' }}</td>
                {{-- <td>{!! ($mk->grade) ? Mk::getSuffix($mk->sub_pos) : '-' !!}</td> --}}
                <td>{{ ($mk->grade) ? $mk->grade->remark : '-' }}</td>
            @endforeach
        </tr>
    @endforeach
    @php
        $finalAverage = $exr->ave; // Replace with your actual final average
        $gradeInfo = app(\App\Http\Controllers\SupportTeam\MarkController::class)->calculateGrade($finalAverage);
    @endphp
    <tr>
        <td colspan="4"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exr->total }}</td>
        <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exr->ave }} - {{ $gradeInfo['remark'] }}</td>
        <td colspan="2"><strong>CLASS AVERAGE: </strong> {{ $exr->class_ave }}</td>
    </tr>
    </tbody>
</table>
<style>
    /* Style for header input fields */
    .header-input {
        width: 50px; /* Adjust the width as needed */
        padding: 2px; /* Reduce padding to make it smaller */
        font-size: 12px; /* Adjust font size to match table data */
        text-align: center; /* Center the text */
        border: 1px solid #ccc; /* Add a border for better visibility */
        border-radius: 3px; /* Optional: Add slight rounding to corners */
    }

    /* Optional: Ensure the table headers and data align properly */
    th, td {
        text-align: center;
        vertical-align: middle;
    }
</style>
