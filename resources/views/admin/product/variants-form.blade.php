@extends('adminlte::page')

@section('title', 'Variants')

@section('content_header')
    <h1>Variants</h1>
@stop


@section('content')
    <div class="container">
        @livewire('product-variants', ['product' => $product, 'variantSpecifications' => $variant_specifications])
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('generate-variants-btn').addEventListener('click', function() {
            // Get all specification inputs
            const specifications = {};
            const inputs = document.querySelectorAll('#specification-container input');
            inputs.forEach(input => {
                const key = input.name.match(/\[([^\]]+)\]/)[1]; // Extract the key (specification name)
                const values = input.value.split(',').map(value => value.trim()).filter(value =>
                    value); // Split values and trim
                if (values.length > 0) {
                    specifications[key] = values;
                }
            });

            // Check if specifications are valid
            if (Object.keys(specifications).length === 0) {
                alert('Please enter at least one specification with values.');
                return;
            }

            // Generate combinations
            const combinations = generateCombinations(specifications);

            // Populate the variants table
            const tableBody = document.getElementById('variants-table-body');
            tableBody.innerHTML = ''; // Clear the table before adding new rows

            combinations.forEach((combination, index) => {
                const combinationText = combination.map(pair => pair.join(': ')).join(', ');

                const row = `
                <tr>
                    <td>${combinationText}</td>
                    <td><input type="number" name="variants[${index}][price]" class="form-control" placeholder="Enter price" required></td>
                    <td><input type="number" name="variants[${index}][stock]" class="form-control" placeholder="Enter stock" required></td>
                    ${combination.map(([key, value]) => `
                                <input type="hidden" name="variants[${index}][${key}]" value="${value}">
                            `).join('')}
                </tr>
            `;
                tableBody.innerHTML += row;
            });

            // Show the variants container
            document.getElementById('variants-container').classList.remove('d-none');
        });

        // Function to generate all combinations
        function generateCombinations(options) {
            const keys = Object.keys(options);
            if (keys.length === 0) return [];

            const generate = (index) => {
                if (index === keys.length) return [
                    []
                ];

                const currentKey = keys[index];
                const currentValues = options[currentKey];
                const combinations = generate(index + 1);

                return currentValues.flatMap(value =>
                    combinations.map(combination => [
                        [currentKey, value], ...combination
                    ])
                );
            };

            return generate(0);
        }
    </script>
@endsection
