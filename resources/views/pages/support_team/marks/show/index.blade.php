@extends('layouts.master')
@section('page_title', 'Student Marksheet')
@section('content')

    <div class="card">
        <div class="card-header text-center">
            <h4 class="card-title font-weight-bold">Student Marksheet for =>  {{ $sr->user->name.' ('.$my_class->name.' '.$my_class->section->first()->name.')' }} </h4>
        </div>
    </div>

    @foreach($exams as $ex)
        @foreach($exam_records->where('exam_id', $ex->id) as $exr)

                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="font-weight-medium">{{ $ex->name.' - '.$ex->year }}</h6>
                        {!! Qs::getPanelOptions() !!}
                    </div>

                    <div class="card-body collapse">

                        {{--Sheet Table--}}
                        @include('pages.support_team.marks.show.sheet')

                       <!-- Print Button -->
                    <div class="text-center mt-3">
                        <button id="printMarksheetBtn" data-print-url="{{ route('marks.print', [Qs::hash($student_id), $ex->id, $year]) }}" class="btn btn-secondary btn-lg">Print Marksheet <i class="icon-printer ml-2"></i></button>
                    </div>

                    </div>

                </div>

            {{--    EXAM COMMENTS   --}}
            @include('pages.support_team.marks.show.comments')

            {{-- SKILL RATING --}}
            @include('pages.support_team.marks.show.skills')

        @endforeach
    @endforeach

@endsection
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const printButton = document.getElementById('printMarksheetBtn');

        if (printButton) {
            console.log('Button found!'); // Debugging: Check if the button exists

            printButton.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent default behavior
                console.log('Button clicked!'); // Debugging: Check if the event is triggered

                // Get the updated values from the input fields
                const ca1 = document.getElementById('ca1Max').value;
                const ca2 = document.getElementById('ca2Max').value;
                const exams = document.getElementById('examsMax').value;

                // Validate that the total is 100
                const total = parseInt(ca1) + parseInt(ca2) + parseInt(exams);
                if (total !== 100) {
                    alert('The sum of CA1, CA2, and EXAMS must be 100.');
                    return;
                }

                // Send the data to the server using Axios
                axios.post('{{ route("marks.updateSetup") }}', {
                    ca1: ca1,
                    ca2: ca2,
                    exams: exams,
                    total: total,
                })
                .then(function (response) {
                    // If the update is successful, navigate to the print URL
                    if (response.data.success) {
                        const printUrl = printButton.dataset.printUrl;
                        window.open(printUrl, '_blank');
                    } else {
                        alert('Failed to update marks setup.');
                    }
                })
                .catch(function (error) {
                    console.error(error);
                    alert('An error occurred while updating marks setup.');
                });
            });
        } else {
            console.error('Print button not found!'); // Debugging: Check if the button exists
        }
    });
</script>