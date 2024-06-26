@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $contact->name }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($contact->avatar)
                                <img src="{{ asset('storage/' . $contact->avatar) }}" alt="{{ $contact->name }}" class="img-fluid">
                            @else
                                <p>No avatar available</p>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                            <p><strong>Contact Number:</strong> {{ $contact->contact_number }}</p>
                            <p><strong>Address:</strong> {{ $contact->address }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Notes:</h4>
                        <button type="button" id="add-note" class="btn btn-secondary">
                            Add Note
                        </button>
                    </div>
                    <div class="row" id="add-note-form" style="display:none">
                        <form method="POST" action="{{ route('notes.store', $contact->id) }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="noteTitle">Title</label>
                                <input type="text" class="form-control" id="noteTitle" name="title" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="noteContent">Content</label>
                                <textarea class="form-control" id="noteContent" name="content" rows="4" required></textarea>
                            </div>
                            <div class="mb-2">
                                <button type="button" class="btn btn-secondary" id="cancel-add-note">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                    @if ($contact->notes->count() > 0)
                        @foreach ($contact->notes as $note)
                        <div class="card mb-3" id="note-{{ $note->id }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>{{ $note->title }}</span>
                                <button type="button" class="btn btn-sm btn-secondary edit-note-btn" data-note-id="{{ $note->id }}">
                                    Edit
                                </button>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $note->note }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p>No notes added for this contact.</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('contacts.index') }}" class="btn btn-primary">Back</a>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $("#add-note").on("click", function(){
            $('#add-note-form').show();
        });

        $("#cancel-add-note").on("click", function(){
            $('#add-note-form').hide();
            $('#add-note-form form')[0].reset();
        });

        $('.edit-note-btn').click(function() {
            var noteId = $(this).data('note-id');
            var cardBody = $('#note-' + noteId);
            var noteTitle = cardBody.find('.card-header span').text().trim();
            var noteText = cardBody.find('.card-body p').text().trim();
            var formHtml = `
                <form method="POST" action="{{ route('notes.update', ['note' => ':noteId']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="noteTitle">Title</label>
                        <input type="text" class="form-control" id="noteTitle" name="title" required value="${noteTitle}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="editNoteContent">Content</label>
                        <textarea class="form-control" id="editNoteContent" name="content" rows="4" required>${noteText}</textarea>
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-secondary cancel-edit-note">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            `;
            cardBody.find('.card-body').html(formHtml.replace(':noteId', noteId));

            // Handle cancel edit
            $('.cancel-edit-note').click(function() {
                cardBody.find('.card-body').html('<p class="card-text">' + noteText + '</p>');
            });
        });
    });
</script>
@endsection
@endsection
