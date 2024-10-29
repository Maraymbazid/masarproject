<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>
    <div class="pd-ltr-20">
        <div class="pd-20 card-box mb-30">
            <form id="filter-form" method="POST" action="{{ route('notes.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group @error('ppr') form-group has-danger @enderror">
                            <label>Etablissement</label>
                            <input type="text" class="form-control" value="ibn-tomert" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group @error('ppr') form-group has-danger @enderror">
                            <label>Province</label>
                            <input type="text" class="form-control" value="Tarfaya" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group @error('ppr') form-group has-danger @enderror">
                            <label>Subject</label>
                            <input type="text" class="form-control" value="Informatique" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group @error('ppr') form-group has-danger @enderror">
                            <label>Class</label>

                            <select class="form-control" name="class_name" id="class_name">
                                @foreach ($classes as $class)
                                    <option value="{{ $class }}">{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <button class="btn btn-primary" id="submit-button" type="submit">Add</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="student-table-container" class="pd-20 card-box mb-30" style="display: none;">
        </div>
    </div>

    @vite('resources/js/app.js')
    @livewireScripts

    <!-- Your custom script must come AFTER Livewire scripts -->
    <script>
        const form = document.getElementById('filter-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            console.log('Form submission intercepted');
            var className = document.getElementById('class_name').value;

            // Perform the AJAX request
            fetch("{{ route('notes.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        class_name: className,
                    })
                })
                .then(response => response.json()) // Make sure to parse the response as JSON
                .then(data => {
                    if (data.success) {
                        console.log('Class Name:', className);
                        // Inject Livewire component into the container
                        const container = document.getElementById('student-table-container');

                        // Inject Livewire component with class name passed as a prop
                        container.innerHTML =
                            `<livewire:student-table :className="'${className}'" />`;

                        // Reinitialize Livewire so it recognizes the new component
                        Livewire.restart(); // Reinitialize Livewire
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    </script>

</body>

</html>
