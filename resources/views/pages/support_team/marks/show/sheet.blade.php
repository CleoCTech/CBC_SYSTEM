@php
    $ca1Header = request('ca1', $markSetup->ca1);
    $ca2Header = request('ca2', $markSetup->ca2);
    $examsHeader = request('exams', $markSetup->exam);
    $headerFilled = is_numeric($ca1Header) && is_numeric($ca2Header) && is_numeric($examsHeader);
    $scaled = [0, 0, 0];
    if ($headerFilled && ($ca1Header + $ca2Header + $examsHeader) > 0) {
        $sum = $ca1Header + $ca2Header + $examsHeader;
        $scaled[0] = round(($ca1Header / $sum) * 100);
        $scaled[1] = round(($ca2Header / $sum) * 100);
        $scaled[2] = round(($examsHeader / $sum) * 100);
    }
    $totalHeader = $headerFilled ? array_sum($scaled) : '';
@endphp
<table class="table table-bordered table-responsive text-center">
    <thead>
    <tr>
        <th rowspan="2">S/N</th>
        <th rowspan="2">SUBJECTS</th>
        <th rowspan="2">CA1<br><input type="number" id="ca1Max" value="{{ $ca1Header }}" min="1" class="header-input"></th>
        <th rowspan="2">CA2<br><input type="number" id="ca2Max" value="{{ $ca2Header }}" min="1" class="header-input"></th>
        <th rowspan="2">EXAMS<br><input type="number" id="examsMax" value="{{ $examsHeader }}" min="1" class="header-input"></th>
        <th rowspan="2">TOTAL<br><input type="text" id="totalMax" value="{{ $totalHeader }}" class="header-input" readonly></th>
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
<div id="scaledBreakdown" style="font-size:12px; margin-bottom:10px; color:#555; text-align:left;">
    @if($headerFilled && ($ca1Header + $ca2Header + $examsHeader) > 0)
        <strong>Scaled (out of 100):</strong> CA1: <span id="scaledCA1">{{ $scaled[0] }}</span>, CA2: <span id="scaledCA2">{{ $scaled[1] }}</span>, Exams: <span id="scaledExams">{{ $scaled[2] }}</span>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function scaleTo100(ca1, ca2, exams) {
            const sum = ca1 + ca2 + exams;
            if (sum === 0) return [0, 0, 0];
            return [
                Math.round((ca1 / sum) * 100),
                Math.round((ca2 / sum) * 100),
                Math.round((exams / sum) * 100)
            ];
        }
        function updateHeaderTotal() {
            const ca1 = parseFloat(document.getElementById('ca1Max').value);
            const ca2 = parseFloat(document.getElementById('ca2Max').value);
            const exams = parseFloat(document.getElementById('examsMax').value);
            const totalInput = document.getElementById('totalMax');
            const breakdown = document.getElementById('scaledBreakdown');
            if (!isNaN(ca1) && !isNaN(ca2) && !isNaN(exams) && (ca1 + ca2 + exams) > 0) {
                const scaled = scaleTo100(ca1, ca2, exams);
                totalInput.value = scaled[0] + scaled[1] + scaled[2];
                breakdown.innerHTML = `<strong>Scaled (out of 100):</strong> CA1: <span id='scaledCA1'>${scaled[0]}</span>, CA2: <span id='scaledCA2'>${scaled[1]}</span>, Exams: <span id='scaledExams'>${scaled[2]}</span>`;
            } else {
                totalInput.value = '';
                breakdown.innerHTML = '';
            }
        }
        document.getElementById('ca1Max').addEventListener('input', updateHeaderTotal);
        document.getElementById('ca2Max').addEventListener('input', updateHeaderTotal);
        document.getElementById('examsMax').addEventListener('input', updateHeaderTotal);
    });
</script>
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
