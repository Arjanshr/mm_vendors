<div class="card">
    @can('add-orders')
        <div class="card-header">
            <a href="{{ route('order.create') }}" class="btn btn-success">Create Order</a>
        </div>
    @endcan
    <div class="card-body">
        <a href="#" class="btn btn-sm {{ $status == 'all' ? 'btn-warning' : 'btn-primary' }}"
            wire:click="allOrders()">All Orders({{ $count['all'] }})</a>
        @foreach ($order_statuses as $order_status)
            <a href="#" class="btn btn-sm {{ $order_status->value == $status ? 'btn-warning' : 'btn-primary' }}"
                wire:click="filterOrders('{{ $order_status->value }}')">{{ str_replace('_', ' ', ucfirst($order_status->value)) }}
                ({{ $count[$order_status->value] }})
            </a>
        @endforeach

        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Actions</th>
                                <th>Order By</th>
                                <th>Shipping Address</th>
                                <th>Items</th>
                                <th>Ordered at</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $index => $order)
                                <tr>
                                    <td width="20px">{{ $loop->iteration }}</td>
                                    <td>
                                        @can('read-orders')
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-primary"
                                                title="view">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('edit-orders')
                                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-success"
                                                title="Edit">
                                                <i class="fa fa-pen"></i>
                                            </a>
                                        @endcan
                                        @can('delete-orders')
                                            <form method="post" action="{{ route('order.delete', $order->id) }}"
                                                style="display: initial;">
                                                @csrf
                                                @method('delete')
                                                <button class="delete btn btn-danger btn-sm" type="submit" title="Delete"
                                                    onclick="">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                    <td>{{ $order->customer ? $order->customer->name : 'Guest' }}</td>
                                    <td>{!! $order->shipping_address !!}</td>
                                    <td>{{ $order->order_items->count() }}</td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>
                                    <td>
                                        @can('edit-orders')
                                            <select class="form-control" wire:model="order_status.{{ $order->id }}"
                                                wire:change = "change({{ $order->id }})">
                                                @foreach ($order_statuses as $order_status)
                                                    <option value="{{ $order_status->value }}">
                                                        {{ str_replace('_', ' ', ucfirst($order_status->value)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Actions</th>
                                <th>Order By</th>
                                <th>Shipping Address</th>
                                <th>Items</th>
                                <th>Ordered at</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
