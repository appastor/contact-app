@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Contacts</div>
                <div class="card-body">
                    <a href="{{ route('contacts.create') }}" class="btn btn-primary">Add Contact</a>
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th class="col-1"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr class="align-middle">
                                <td>
                                    @if ($contact->avatar)
                                        <img src="{{ asset('storage/' . $contact->avatar) }}" alt="{{ $contact->name }}" class="img-fluid" style="width: 100%">
                                    @endif
                                </td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->contact_number }}</td>
                                <td>{{ $contact->address }}</td>
                                <td>
                                    <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @foreach($trashed as $contact)
                            <tr class="align-middle">
                                <td>
                                    @if ($contact->avatar)
                                        <img src="{{ asset('storage/' . $contact->avatar) }}" alt="{{ $contact->name }}" class="img-fluid" style="width: 100%">
                                    @endif
                                </td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->contact_number }}</td>
                                <td>{{ $contact->address }}</td>
                                <td>
                                    <form action="{{ route('contacts.restore', $contact->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Restore</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection