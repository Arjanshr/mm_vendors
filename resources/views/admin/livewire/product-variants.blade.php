<div>
    <h1>Create Variants for {{ $product->name }}</h1>

    <form wire:submit.prevent="saveVariants">
        <!-- Specifications -->
        <div>
            @foreach ($variantSpecifications as $specification)
                <div class="form-group">
                    <label for="spec_{{ $specification['id'] }}">{{ $specification['name'] }}</label>
                    <input type="text" 
                           class="form-control" 
                           id="spec_{{ $specification['id'] }}" 
                           wire:model.defer="specifications.{{ $specification['name'] }}" 
                           placeholder="Enter values separated by commas (e.g., 8GB, 16GB)">
                </div>
            @endforeach
        </div>

        <!-- Generate Variants Button -->
        <button type="button" class="btn btn-primary mt-3" wire:click="generateVariants">Generate Variants</button>

        <!-- Variants Table -->
        @if (!empty($variants))
            <div id="variants-container" class="mt-4">
                <h4>Generated Variants</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Variant</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $index => $variant)
                            <tr>
                                <td>{{ $variant['name'] }}</td>
                                <td>
                                    <input type="text" 
                                           wire:model.defer="variants.{{ $index }}.price" 
                                           class="form-control" 
                                           placeholder="Enter price">
                                </td>
                                <td>
                                    <input type="text" 
                                           wire:model.defer="variants.{{ $index }}.stock" 
                                           class="form-control" 
                                           placeholder="Enter stock">
                                </td>
                                <td>
                                    <button type="button" 
                                            wire:click="removeVariant({{ $index }})" 
                                            class="btn btn-danger">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Submit Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save Variants</button>
        </div>
    </form>
</div>
