<form class="ajax-update" action="{{ route('marks.update', [$exam_id, $my_class_id, $subject_id]) }}" method="post">
    @csrf @method('put')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>ADM_NO</th>
            <th>
                1ST CAT (<input type="number" id="firstCatMax" value="20" min="1" class="max-input header-input">)
            </th>
            <th>
                2ND CAT (<input type="number" id="secondCatMax" value="20" min="1" class="max-input header-input">)
            </th>
            <th>
                EXAM (<input type="number" id="examMax" value="60" min="1" class="max-input header-input">)
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($marks->sortBy('user.name') as $mk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                {{-- <td>{{ $mk->user->name }} - {{ $mk->user->student_record->my_class_id }} </td> --}}
                <td>{{ $mk->user->name }} </td>
                <td>{{ $mk->user->student_record->adm_no }}</td>
               {{-- CA AND EXAMS --}}
            <td>
                <input title="1ST CAT" min="1" max="20" class="text-center first-cat" name="t1_{{ $mk->id }}" value="{{ $mk->t1 }}" type="number">
            </td>
            <td>
                <input title="2ND CAT" min="1" max="20" class="text-center second-cat" name="t2_{{ $mk->id }}" value="{{ $mk->t2 }}" type="number">
            </td>
            <td>
                <input title="EXAM" min="1" max="60" class="text-center exam" name="exm_{{ $mk->id }}" value="{{ $mk->exm }}" type="number">
            </td>

            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="text-center mt-2">
        <button type="submit" class="btn btn-primary">Update Marks <i class="icon-paperplane ml-2"></i></button>
    </div>
</form>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to update max attributes
        function updateMaxValues() {
            const firstCatMax = $('#firstCatMax').val();
            const secondCatMax = $('#secondCatMax').val();
            const examMax = $('#examMax').val();

            // Update max attributes for all corresponding inputs
            $('.first-cat').attr('max', firstCatMax);
            $('.second-cat').attr('max', secondCatMax);
            $('.exam').attr('max', examMax);
        }

        // Attach event listeners to the header inputs
        $('.max-input').on('input', function() {
            updateMaxValues();
        });

        // Initialize max values on page load
        updateMaxValues();
    });
</script>