<table class="table table-bordered">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @forelse ($rows as $row)
            <tr>
                @foreach ($columns as $column)
                    <td>{!! data_get($row, $column) !!}</td>
                @endforeach
                <td>
                    <a href="{{ route($editRoute, $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route($deleteRoute, $row->id) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) + 1 }}" class="text-center text-muted">No data found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
